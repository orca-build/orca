<?php

namespace Orca\Tests\Models\Components\CommandOptions;

use Orca\Components\CommandOptions\CommandOptions;
use PHPUnit\Framework\TestCase;

class CommandOptionsTest extends TestCase
{

    /**
     * This test verifies that our provided
     * root directory argument is correctly read.
     */
    public function testProjectDir()
    {
        $argReader = new CommandOptions(array('--directory=./src'));

        $argReader->load();

        $this->assertEquals('./src', $argReader->getProjectDir());
    }

}
