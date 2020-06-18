<?php

namespace Orca\Models\Image;


/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class Tag
{

    /**
     * @var string
     */
    private $sourceName;

    /**
     * @var string
     */
    private $targetName;


    /**
     * @param string $name
     * @param string $alias
     */
    public function __construct(string $name, string $alias)
    {
        $this->sourceName = $name;
        $this->targetName = $alias;
    }

    /**
     * @return string
     */
    public function getSourceName(): string
    {
        return $this->sourceName;
    }

    /**
     * @return string
     */
    public function getTargetName(): string
    {
        return $this->targetName;
    }

}
