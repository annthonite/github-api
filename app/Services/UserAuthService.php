<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserAuthService 
{
    public function registerUser($aData)
    {
        $this->validateRequiredData($aData);
        $aData['password'] = bcrypt($aData['password']);

        try {
            $oUser = User::create($aData);
            $sToken = $oUser->createToken('API Token')->accessToken;

            return ['email' => $aData['email']];
        } catch (\Exception $oException) {
            throw new \Exception('Unsuccesful registration', 400);
        }
    }

    public function loginUser($aData)
    {
        $this->validateRequiredData($aData);
        try {
            if (!auth()->attempt($aData)) {
                throw new \Exception('Incorrect details', 400);
            }
    
            $oToken = auth()->user()->createToken('API Token');
    
            return ['email' => $aData['email'], 'access_token' => $oToken->accessToken];
        } catch (\Exception $oException) {
            throw new \Exception('Unsuccesful login', 400);
        }
    }

    private function validateRequiredData($aData)
    {
        $oValidator = Validator::make($aData, [
            'email'    => 'email|required',
            'password' => 'required'
        ]);

        if ($oValidator->fails() === true) {
            throw new \InvalidArgumentException($oValidator->errors(), 422);
        }
    }
}
