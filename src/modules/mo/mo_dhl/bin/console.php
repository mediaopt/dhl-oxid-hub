#!/usr/bin/env php
<?php
require __DIR__ . '/../../../../bootstrap.php';

use Mediaopt\DHL\cli\CreateLabels;
use Symfony\Component\Console\Application;

$application = new Application();

$application->addCommands([
    new CreateLabels(),
]);

$application->run();
