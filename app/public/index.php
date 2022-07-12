<?php

ini_set('log_errors', 0);
ini_set('display_errors', -1);
ini_set('display_startup_errors', 1);

require __DIR__ . '/../src/App/App.php';

$app->run();