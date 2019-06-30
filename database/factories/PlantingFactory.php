<?php

namespace database\factories;

use Faker\Generator as Faker;

class PlantingFactory {
    public static function getFactory(Faker $faker)
    {
        $districts = ['Rukungiri', 'Rubirizi', 'Ntoroko', 'Buhweju', 'Bushenyi'];
        $district = $faker->randomElement($districts);
        return [
            '_id' => $faker->uuid,
            'acreage' => '2',
            'district' => $district,
            'eloquent_type' => 'planting',
            'ma_id' => 'AK/MA/0421',
            'name' => $faker->name,
            'payment' => 'cash',
            'status' => 'new',
            'time' => '2018-11-20T18:55:01',
            'total' => 200000,
            'type' => 'planting',
            'unit_cost' => 100000,
            'user_id' => 'AFAHAJOH788007645RUKNYA',
            'vaId' => 'AK/MA/0421/0001',
        ];
    }
}
