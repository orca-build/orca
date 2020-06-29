<?php

namespace Models\Components\CommandArguments;

use Orca\Components\CommandArguments\CommandArguments;
use PHPUnit\Framework\TestCase;


class CommandArgumentsTest extends TestCase
{

    /**
     * This test verifies that our provided
     * root directory argument is correctly read.
     */
    public function testRootDir()
    {
        $argReader = new CommandArguments(array('--directory=./src'));

        $argReader->load();

        $this->assertEquals('./src', $argReader->getRootDir());
    }

}
