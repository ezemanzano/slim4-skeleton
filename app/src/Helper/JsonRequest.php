<?php

namespace App\Helper;

final class JsonRequest
{
    public static function formatData(
        array $data,
        array $params

    ): array {
        
        $dataFormat = [];

        foreach ($data as $indexData => $itData) {
            foreach ($params as $indexParams => $itParams) {
                if($indexData === $indexParams){
                    switch ($itParams) {
                        case 'string':
                            $dataFormat[$indexData] = trim($itData);
                            break;
                        case 'intval':
                            $dataFormat[$indexData] = intval($itData);
                            break;
                        case 'floatval':
                            $dataFormat[$indexData] = floatval($itData);
                            break;
                        case 'boolval':
                            $dataFormat[$indexData] = boolval($itData);
                            break;
                        default:
                            $dataFormat[$indexData] = $itData;
                            break;
                    }
                } 
            }
        }

        return $dataFormat;
    }
}