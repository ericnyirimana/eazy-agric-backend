<?php

namespace database\factories;

use Faker\Generator as Faker;

class SoilTestFactory {
    public static function getFactory(Faker $faker)
    {
        $districts = ['Rukungiri', 'Rubirizi', 'Ntoroko', 'Buhweju', 'Bushenyi'];
        $district = $faker->randomElement($districts);
        return array (
            'acreage' => '2',
            'district' => $district,
            'eloquent_type' => 'soil_test',
            'name' => $faker->name,
            'payment' => 'mm',
            'phone' => $faker->phoneNumber,
            'photo' => '',
            'result' => '',
            'samples' => 5,
            'status' => 'new',
            'time' => '2019-05-03T16:09:42',
            'total' => 250000,
            'type' => 'soil_test',
            'unit_cost' => 50000,
            'user_id' => 'AFAHAJOH788007645RUKNYA',
            'vaId' => 'AK/MA/0421/0001',
        );
    }
}