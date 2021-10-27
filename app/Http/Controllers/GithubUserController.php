<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GithubUserService;

/**
 * GithubUserController
 */
class GithubUserController
{ 
    /**
     * Request variable
     *
     * @var object
     */
    private $oRequest;

    /**
     * GithubService variable
     *
     * @var object
     */
    private $oGithubUserService;

    /**
     * Construct
     *
     * @param Request $oRequest
     * @param GithubUserService $oGithubUserService
     */
    public function __construct(Request $oRequest, GithubUserService $oGithubUserService)
    {
        $this->oRequest = $oRequest;
        $this->oGithubUserService = $oGithubUserService;
    }

    /**
     * Get github user
     *
     * @return mixed
     */
    public function getGithubUser()
    {
        return $this->oGithubUserService->getGithubUser($this->oRequest);
    }
}
