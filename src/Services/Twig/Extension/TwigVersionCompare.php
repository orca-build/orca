<?php

namespace Orca\Services\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @copyright 2021 dasistweb GmbH (https://www.dasistweb.de)
 */
class TwigVersionCompare extends AbstractExtension
{


    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('version_gt', [$this, 'versionGT']),
            new TwigFunction('version_gte', [$this, 'versionGTE']),
            new TwigFunction('version_lt', [$this, 'versionLT']),
            new TwigFunction('version_lte', [$this, 'versionLTE']),
        ];
    }

    /**
     * @param string $versionA
     * @param string $versionB
     * @return bool
     */
    public function versionGT(string $versionA, string $versionB)
    {
        return $this->compare($versionA, $versionB) > 0;
    }

    /**
     * @param string $versionA
     * @param string $versionB
     * @return bool
     */
    public function versionGTE(string $versionA, string $versionB)
    {
        return $this->compare($versionA, $versionB) >= 0;
    }

    /**
     * @param string $versionA
     * @param string $versionB
     * @return bool
     */
    public function versionLT(string $versionA, string $versionB)
    {
        return $this->compare($versionA, $versionB) < 0;
    }

    /**
     * @param string $versionA
     * @param string $versionB
     * @return bool
     */
    public function versionLTE(string $versionA, string $versionB)
    {
        return $this->compare($versionA, $versionB) <= 0;
    }

    /**
     * @param string $versionA
     * @param string $versionB
     * @return bool|int
     */
    private function compare(string $versionA, string $versionB)
    {
        return version_compare($versionA, $versionB);
    }

}
