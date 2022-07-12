<?php

declare(strict_types=1);

namespace App\Service;

class BaseService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

}