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
     * DirectoyService constructor.
     *
     * @param $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }


    /**
     * @return array
     */
    public function collectFiles(): array
    {
        $files = $this->searchFiles('/');

        $result = array();

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
     * Finds all files within all subfolders of the specified file type.
     * e.g. search for all .pid files by providing '.pid' as file type.
     *
     * @param $dir
     * @param $fileType
     * @return array
     */
    private function searchFiles($dir)
    {
        $this->searchedFiles = array();

        $this->recSearchFiles($this->basePath . $dir);

        return $this->searchedFiles;
    }


    /**
     * This is the private recursive function to search files within
     * a subdirectory structure.
     *
     * @param $dir
     * @param $fileType
     */
    private function recSearchFiles($dir)
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