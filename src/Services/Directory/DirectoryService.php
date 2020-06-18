<?php

namespace Orca\Services\Directory;

/**
 * @copyright dasistweb GmbH (http://www.dasistweb.de)
 */
class DirectoryService
{

    /**
     * @param string $dir
     */
    public function createDirectory(string $dir)
    {
        if (file_exists($dir) === false) {
            mkdir($dir, 0777, true);
        }
    }


    /**
     * @param string $src
     * @throws \Exception
     */
    public function deleteDirectory(string $src)
    {
        $dir = opendir($src);

        if ($dir === false) {
            throw new \Exception('Directory not found: ' . $src);
        }

        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src . '/' . $file;
                if (is_dir($full)) {
                    $this->deleteDirectory($full);
                } else {
                    unlink($full);
                }
            }
        }

        closedir($dir);
        rmdir($src);
    }


}
