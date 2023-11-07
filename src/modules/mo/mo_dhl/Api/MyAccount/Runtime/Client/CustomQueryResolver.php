<?php

namespace Mediaopt\DHL\Api\MyAccount\Runtime\Client;

use Symfony\Component\OptionsResolver\Options;
interface CustomQueryResolver
{
    public function __invoke(Options $options, $value);
}