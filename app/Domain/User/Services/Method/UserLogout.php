<?php

namespace App\Domain\User\Services\Method;

use App\Shared\Exceptions\MissingTokenException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class UserLogout
{
    public function logout(Request $request)
    {
        try{
            $token = $this->getTokenFromUser($request);
            $tokenModel = $this->getTokenFromDatabase($token);
            $tokenModel->delete();
        } catch (MissingTokenException $e){
            Log::info('Logout attempted with missing/expired token');
            return true;

        } catch (Exception $e) {
            Log::error('An error during logout process has occured', ['message' => $e->getMessage()]);
            throw $e;
        }
    }

    private function getTokenFromUser(Request $request)
    {
        $tokenToRevoke = $request->bearerToken();

        if(!$tokenToRevoke){
            throw new MissingTokenException();
        }

        return $tokenToRevoke;
    }

    private function getTokenFromDatabase(string $token)
    {
        $tokenModel = PersonalAccessToken::findToken($token);

        if (!$tokenModel){
            Log::warning('Token might be expired or invalid');
            throw new MissingTokenException();
        }

        return $tokenModel;

    }


}
