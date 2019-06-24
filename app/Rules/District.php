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
        $value =
            'Bukomansimbi' ||
            'Kyenjojo' ||
            'Kyenjojo' ||
            'Buliisa' ||
            'Jinja' ||
            'Kitgum' ||
            'Mukono' ||
            'Amuru' ||
            'Oyam' ||
            'Buvuma' ||
            'Pader' ||
            'Kween' ||
            'Arua' ||
            'Kamwenge' ||
            'Mbarara' ||
            'Amuria' ||
            'Apac' ||
            'Mbale' ||
            'Luuka' ||
            'Kampala' ||
            'Kibingo' ||
            'Kotido' ||
            'Kabarole' ||
            'Mitooma' ||
            'Sironko' ||
            'Maracha' ||
            'Nakapiripiti' ||
            'Buikwe' ||
            'Kasese' ||
            'Mubende' ||
            'Kanungu' ||
            'Kaabong' ||
            'Kayunga' ||
            'Agago';
        return $value;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid value chain';
    }
}
