<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * GithubUser Service
 */
class GithubUserService 
{
    /**
     * Get github user from github API
     *
     * @param object $aData
     * @return object
     */
    public function getGithubUser($aData)
    {
        $aUserList = explode(',', $aData->users);
        $aUserListDetails = [];

        if (count($aUserList) > 10) {
            return response(['error' => 'More than 10 user']);
        }

        $aReturnedCached = $this->checkCacheData();
        if ($aReturnedCached !== null) {
            return response(['user_details' => $aReturnedCached]);
        }

        Log::debug('Make github request. user_id = ' . auth()->id());
        foreach ($aUserList as $aUser) {
            $oResponse = Http::get('https://api.github.com/users/' . $aUser)->body();
            Log::debug($oResponse);
            $aUserDetails = json_decode($oResponse, true);
            $aReturnDetails = $this->checkNameExists($aUserDetails);
            if ($aReturnDetails !== false) {
                $aUserListDetails[] = $aReturnDetails;
            }
        }

        usort($aUserListDetails, function ($sFirst, $sSecond) {
            return strcmp($sFirst['name'], $sSecond['name']);
        });
        
        $this->cacheData($aUserListDetails);
        return response(['user_details' => $aUserListDetails]);
    }

    /**
     * Check name from result if existing
     *
     * @param array $aUserDetails
     * @return mixed
     */
    private function checkNameExists($aUserDetails)
    {
        if (array_key_exists('login', $aUserDetails) === true && array_key_exists('name', $aUserDetails) === true) {
           return [
                'name' => empty($aUserDetails['name']) ? 'No Name' : $aUserDetails['name'],
                'login' => $aUserDetails['login'],
                'company' => $aUserDetails['company'],
                'number_followers' => $aUserDetails['followers'],
                'number_repositories' => $aUserDetails['public_repos'],
                'average_followers' => ($aUserDetails['public_repos'] === 0) ? $aUserDetails['followers'] : round($aUserDetails['followers'] / $aUserDetails['public_repos'], 2)
            ];
        }

        return false;
    }

    /**
     * Check for cached data
     *
     * @return mixed
     */
    private function checkCacheData()
    {
        return Cache::get('github-info-' . auth()->id());
    }

    /**
     * Cache data
     *
     * @param array $aUserListDetails
     * @return void
     */
    private function cacheData($aUserListDetails)
    {
        Cache::put('github-info-' . auth()->id(), $aUserListDetails, 120);
    }
}
