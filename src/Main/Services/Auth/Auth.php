<?php

namespace Main\Services\Auth;

use Main\Models\User;
use Main\Models\Student;
use Main\Models\Admin;
use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Database\Capsule\Manager;
use Slim\Collection;
use Slim\Http\Request;

class Auth
{

    const SUBJECT_IDENTIFIER = 'username';

    private $appConfig;

    public function __construct(Manager $db, Collection $appConfig)
    {
        $this->db = $db;
        $this->appConfig = $appConfig;
    }

    public function generateToken(User $user) 
    {
        $now = new DateTime();
        $future = new DateTime("now +2 hours");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => base64_encode(random_bytes(16)),
            'iss' => $this->appConfig['app']['url'],  // Issuer
            "sub" => $user->{self::SUBJECT_IDENTIFIER},
        ];

        $secret = $this->appConfig['jwt']['secret'];
        $token = JWT::encode($payload, $secret, "HS256");

        return $token;
    }

    public function generateTokenAdmin(Admin $admin)
    {
        $now = new DateTime();
        $future = new DateTime("now +2 hours");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => base64_encode(random_bytes(16)),
            'iss' => $this->appConfig['app']['url'],  // Issuer
            "sub" => $user->{self::SUBJECT_IDENTIFIER},
        ];

        $secret = $this->appConfig['jwt']['secret'];
        $token = JWT::encode($payload, $secret, "HS256");

        return $token;
    }

    public function attempt($email, $password)
    {
        if ( ! $user = User::where('email', $email) || !$admin = Admin::where('email', $email)->first()) {
            return false;
        }

        if (password_verify($password, $admin->password)) {
            return $admin;
        }

        return false;
    }

    public function attemptAdmin($email, $password)
    {
        if (!$admin = Admin::where('email', $email)->first()) {
            return false;
        }

        if (password_verify($password, $admin->password)) {
            return $admin;
        }

        return false;
    }



    public function requestUser(Request $request)
    {
        // Should add more validation to the present and validity of the token?
        if ($token = $request->getAttribute('token')) {
            return User::where(static::SUBJECT_IDENTIFIER, '=', $token->sub)->first();
        };
    }

    public function requestAdmin(Request $request)
    {
        // Should add more validation to the present and validity of the token?
        if ($token = $request->getAttribute('token')) {
            return Admin::where(static::SUBJECT_IDENTIFIER, '=', $token->sub)->first();
        };
    }

}