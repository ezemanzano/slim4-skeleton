<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException as NotFound;

$app->map(
	[
		'GET',
		'POST',
		'PUT',
		'DELETE',
		'PATCH'
	], '/{routes:.+}', function (Request $request): void{
        throw new NotFound($request);
});