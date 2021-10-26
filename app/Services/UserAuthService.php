<?php

namespace App\Services;

use App\Models\User;

class UserAuthService 
{
    public function registerUser($aData)
    {
        $aValidatedData = $aData->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $aValidatedData['password'] = bcrypt($aData->password);

        try {
            $oUser = User::create($aValidatedData);
            $sToken = $oUser->createToken('API Token')->accessToken;

            return ['email' => $aValidatedData['email']];
        } catch (\Exception $oException) {
            return ['error_message' => 'Unsuccessful registration'];
        }
    }

    public function loginUser($aData)
    {
        $aValidatedData = $aData->validate([
            'email'    => 'email|required',
            'password' => 'required'
        ]);

        try {
            if (!auth()->attempt($aValidatedData)) {
                return response(['error_message' => 'Incorrect Details.']);
            }
    
            $oToken = auth()->user()->createToken('API Token');
    
            return ['email' => $aValidatedData['email'], 'access_token' => $oToken->accessToken];
        } catch (\Exception $oException) {
            return ['error_message' => 'Unsuccessful login'];
        }
    }
}
