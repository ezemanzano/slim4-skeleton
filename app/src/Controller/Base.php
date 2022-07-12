<?php 

declare (strict_types = 1);

namespace App\Controller;

use Pimple\Psr11\Container;

class Base{

    protected $container;
    protected $service;

	public function __construct(Container $container, string $service)
	{
		$this->container = $container;
        $this->service = $container->get($service);
	}

}