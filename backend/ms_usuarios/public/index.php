<?php
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

require __DIR__ . '/../app/Config/database.php';

require __DIR__ . '/../app/Config/routes.php';

$app->run();
