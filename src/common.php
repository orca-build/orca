<?php

/**
 * @copyright dasistweb GmbH (http://www.dasistweb.de)
 */
class AppManager
{
    
    /**
     * @param array $arguments
     */
    public static function run(array $arguments)
    {
        $cur_dir = explode('\\', getcwd());
        $workingDir = $cur_dir[count($cur_dir) - 1];

        $config = new Orca\Components\CommandArguments\CommandArguments($arguments);
        $config->load();

        $rootDir = $config->getRootDir();
        $absolutePath = (!empty($rootDir)) ? $workingDir . '/' . $rootDir : '';

        $generator = new \Orca\Orca($absolutePath);
        $generator->generate();
    }

}
