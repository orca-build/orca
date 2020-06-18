<?php


namespace Orca\Components\Manifest;

use Orca\Models\Image\Image;
use Orca\Models\Image\Tag;
use Orca\Models\Manifest\Manifest;

/**
 * @copyright 2020 dasistweb GmbH (https://www.dasistweb.de)
 */
class ManifestReader
{

    /**
     * @param string $content
     * @return Manifest
     */
    public function readManifest(string $content): Manifest
    {
        $data = json_decode($content, true);
        
        $images = $this->getImages($data);
        $sharedAssets = $this->getSharedAssets($data);
        $sharedVariables = $this->getSharedVariables($data);
        $plugins = $this->getPluginDirectory($data);
        $output = $this->getDistFolder($data);

        return new Manifest(
            $images,
            $sharedAssets,
            $sharedVariables,
            $plugins,
            $output
        );
    }


    /**
     * @param array $data
     * @return array
     */
    private function getImages(array $data): array
    {
        if (!isset($data['images'])) {
            return array();
        }
        
        $list = array();

        foreach ($data['images'] as $image => $tags) {

            $img = new Image($image);

            /** @var string $tag */
            foreach ($tags as $tag) {
                $parts = explode(':', $tag);
                $img->addTag(new Tag($parts[0], $parts[1]));
            }

            $list[] = $img;
        }

        return $list;
    }

    /**
     * @param array $data
     * @return string
     */
    private function getSharedAssets(array $data): string
    {
        if (!isset($data['shared_assets'])) {
            return '';
        }
        
        if (!empty($data['shared_assets'])) {
            return (string)$data['shared_assets'];
        }

        return '';
    }

    /**
     * @param array $data
     * @return string
     */
    private function getSharedVariables(array $data): string
    {
        if (!isset($data['shared_variables'])) {
            return '';
        }
        
        if (!empty($data['shared_variables'])) {
            return (string)$data['shared_variables'];
        }

        return '';
    }

    /**
     * @param array $data
     * @return string
     */
    private function getPluginDirectory(array $data): string
    {
        if (!isset($data['plugin_directory'])) {
            return '';
        }
        
        if (!empty($data['plugin_directory'])) {
            return (string)$data['plugin_directory'];
        }

        return '';
    }

    /**
     * @param array $data
     * @return string
     */
    private function getDistFolder(array $data): string
    {
        if (!isset($data['output'])) {
            return 'dist';
        }
        
        if (!empty($data['output'])) {
            return (string)$data['output'];
        }

        return 'dist';
    }

}