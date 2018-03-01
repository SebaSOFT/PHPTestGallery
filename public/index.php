<?php
require __DIR__ . '/../vendor/autoload.php';
/**
 * User: SebaSOFT
 * Date: 28/2/2018
 */

$app = new \App\Application();

$app->registerManager('image', new \App\Data\ImageManager($app));

$iController = new \App\Controller\ImageController($app);
$app->registerRoute("GET-ListImages", [$iController, 'getAllImages']);
$app->registerRoute("GET-ShowImage", [$iController, 'showImage']);
$app->registerRoute("OPTIONS-*", [new \App\Controller\CORSController($app), 'handle']);

$app->start();