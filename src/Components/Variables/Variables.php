<?php

namespace Orca\Components\Variables;

class Variables
{

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $tag;


    /**
     * VariablesProvider constructor.
     *
     * @param string $image
     * @param string $tag
     */
    public function __construct(string $image, string $tag)
    {
        $this->image = $image;
        $this->tag = $tag;
    }

    /**
     * @param array $originalVariables
     * @return array
     */
    public function prepareVariables(array $originalVariables): array
    {
        $originalVariables['orca'] = array(
            'image' => $this->image,
            'tag' => $this->tag,
            'generate_date' => date("D M d, Y G:i"),
        );

        return $originalVariables;
    }

}
