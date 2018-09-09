#!/usr/bin/env php
<?php

use Fathom\ImageToolCommand;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/options.php';

$application = new Application();

$application->add(new ImageToolCommand());

$application->run();