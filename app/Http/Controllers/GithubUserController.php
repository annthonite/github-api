<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GithubUserService;

class GithubUserController
{ 
    private $oRequest;

    private $oGithubUserService;

    public function __construct(Request $oRequest, GithubUserService $oGithubUserService)
    {
        $this->oRequest = $oRequest;
        $this->oGithubUserService = $oGithubUserService;
    }

    public function getGithubUser()
    {
        return $this->oGithubUserService->getGithubUser($this->oRequest);
    }
}
