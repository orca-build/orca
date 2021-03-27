<?php

namespace Orca\Models\Image;


/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class Image
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Tag[]
     */
    private $tags = [];


    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): void
    {
        $this->tags[] = $tag;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

}
