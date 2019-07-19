<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class emailUpdate implements Rule
{
    private $email, $id;

    public function __construct($email, $id)
    {
        $this->email = $email;
        $this->id = $id;
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
        $db = getenv('DB_DATABASE');
        $user = DB::select('select * from ' . $db . ' where email = ?', [$this->email]);
        if (!$user || $user[0][$db]['_id'] === $this->id) {

            return $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email has been taken';
    }
}
