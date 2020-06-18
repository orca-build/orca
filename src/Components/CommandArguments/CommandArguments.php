<?php

namespace Orca\Components\CommandArguments;

/**
 * @copyright dasistweb GmbH (http://www.dasistweb.de)
 */
class CommandArguments
{

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var string
     */
    private $rootDir = '';


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
        $this->rootDir = '';

        /** @var string $arg */
        while ($arg = array_shift($this->arguments)) {

            if ($this->stringStartsWith('--directory=', $arg)) {
                $this->rootDir = str_replace('--directory=', '', $arg);
            }
        }
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
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
