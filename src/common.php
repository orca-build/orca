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

        $config = new Orca\Components\CommandOptions\CommandOptions($arguments);
        $config->load();

        $rootDir = $config->getProjectDir();
        $absolutePath = (!empty($rootDir)) ? $workingDir . '/' . $rootDir : '';

        if ($config->isShowVersion()) {
            echo "ORCA Build v" . \Orca\Orca::VERSION . PHP_EOL;
            echo "Copyright (c) 2020 - 2021 dasistweb GmbH" . PHP_EOL;
            echo "www.orca-build.io" . PHP_EOL;
            return;
        }

        $generator = new \Orca\Orca($absolutePath);
        $generator->generate($config->isDebugMode());
    }

}
