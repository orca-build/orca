<?php

namespace Orca;

use Orca\Components\Compiler\Compiler;
use Orca\Components\Manifest\ManifestReader;
use Orca\Components\Variables\Variables;
use Orca\Models\Image\Image;
use Orca\Models\Image\Tag;
use Orca\Models\Manifest\Manifest;
use Orca\Models\ResourceFile\ResourceFile;
use Orca\Services\Directory\DirectoryService;
use Orca\Services\FileCollector;

/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class Orca
{

    /**
     *
     */
    public const VERSION = "1.3";

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var Manifest
     */
    private $manifest;

    /**
     * @var DirectoryService
     */
    private $directoryService;


    /**
     * Orca constructor.
     * @param string $rootDir
     */
    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
        $this->directoryService = new DirectoryService();
    }


    /**
     * Generates all required Dockerfile artefacts and build files
     * from your Orca sources and variants.
     *
     * @param bool $debugMode
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function generate(bool $debugMode)
    {
        echo '  ____  _____   _____' . PHP_EOL;
        echo ' / __ \|  __ \ / ____|   /\ ' . PHP_EOL;
        echo '| |  | | |__) | |       /  \ ' . PHP_EOL;
        echo '| |  | |  _  /| |      / /\ \ ' . PHP_EOL;
        echo '| |__| | | \ \| |____ / ____ \ ' . PHP_EOL;
        echo ' \____/|_|  \_\\______/_/    \_\ ' . PHP_EOL;
        echo '' . PHP_EOL;

        $configReader = new ManifestReader();

        $configFile = $this->rootDir . '/manifest.json';

        if (!file_exists($configFile)) {
            throw new \Exception('ConfigFile not found in Image path');
        }

        # now read our configuration and
        # create a new configuration object
        $manifestContent = file_get_contents($configFile);
        $this->manifest = $configReader->readManifest($manifestContent);


        $compileRoot = $this->getCompileRoot();

        echo ">> cleaning compile directory...\n";
        if (file_exists($compileRoot)) {
            $this->directoryService->deleteDirectory($compileRoot);
        }

        $this->directoryService->createDirectory($compileRoot);

        $templateRoot = "{$this->rootDir}/template";


        $templateFolders = [
            $templateRoot . '/..',
        ];

        if (!empty($this->manifest->getPluginFolder())) {
            $templateFolders[] = $this->rootDir . '/' . $this->manifest->getPluginFolder();
        }

        $fileCompiler = new Compiler($templateFolders);


        $sharedFiles = [];

        # add shared assets if existing
        if (!empty($this->manifest->getSharedAssets())) {
            $assetsCollector = new FileCollector($templateRoot . '/../' . $this->manifest->getSharedAssets());
            $sharedFiles = $assetsCollector->collectFiles();
        }


        $globalVariables = [];

        if (!empty($this->manifest->getSharedVariables())) {
            $globalVariables = json_decode(file_get_contents($this->rootDir . '/' . $this->manifest->getSharedVariables()), true);
        }

        if ($globalVariables === null) {
            $globalVariables = [];
        }

        echo ">> generating images and tags...\n";
        foreach ($this->manifest->getImages() as $image) {

            /** @var Tag $tag */
            foreach ($image->getTags() as $tag) {

                $sourceDir = "{$this->rootDir}/variants/" . $tag->getSourceName();
                $targetDir = $this->getImageTargetDir($image, $tag);

                $this->compileTag(
                    $sourceDir,
                    $targetDir,
                    $image->getName(),
                    $tag->getTargetName(),
                    $globalVariables,
                    $fileCompiler,
                    $sharedFiles,
                    $debugMode
                );
            }
        }
    }


    /**
     * @return string
     */
    private function getCompileRoot()
    {
        return "{$this->rootDir}/{$this->manifest->getOutputDirectory()}/images";
    }

    /**
     * @param Image $image
     * @param Tag $tag
     * @return string
     */
    private function getImageTargetDir(Image $image, Tag $tag): string
    {
        return $this->getCompileRoot() . '/' . $image->getName() . '/' . $tag->getTargetName();
    }

    /**
     * @param string $sourceDir
     * @param string $targetDir
     * @param string $imgName
     * @param string $tagName
     * @param array $globalVars
     * @param Compiler $fileCompiler
     * @param array $sharedFiles
     * @param bool $debug
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function compileTag(string $sourceDir, string $targetDir, string $imgName, string $tagName, array $globalVars, Compiler $fileCompiler, array $sharedFiles, bool $debug)
    {
        if ($debug) {
            echo "Generating: " . $imgName . ':' . $tagName . PHP_EOL;
        }

        if (!file_exists($sourceDir)) {
            throw new \Exception("No source code found for tag '" . $tagName . PHP_EOL . "Ensure that it exists or remove it from manifest.json");
        }

        $variablesProvider = new Variables($imgName, $tagName);

        if (file_exists($sourceDir . '/variables.json')) {
            /** @var array $variables */
            $variables = json_decode(file_get_contents($sourceDir . '/variables.json'), true);
        } else {
            $variables = [];
        }

        $this->directoryService->createDirectory($targetDir);


        $variables = array_replace_recursive($globalVars, $variables);

        if ($debug) {
            # add log output about the used variables
            file_put_contents($targetDir . '/orca_variables.json', json_encode($variables));
        }


        $collector = new FileCollector($sourceDir);

        $files = $collector->collectFiles();

        $variables = $variablesProvider->prepareVariables($variables);

        # first shared files
        # then overwrite with our required files
        /** @var ResourceFile $file */
        foreach ($sharedFiles as $file) {

            try {
                $fileCompiler->compileFile($file->getFullFilePathName(), $targetDir . '/' . $file->getTargetName(), $variables);
            } catch
            (\Exception $ex) {
                echo "WARNING, an error occurred in tag '" . $tagName . "', file '" . $file->getFullFilePathName() . "'" . PHP_EOL;
                throw $ex;
            }
        }

        /** @var ResourceFile $file */
        foreach ($files as $file) {

            try {
                $fileCompiler->compileFile($file->getFullFilePathName(), $targetDir . '/' . $file->getTargetName(), $variables);
            } catch (\Exception $ex) {
                echo "WARNING, an error occurred in tag '" . $tagName . "', file '" . $file->getFullFilePathName() . "'" . PHP_EOL;
                throw $ex;
            }
        }


    }

}
