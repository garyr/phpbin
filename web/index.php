<?php

if (is_dir(__DIR__.'/../vendor')) {
    require_once __DIR__.'/../vendor/autoload.php';
} else if(__DIR__.'/../vendor') {
    require_once __DIR__.'/../../../autoload.php';
} else {
    throw new \Exception("Error loading composer");
}

$app = new Phpbin\Web\Application();
$app->run();
