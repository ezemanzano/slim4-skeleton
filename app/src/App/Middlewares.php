<?php

declare(strict_types=1);

$BASE_PATH = $_SERVER['BASE_PATH'] ?? '';

$app->setBasePath($BASE_PATH);
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$DEBUG = (boolean) $_SERVER['DEBUG'] ?? false;

$errorMiddleware = $app->addErrorMiddleware($DEBUG, true, true);

if(!$DEBUG){
	$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
}
 


