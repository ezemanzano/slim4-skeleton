<?php

namespace App\Dto;

Class ExampleDto {

    public $id;
    public $username;
    public $email;


    public function __construct(
        $id,
        $name,
        $email       
    )
    {
        $this->id = intval($id);
        $this->username = trim($name);
        $this->email = trim($email);
    }
}
