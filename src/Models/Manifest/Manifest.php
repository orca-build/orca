<?php

namespace Orca\Models\Manifest;

use Orca\Models\Image\Image;


/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class Manifest
{

    /**
     *
     * @var Image[]
     */
    private $images;

    /**
     * @var string
     */
    private $sharedAssets;

    /**
     * @var string
     */
    private $sharedVariables;

    /**
     * @var string
     */
    private $pluginFolder;

    /**
     * @var string
     */
    private $outputDir;


    /**
     * Manifest constructor.
     * @param array $images
     * @param string $sharedAssets
     * @param string $sharedVariables
     * @param string $pluginFolder
     * @param string $distFolder
     */
    public function __construct(array $images, string $sharedAssets, string $sharedVariables, string $pluginFolder, string $distFolder)
    {
        $this->images = $images;
        $this->sharedAssets = $sharedAssets;
        $this->sharedVariables = $sharedVariables;
        $this->pluginFolder = $pluginFolder;
        $this->outputDir = $distFolder;
    }


    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getSharedAssets(): string
    {
        return $this->sharedAssets;
    }

    /**
     * @return string
     */
    public function getSharedVariables(): string
    {
        return $this->sharedVariables;
    }

    /**
     * @return mixed
     */
    public function getPluginFolder()
    {
        return $this->pluginFolder;
    }

    /**
     * @return string
     */
    public function getOutputDirectory(): string
    {
        return $this->outputDir;
    }

}
