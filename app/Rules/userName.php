<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserName implements Rule
{
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
        $this->db = getenv('DB_DATABASE');
        $this->validation_error_message = 'Username has been taken.';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user_name = DB::select('SELECT * FROM ' . $this->db . ' WHERE username = ?', [strtolower($this->username)]);
        if (!$user_name)   return $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->validation_error_message;
    }
}
