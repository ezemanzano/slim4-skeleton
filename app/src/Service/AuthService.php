<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\UserService;
use App\Service\TokenService;
use App\Repository\ShoppingCartRepository;

final class AuthService extends BaseService
{

    public function __construct(
        UserService $userService,
        TokenService $tokenService,
        ShoppingCartRepository $sc_repository
    )
    {
        $this->userService = $userService;
        $this->tokenService = $tokenService;
        $this->sc_repository = $sc_repository;
    }

    public function login(array $data)
    {

        // Get user by auth


        if(!$user = $this->userService->getByAuth($data)){
            throw new \Exception(
                "Los datos ingresados son incorrectos.",
                401
            );           
        }


        // Make and get token
        if(!$accessToken = $this->tokenService->make($user, $data)){
            throw new \Exception(
                "No se pudo iniciar sesión. Por favor intente más tarde..",
                400
            );
        }
        
        if($user->correoConfirmado == 0){
            throw new \Exception(
                "El correo electronico no fue confirmado",
                401
            );
        }

        if($user->codigoFP == null){
            throw new \Exception(
                "La cuenta no fue confirmada por un vendedor",
                401
            );
        }
       
        if($user->carritoActivo == null || $user->carritoActivo == 0 ){
            $create_carrito = $this->sc_repository->createAndSetShoppingCart($user->id);  
        } 

        if($this->sc_repository->checkIfCarritoExist($user->carritoActivo)){
            $create_carrito = $this->sc_repository->createAndSetShoppingCart($user->id);  
        }

        return ['token' => $accessToken ];
    }


    public function saveMetric($mode){
        $save = $this->tokenService->saveMetric($mode);
    }

    public function user()
    {
        $user = $this->userService->getById();
        return ['user' => $user];
    }


    public function checkMail($mail)
    {
        $check = $this->userService->checkMailExist($mail);
        return $check;
    }


    public function saveRecovery($mail,$token)
    {
        $save = $this->userService->saveRecovery($mail,$token); 
        return $save;
    }
  
    public function checkRecovery($mail,$token)
    {
        return $this->userService->checkRecovery($mail,$token);
    }
   
    public function updatePassword($mail,$pw)
    {
        return $this->userService->updatePassword($mail,$pw);
    }
   
}