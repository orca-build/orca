<?php

namespace Orca\Tests\phpunit\Services\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Orca\Services\Twig\Extension\TwigVersionCompare;

/**
 * @copyright 2021 dasistweb GmbH (https://www.dasistweb.de)
 */
class TwigVersionCompareTest extends TestCase
{

    /**
     *
     */
    public function testCompareGT()
    {
        $comparer = new TwigVersionCompare();

        $this->assertEquals(true, $comparer->versionGT('6.4', '6.3'));
        $this->assertEquals(true, $comparer->versionGT('6.4.2', '6.4'));

        $this->assertEquals(false, $comparer->versionGT('6.4', '6.4.2'));
        $this->assertEquals(false, $comparer->versionGT('6.3', '6.4'));
        $this->assertEquals(false, $comparer->versionGT('6.3', '6.3'));
    }

    /**
     *
     */
    public function testCompareGTE()
    {
        $comparer = new TwigVersionCompare();

        $this->assertEquals(true, $comparer->versionGTE('6.4', '6.4'));
        $this->assertEquals(true, $comparer->versionGTE('6.4.2', '6.4'));
        $this->assertEquals(true, $comparer->versionGTE('6.4.2.1', '6.4.2.0'));

        $this->assertEquals(false, $comparer->versionGTE('6.4', '6.4.2'));
        $this->assertEquals(false, $comparer->versionGTE('6.3', '6.4'));
    }

    /**
     *
     */
    public function testCompareLT()
    {
        $comparer = new TwigVersionCompare();

        $this->assertEquals(true, $comparer->versionLT('6.3', '6.4'));
        $this->assertEquals(true, $comparer->versionLT('6.3.2', '6.4'));

        $this->assertEquals(false, $comparer->versionLT('6.4', '6.4'));
        $this->assertEquals(false, $comparer->versionLT('6.5', '6.4'));
        $this->assertEquals(false, $comparer->versionLT('6.4.1', '6.4'));
    }

    /**
     *
     */
    public function testCompareLTE()
    {
        $comparer = new TwigVersionCompare();

        $this->assertEquals(true, $comparer->versionLTE('6.4', '6.4'));
        $this->assertEquals(true, $comparer->versionLTE('6.3', '6.4'));
        $this->assertEquals(true, $comparer->versionLTE('6.3.2', '6.4'));

        $this->assertEquals(false, $comparer->versionLTE('6.5', '6.4'));
        $this->assertEquals(false, $comparer->versionLTE('6.4.1', '6.4'));
    }

}