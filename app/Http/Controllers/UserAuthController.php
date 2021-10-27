<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserAuthService;

/**
 * UserAuthController
 */
class UserAuthController
{ 
    /**
     * Request variable
     *
     * @var object
     */
    private $oRequest;

    /**
     * UserAuthService variable
     *
     * @var object
     */
    private $oUserAuthService;

    /**
     * Construct
     *
     * @param Request $oRequest
     * @param UserAuthService $oUserAuthService
     */
    public function __construct(Request $oRequest, UserAuthService $oUserAuthService)
    {
        $this->oRequest = $oRequest;
        $this->oUserAuthService = $oUserAuthService;
    }

    /**
     * Register user
     *
     * @return mixed
     */
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

    /**
     * Login user
     *
     * @return mixed
     */
    public function loginUser()
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
