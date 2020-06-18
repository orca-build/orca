<?php

namespace Models\Components\Manifest;

use Orca\Components\Manifest\ManifestReader;
use PHPUnit\Framework\TestCase;

class ManifestReaderTest extends TestCase
{

    /**
     * @var ManifestReader
     */
    private $reader;


    /**
     *
     */
    public function setUp(): void
    {
        $this->reader = new ManifestReader();
    }


    /**
     * This test verifies that our images and
     * all tags are correctly read.
     */
    public function testImagesAndTags()
    {
        $jsonContent = array(
            "images" => array(
                "dev" => array(
                    "1.2:latest",
                )
            ),
        );

        $stringContent = json_encode($jsonContent);

        $manifest = $this->reader->readManifest($stringContent);

        $this->assertEquals('dev', $manifest->getImages()[0]->getName());
        $this->assertEquals('1.2', $manifest->getImages()[0]->getTags()[0]->getSourceName());
        $this->assertEquals('latest', $manifest->getImages()[0]->getTags()[0]->getTargetName());
    }

    /**
     * This test verifies that our shared assets
     * will be read correctly.
     */
    public function testSharedAssets()
    {
        $jsonContent = array(
            "shared_assets" => "template/assets",
        );

        $stringContent = json_encode($jsonContent);

        $manifest = $this->reader->readManifest($stringContent);

        $this->assertEquals('template/assets', $manifest->getSharedAssets());
    }

    /**
     * This test verifies that our shared variables
     * will be read correctly.
     */
    public function testSharedVariables()
    {
        $jsonContent = array(
            "shared_variables" => "./variables.json",
        );

        $stringContent = json_encode($jsonContent);

        $manifest = $this->reader->readManifest($stringContent);

        $this->assertEquals('./variables.json', $manifest->getSharedVariables());
    }

    /**
     * This test verifies that our plugin directory
     * will be read correctly.
     */
    public function testPluginDirectory()
    {
        $jsonContent = array(
            "plugin_directory" => "../plugins",
        );

        $stringContent = json_encode($jsonContent);

        $manifest = $this->reader->readManifest($stringContent);

        $this->assertEquals('../plugins', $manifest->getPluginFolder());
    }

    /**
     * This test verifies that our output directory
     * will be read correctly.
     */
    public function testOutputDirectory()
    {
        $jsonContent = array(
            "output" => "./output",
        );

        $stringContent = json_encode($jsonContent);

        $manifest = $this->reader->readManifest($stringContent);

        $this->assertEquals('./output', $manifest->getOutputDirectory());
    }

    /**
     * This test verifies that we get the
     * default output directory if we didn't
     * provide one.
     */
    public function testDefaultOutputDirectory()
    {
        $jsonContent = array();

        $stringContent = json_encode($jsonContent);

        $manifest = $this->reader->readManifest($stringContent);

        $this->assertEquals('dist', $manifest->getOutputDirectory());
    }

}