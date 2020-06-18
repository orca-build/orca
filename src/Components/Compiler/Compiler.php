<?php

namespace Orca\Components\Compiler;

use Orca\Services\Directory\DirectoryService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class Compiler
{

    /**
     * @var array
     */
    private $templateDirectories;


    /**
     * @param array $templateDirectories
     */
    public function __construct(array $templateDirectories)
    {
        $this->templateDirectories = $templateDirectories;
    }


    /**
     * @param string $filename
     * @param string $outputFile
     * @param array $variables
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function compileFile(string $filename, string $outputFile, array $variables)
    {

        $loader = new FilesystemLoader();

        /** @var string $dir */
        foreach ($this->templateDirectories as $dir) {

            $dir = realpath($dir);

            $loader->addPath($dir);

            # replace to get only relative path within directories
            $filename = str_replace($dir, '', $filename);
        }

        if ($this->endsWith($filename, 'variables.json')) {

            # that's our config,
            # skip that
            return;
        }

        $options = array(
            'cache' => false,
            'debug' => false,
            'strict_variables' => true,
        );

        $twig = new Environment($loader, $options);


        $outputFile = str_replace('Dockerfile.sh.twig', 'Dockerfile', $outputFile);
        $outputFile = str_replace('.twig', '', $outputFile);

        $template = $twig->load($filename);

        $content = $template->render($variables);


        $dir = dirname($outputFile);

        if (!is_dir($dir)) {
            // dir doesn't exist, make it
            $dirService = new DirectoryService();
            $dirService->createDirectory($dir);
        }

        # remove 2+ duplicate new lines to
        # have it pretty ;)
        $content = preg_replace("/([\r\n]{4,}|[\n]{2,}|[\r]{2,})/", "\n\n", $content);

        file_put_contents($outputFile, $content);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

}
