<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\JsonResponse;
use App\Helper\JsonRequest;

use Pimple\Psr11\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use App\Support\PasswordRecovery;

use App\Controller\Base;

final class Auth extends Base
{

    public function __construct(Container $container)
    {
        parent::__construct($container, 'auth_service');
    }

    /**
     * Login de usuario
     * @param Request $request contiente todos los atributos de la peticion
     * @param Response $response contiente todos los atributos de la respuesta
     * @return object
     */

    public function login(Request $request, Response $response)
    {
        try {

            // Obtenemos los datos

            $formData = (array) $request->getParsedBody();

            // Limpiamos los datos

            $data = JsonRequest::formatData((array) $formData, [
                'email' => 'string',
                'password' => 'string',
                'user' => 'string',
                'mode' => 'string'           
            ]);

            if(isset($data['mode'])){
                $mode = $data['mode'];
            }else{
                $mode = 'api';
            }
           
            
            $login = $this->service->login($data);
            #$metric = $this->service->saveMetric($mode);
            
        } catch (Exception $e) {         
            return JsonResponse::withJson(
                $response,
                json_encode('Error: '.$_SERVER['DEBUG'] ? $e->getMessage() : ''),
                $e->getCode()
            );
        }

        return JsonResponse::withJson(
            $response,
            json_encode($login),
            200
        );
    }

    /*
     * devuelve el objeto user 
     * @param Request $request contiente todos los atributos de la peticion
     * @param Response $response contiente todos los atributos de la respuesta
     * @return object
     */

    public function logout(Request $request, Response $response)
    {
        try {
              $success = ["success" => "ok"];

        } catch (Exception $e) {
            return JsonResponse::withJson(
                $response,
                json_encode('Error: '.$_SERVER['DEBUG'] ? $e->getMessage() : ''),
                $e->getCode()
            );
        }

        return JsonResponse::withJson(
            $response,
            json_encode($success),
            200
        );
    }


    /*
     * devuelve el objeto user 
     * @param Request $request contiente todos los atributos de la peticion
     * @param Response $response contiente todos los atributos de la respuesta
     * @return object
     */

    public function user(Request $request, Response $response)
    {
        try {
                $user = $this->service->user();

        } catch (Exception $e) {
            return JsonResponse::withJson(
                $response,
                json_encode('Error: '.$_SERVER['DEBUG'] ? $e->getMessage() : ''),
                $e->getCode()
            );
        }

        return JsonResponse::withJson(
            $response,
            json_encode($user),
            200
        );
    }

   



}