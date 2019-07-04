<?php

namespace database\factories;

use Faker\Generator as Faker;

class MapCoordinateFactory {
    public static function getFactory(Faker $faker)
    {
        return [
            'vaId' => 'AK/MA/0421/0001',
            '_id' => $faker->uuid,
            'status' => 'complete',
            'longitudes' =>
                [
                    32.5547004,
                    32.5540483,
                    32.5541295,
                    32.5544145,
                    32.5546674,
                    32.5547004,
                ],
            'accuracy' =>
                [
                    3,
                    3.900000095367432,
                    3,
                    3,
                    3,
                ],
            'acreage' => 1.684316,
            'latitudes' =>
                [
                    2.6121502,
                    2.6121833,
                    2.6130184,
                    2.6132175,
                    2.6129445,
                    2.6121502,
                ],
            'phone' => '783355794',
            'payment_status' => false,
            'type' => 'map_cordinates',
            'eloquent_type' => 'map_cordinates',
            'garden_name' => 'Moses',
            'time' => '2019-05-07T10:29:07',
            'user_id' => 'AFAHAJOH788007645RUKNYA',
            'amount' => 7000,
        ];
    }
}
