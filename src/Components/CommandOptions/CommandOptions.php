<?php

namespace Orca\Components\CommandOptions;

/**
 * @copyright dasistweb GmbH (http://www.dasistweb.de)
 */
class CommandOptions
{

    /**
     * @var bool
     */
    private $debugMode;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var string
     */
    private $projectDir = '';

    /**
     * @var string
     */
    private $image = '';

    /**
     * @var bool
     */
    private $showVersion;


    /**
     * CommandArguments constructor.
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->arguments = $args;
    }

    /**
     * Loads and extracts all arguments and
     * options from our list.
     * Only the values that matter will be read.
     */
    public function load()
    {
        $this->projectDir = '';

        $this->debugMode = false;
        $this->showVersion = false;


        /** @var string $arg */
        while ($arg = array_shift($this->arguments)) {

            if ($this->stringStartsWith('--directory=', $arg)) {
                $this->projectDir = str_replace('--directory=', '', $arg);
            }

            if ($this->stringStartsWith('--image=', $arg)) {
                $this->image = str_replace('--image=', '', $arg);
            }

            if ($this->stringStartsWith('--debug', $arg)) {
                $this->debugMode = true;
            }

            if ($this->stringStartsWith('--version', $arg)) {
                $this->showVersion = true;
            }
        }
    }

    /**
     * @return string
     */
    public function getProjectDir()
    {
        return $this->projectDir;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return bool
     */
    public function isDebugMode()
    {
        return $this->debugMode;
    }

    /**
     * @return bool
     */
    public function isShowVersion(): bool
    {
        return $this->showVersion;
    }
    

    /**
     * @param $search
     * @param $text
     * @return bool
     */
    private function stringStartsWith($search, $text)
    {
        if (strpos($text, $search) === 0) {
            return true;
        }

        return false;
    }

}
