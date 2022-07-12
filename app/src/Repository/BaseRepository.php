<?php

declare(strict_types=1);

namespace App\Repository;

class BaseRepository
{
   	protected $database;

 	public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function getDb(): \PDO
    {
        return $this->database;
    }

}