<?php
declare(strict_types=1);

namespace MoptWordline;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;

class MoptWordline extends Plugin
{
    const PLUGIN_NAME = 'MoptWordline';

    const PLUGIN_VERSION = '0.0.1';

    /**
     * @param InstallContext $installContext
     * @return void
     */
    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
    }
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
