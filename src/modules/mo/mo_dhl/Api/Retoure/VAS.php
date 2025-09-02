<?php

namespace Mediaopt\DHL\Api\Retoure;

/**
 * @author Mediaopt GmbH
 */
class VAS extends SwaggerModel
{
    /**
     * @var bool
     */
    protected $goGreenPlus;

    /**
     * @return bool
     */
    public function getGoGreenPlus()
    {
        return $this->goGreenPlus;
    }

    /**
     * @param bool $goGreenPlus
     * @return $this
     */
    public function setGoGreenPlus($goGreenPlus)
    {
        $this->goGreenPlus = $goGreenPlus;

        return $this;
    }
}
