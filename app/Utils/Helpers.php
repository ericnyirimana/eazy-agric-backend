<?php
namespace App\Utils;

use Crisu83\ShortId\ShortId;
use Firebase\JWT\JWT;
use Laravel\Lumen\Routing\Controller as BaseController;

class Helpers extends BaseController
{
    /**
     * Create a new token.
     *
     * @param  \App\User   $user
     * @param $db
     * @return string
     */
    public static function jwt($user, $db)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user[0][$db]['_id'], // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 * 24 * 7, // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * decode jwt token.
     *
     * @param  \App\User   $user
     * @param $db
     * @return string
     */
    public static function jwtDecode($token)
    {
        return JWT::decode($token, env('JWT_SECRET'));
    }

    /**
     * Generate Random Numbers
     * @return string
     */

    public static function generateId()
    {
        $shortid = ShortId::create();

        return $shortid->generate();
    }

}
