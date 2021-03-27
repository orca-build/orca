<?php

use Orca\Commands\GenerateCommand;
use Orca\Orca;
use Symfony\Component\Console\Application;


class AppManager
{

    /**
     * @throws Exception
     */
    public static function run(): void
    {
        $application = new Application('ORCA', Orca::VERSION);

        $cmdGenerate = new GenerateCommand();
        $application->add($cmdGenerate);

        $application->setDefaultCommand($cmdGenerate->getName());

        $application->run();
    }

}
