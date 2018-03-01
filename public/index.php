<?php
require __DIR__ . '/../vendor/autoload.php';
/**
 * User: SebaSOFT
 * Date: 28/2/2018
 */

$app = new \App\Application();

$app->registerRoute("GET-ListImages", [new \App\Controller\ImageController($app), 'getAllImages']);
$app->registerRoute("OPTIONS-*", [new \App\Controller\CORSController($app), 'handle']);

$app->start();