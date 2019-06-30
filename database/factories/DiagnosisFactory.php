<?php

namespace database\factories;

use Faker\Generator as Faker;

class DiagnosisFactory {
    public static function getFactory(Faker $faker)
    {
        return [
            'cause' => 'Virus',
            'name' => 'Bean common mosaic virus',
            'control' => '1. Use certified and disease-free seeds. 2. Control attacks of aphids and remove infected plants from the field.',
            'type' => 'diagnosis',
            'eloquent_type' => 'diagnosis',
            'category' => 'Disease',
            '_id' => $faker->uuid,
            'photo_url' => '/images/uAge0125440.png',
            'explanation' =>
                [
                    'Folding and twisting of leaves with a light and dark green patches',
                    'The dark green patches are always near the veins. ',
                    'Affected plants produce smaller, curved pods that appear slippery',
                ],
            'crop' => 'Beans',
        ];
    }
}
