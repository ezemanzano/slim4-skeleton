<?php

namespace App\Helper;

use Psr\Http\Message\ResponseInterface as Response;

final class Pagination
{
    public static function setPagination($limit ,$offset){
        
        if($limit != null && $offset != null){
            if($limit > $_ENV['MAX_LIMIT']){
                throw new \Exception(
                    "El límite máximo es de ".$_ENV['MAX_LIMIT'],
                    400
                );
            }
            if($offset > $_ENV['MAX_OFFSET']){
                throw new \Exception(
                    "El offset máximo es de ".$_ENV['MAX_OFFSET'],
                    400
                );
            }
           return ['limit' => intval($limit), 'offset' => intval($offset)];
        }else{
            return ['limit' => intval($_ENV['DEFAULT_LIMIT']), 'offset' => intval($_ENV['DEFAULT_OFFSET'])];
        }

    }

}