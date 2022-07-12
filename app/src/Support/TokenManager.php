<?php
namespace App\Support;

use \Firebase\JWT\JWT;


class TokenManager{


    private static $secret_key = 'B90egY2FPaCtd2LMH3olKe63l548Mh9C@';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function makeToken($user)
    {
        $time = time();

        $payload = array(
            'exp' => $time + (60*60*3),
            'aud' => self::getAudFromHttp(),
            'user' => $user,
            'iat' => $time,
            'nbf' => $time
        );

        return JWT::encode($payload, self::$secret_key);
    }


    public static function killToken($token)
    {
        return JWT::revoke($token);
    }


    private static function getAudFromHttp()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }

    public static function getTokenFromRequest()
    {
        $headers = self::getAuthorizationHeader();

        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        if ($headers == null){
            return null; #TODO
           /*  throw new \Exception(
                "Se requieren de credenciales para utilizar este recurso",
                401
            ); */
        }

        throw new \Exception(
            "No autenticado.",
            401

        );
    }

    public static function getAuthorizationHeader()
    {

        $headers = null;

        if (isset($_SERVER['Authorization'])) {

            $headers = trim($_SERVER["Authorization"]);

        }else if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {

            $headers = trim($_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);

        } else if (function_exists('apache_request_headers')) {

            $requestHeaders = apache_request_headers();

            /**
             * Server-side fix for bug in old Android versions (a nice side-effect of
             * this fix means we don't care about capitalization for Authorization)
             */

            $requestHeaders = array_combine(
                array_map(
                    'ucwords',
                    array_keys($requestHeaders)
                ),
                array_values($requestHeaders)
            );
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }

        }

        return $headers;
    }

    public static function getUserFromToken($token)
    {
        try
        {
            $payload = JWT::decode($token, TokenManager::$secret_key, array('HS256'));
             return $payload->user;
        }
        catch(\Firebase\JWT\BeforeValidException $e){
            throw new \Exception(
                $e->getMessage(),
                401
            );
        }
        catch(\Firebase\JWT\ExpiredException $e){
            throw new \Exception(
                $e->getMessage(),
                401
            );
        }
        catch(\Firebase\JWT\SignatureInvalidException $e){
            throw new \Exception(
                $e->getMessage(),
                401
            );
        }
        catch(Exception $e){
            throw new \Exception(
                $e->getMessage(),
                401
            );
        }
        return null;
    }



}
?>
