<?php

namespace Orca\Models\ResourceFile;


/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class ResourceFile
{

    /**
     * @var string
     */
    private $targetName;

    /**
     * @var string
     */
    private $fullFilePathName;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @param string $targetName
     * @param string $fullFilePathName
     * @param string $fileName
     */
    public function __construct(string $targetName, string $fullFilePathName, string $fileName)
    {
        $this->targetName = $targetName;
        $this->fullFilePathName = $fullFilePathName;
        $this->fileName = $fileName;
    }


    /**
     * @return string
     */
    public function getTargetName(): string
    {
        return $this->targetName;
    }

    /**
     * @return string
     */
    public function getFullFilePathName(): string
    {
        return $this->fullFilePathName;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

}
