<?php
namespace App\Utils;

use App\Utils\Email;
use Crisu83\ShortId\ShortId;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class Helpers extends BaseController
{

    private static $password_string;
    private $url;
    private $mail;

    public function __construct()
    {
        $this->mail = new Email();
        $this->url = getenv('FRONTEND_URL');

    }

    /**
     * Create a new token for user object.
     *
     * @param  \App\User   $user
     * @param $db
     * @return string
     */
    public static function jwt($user, $db=null, $exp=(60 * 60 * 24 * 7))
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $db !==null ? $user[0][$db]['_id'] : $user, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + $exp, // Expiration time
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
        return JWT::decode($token, env('JWT_SECRET'),  array('HS256'));
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

    public static function requestInfo()
    {
        $secret = getenv('PASSWORD_SECRET');
        self::$password_string = self::generateId() . $secret;
        $password = Hash::make(self::$password_string);
        $additionalInfo = [
            '_id' => self::generateId(),
            'district' => 'N/A',
            'value_chain' => 'N/A',
            'account_password' => 'Generic',
            'contact_person' => 'N/A',
        ];
        return $additionalInfo;
    }

    public static function getPassword()
    {
        return self::$password_string;
    }

    public function sendPassword($password, $email)
    {

        $sendEmail = $this->mail->mailWithTemplate(
            'LOGIN',
            $email, $this->url, $password);
        if ($sendEmail) {
            return true;
        }
    }

}
