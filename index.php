<?php

// Include Composer autoloader if not already done.
require_once __DIR__ . "/vendor/autoload.php";

$app = new Src\App();
$app->index();