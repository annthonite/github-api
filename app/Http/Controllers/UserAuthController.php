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
        return response($this->oUserAuthService->registerUser($this->oRequest));
    }

    public function loginUser(Request $request)
    {
        return response($this->oUserAuthService->loginUser($this->oRequest));
    }
}
