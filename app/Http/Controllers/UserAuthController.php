<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserAuthService;

class UserAuthController
{ 
    private $oRequest;

    private $oUserAuthService;

    public function __construct(Request $oRequest, UserAuthService $oUserAuthService)
    {
        $this->oRequest = $oRequest;
        $this->oUserAuthService = $oUserAuthService;
    }

    public function registerUser()
    {
        try {
            return response($this->oUserAuthService->registerUser($this->oRequest->all()));
        } catch (\InvalidArgumentException $oException) {
            return response(['errors' => json_decode($oException->getMessage())], $oException->getCode());
        } catch (\Exception $oException) {
            return response(['error' => $oException->getMessage()], $oException->getCode());
        }
    }

    public function loginUser(Request $request)
    {
        try {
            return response($this->oUserAuthService->loginUser($this->oRequest->all()));
        } catch (\InvalidArgumentException $oException) {
            return response(['errors' => json_decode($oException->getMessage())], $oException->getCode());
        } catch (\Exception $oException) {
            return response(['error' => $oException->getMessage()], $oException->getCode());
        }
    }
}
