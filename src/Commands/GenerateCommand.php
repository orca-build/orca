<?php

namespace Orca\Commands;

use Orca\Orca;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class GenerateCommand extends Command
{

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('generate')
            ->setDescription('Generates files for the provided configuration file')
            ->addOption('directory', null, InputOption::VALUE_REQUIRED, '', '')
            ->addOption('debug', null, InputOption::VALUE_NONE, '');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        echo "ORCA Build v" . Orca::VERSION . PHP_EOL;
        echo "Copyright (c) 2020 - 2021 dasistweb GmbH" . PHP_EOL;
        echo "www.orca-build.io" . PHP_EOL;

        $io = new SymfonyStyle($input, $output);

        $projectDirectory = (string)$input->getOption('directory');
        $debug = ($input->getOption('debug') !== false);

        if ($debug) {
            echo PHP_EOL;
            echo "Debug Mode: active" . PHP_EOL;
        }

        $projectDirectoryAbsolute = $this->getAbsolutePath($projectDirectory);

        echo PHP_EOL;
        echo "Project: " . $projectDirectoryAbsolute . PHP_EOL;
        echo PHP_EOL;


        $generator = new Orca($projectDirectoryAbsolute);

        $generator->generate($debug);

        $io->success('Docker files generated successfully!');
        return 0;
    }


    /**
     * @param string $filename
     * @return string
     */
    private function getAbsolutePath(string $filename): string
    {
        if (empty($filename)) {
            return '';
        }

        $cur_dir = explode('\\', getcwd());
        $workingDir = $cur_dir[count($cur_dir) - 1];

        return $workingDir . '/' . $filename;
    }

}
