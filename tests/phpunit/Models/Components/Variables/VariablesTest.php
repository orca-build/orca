<?php

namespace Orca\Tests\Models\Components\Variables;


use Orca\Components\Variables\Variables;
use PHPUnit\Framework\TestCase;

class VariablesTest extends TestCase
{

    /**
     * This test verifies that our image
     * variable is always present
     */
    public function testOrcaImage()
    {
        $varBuilder = new Variables('dev', 'latest');

        $variables = $varBuilder->prepareVariables([]);

        $this->assertEquals('dev', $variables['orca']['image']);
    }

    /**
     * This test verifies that our tag
     * variable is always present
     */
    public function testOrcaTag()
    {
        $varBuilder = new Variables('dev', 'latest');

        $variables = $varBuilder->prepareVariables([]);

        $this->assertEquals('latest', $variables['orca']['tag']);
    }

    /**
     * This test verifies that our generation date
     * variable is always present
     */
    public function testOrcaGenerateDate()
    {
        $varBuilder = new Variables('dev', 'latest');

        $variables = $varBuilder->prepareVariables([]);

        $this->assertEquals(date("D M d, Y G:i"), $variables['orca']['generate_date']);
    }

}