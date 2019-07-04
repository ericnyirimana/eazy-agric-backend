<?php

namespace database\factories;

use Faker\Generator as Faker;

class SprayingFactory {
    public static function getFactory(Faker $faker)
    {
        $districts = ['Rukungiri', 'Rubirizi', 'Ntoroko', 'Buhweju', 'Bushenyi'];
        $district = $faker->randomElement($districts);
        return [
            'phone' => $faker->phoneNumber,
            'unit_cost' => 100000,
            '_id' => $faker->uuid,
            'status' => 'new',
            'district' => $district,
            'vaId' => 'AK/MA/0421/0001',
            'acerage' => '2',
            'ma_id' => 'AK/MA/0421',
            'total' => 200000,
            'name' => 'Anyipo Moureen',
            'type' => 'spraying',
            'eloquent_type' => 'spraying',
            'time' => '2018-11-19T15:40:25',
            'user_id' => 'AFAHAJOH788007645RUKNYA',
            'payment' => 'cash',
        ];
    }
}
