#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\Commands\CreateUserCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$requirePassword = true;

$application->add(new CreateUserCommand);

$application->run();