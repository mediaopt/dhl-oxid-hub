<?php

namespace Mediaopt\DHL\Api\GKV;

class Version
{

    /**
     * @var string $majorRelease
     */
    protected $majorRelease = null;

    /**
     * @var string $minorRelease
     */
    protected $minorRelease = null;

    /**
     * @var string $build
     */
    protected $build = null;

    /**
     * @param string $majorRelease
     * @param string $minorRelease
     * @param string $build
     */
    public function __construct($majorRelease, $minorRelease, $build)
    {
        $this->majorRelease = $majorRelease;
        $this->minorRelease = $minorRelease;
        $this->build = $build;
    }

    /**
     * @return string
     */
    public function getMajorRelease()
    {
        return $this->majorRelease;
    }

    /**
     * @param string $majorRelease
     * @return Version
     */
    public function setMajorRelease($majorRelease)
    {
        $this->majorRelease = $majorRelease;
        return $this;
    }

    /**
     * @return string
     */
    public function getMinorRelease()
    {
        return $this->minorRelease;
    }

    /**
     * @param string $minorRelease
     * @return Version
     */
    public function setMinorRelease($minorRelease)
    {
        $this->minorRelease = $minorRelease;
        return $this;
    }

    /**
     * @return string
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @param string $build
     * @return Version
     */
    public function setBuild($build)
    {
        $this->build = $build;
        return $this;
    }

}
