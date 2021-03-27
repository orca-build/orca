<?php

namespace Orca\Services;

use Orca\Models\ResourceFile\ResourceFile;

/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class FileCollector
{

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var array
     */
    private $searchedFiles;


    /**
     * FileCollector constructor.
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }


    /**
     * @return array
     */
    public function collectFiles(): array
    {
        $files = $this->searchFiles('/');

        $result = [];

        foreach ($files as $file) {

            $targetName = str_replace($this->basePath . '/', '', $file);
            $targetName = ltrim($targetName, '/');

            $fullPath = realpath($file);

            $filename = basename($fullPath);

            if ($filename === '.DS_Store') {
                continue;
            }

            $result[] = new ResourceFile($targetName, $fullPath, $filename);
        }

        return $result;
    }

    /**
     * Finds all files within all sub folders of the specified file type.
     * e.g. search for all .pid files by providing '.pid' as file type.
     *
     * @param string $dir
     * @return array
     */
    private function searchFiles(string $dir): array
    {
        $this->searchedFiles = [];

        $this->recSearchFiles($this->basePath . $dir);

        return $this->searchedFiles;
    }


    /**
     * This is the private recursive function to search files within
     * a subdirectory structure.
     *
     * @param string $dir
     */
    private function recSearchFiles(string $dir): void
    {
        $ffs = scandir($dir);

        foreach ($ffs as $ff) {

            if ($ff != '.' && $ff != '..') {

                if (is_dir($dir . '/' . $ff)) {
                    $this->recSearchFiles($dir . $ff . '/');
                } else if (strlen($ff) >= 5) {
                    $this->searchedFiles[] = $dir . $ff;
                }
            }
        }
    }

}
