<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateInputFields implements Rule
{
    private static $data;

    public function __construct($data)
    {
        self::$data = $data;
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
        if ($this->string !== '') {

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
        return 'Empty strings are not allowed.';
    }

    public static function isEmpty()
    {
        $errors = [];
        foreach (self::$data as $key => $value) {
            if (empty(trim($value))) {
                array_push($errors, ucfirst($key) . ' cannot be empty.');
            }

        }
        if (count($errors) > 0) {
            return $errors;
        }

        return false;
    }
}
