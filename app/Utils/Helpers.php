<?php
namespace App\Utils;

use App\Utils\Email;
use Crisu83\ShortId\ShortId;
use Firebase\JWT\JWT;
use Laravel\Lumen\Routing\Controller as BaseController;

class Helpers extends BaseController
{

    private static $password_string, $url, $mail, $password;

    public function __construct()
    {
        self::$mail = new Email();
        self::$url = getenv('FRONTEND_URL');

    }

    /**
     * Create a new token for user object.
     *
     * @param  \App\User   $user
     * @param $db
     * @return string
     */
    public static function jwt($user, $db = null, $exp = (60 * 60 * 24 * 7))
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $db !== null ? $user[0][$db]['_id'] : $user, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $exp, // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
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

    public static function requestInfo($password)
    {
        return [
            '_id' => self::generateId(),
            'district' => 'N/A',
            'value_chain' => 'N/A',
            'type' => 'Generic',
            'contact_person' => 'N/A',
            'password' => $password,
        ];
    }

    public function sendPassword($password, $email)
    {
        $sendEmail = self::$mail->mailWithTemplate(
            'LOGIN', $email, self::$url, $password);

        if ($sendEmail) {
            return true;
        }

    }

}
