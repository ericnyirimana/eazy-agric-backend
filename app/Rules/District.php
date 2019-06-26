<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class District implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value === 'Bukomansimbi' ||
            $value === 'Kyenjojo' ||
            $value === 'Kyenjojo' ||
            $value === 'Buliisa' ||
            $value === 'Jinja' ||
            $value === 'Kitgum' ||
            $value === 'Amuru' ||
            $value === 'Mukono' ||
            $value === 'Oyam' ||
            $value === 'Buvuma' ||
            $value === 'Pader' ||
            $value === 'Kween' ||
            $value === 'Arua' ||
            $value === 'Kamwenge' ||
            $value === 'Mbarara' ||
            $value === 'Amuria' ||
            $value === 'Apac' ||
            $value === 'Mbale' ||
            $value === 'Luuka' ||
            $value === 'Kampala' ||
            $value === 'Kibingo' ||
            $value === 'Kotido' ||
            $value === 'Kabarole' ||
            $value === 'Mitooma' ||
            $value === 'Sironko' ||
            $value === 'Maracha' ||
            $value === 'Nakapiripiti' ||
            $value === 'Buikwe' ||
            $value === 'Kasese' ||
            $value === 'Mubende' ||
            $value === 'Kanungu' ||
            $value === 'Kaabong' ||
            $value === 'Kayunga' ||
            $value === 'Agago';
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid district';
    }
}
