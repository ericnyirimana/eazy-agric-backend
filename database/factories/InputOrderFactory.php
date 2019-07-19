<?php

namespace database\factories;

use App\Models\MasterAgent;
use App\Models\VillageAgent;
use Faker\Generator as Faker;

class InputOrderFactory {
    public static function getFactory(Faker $faker)
    {
        $districts = ['Rukungiri', 'Rubirizi', 'Ntoroko', 'Buhweju', 'Bushenyi'];
        $district = $faker->randomElement($districts);
        return [
            "details" => [
                "district" => $district,
                "name" => $faker->name,
                "phone" => $faker->phoneNumber,
                "photo" => "",
                "time" => "2018-10-20T20:22:51",
                "totalCost" => 1670000,
                "totalItems" => 2
            ],
              "eloquent_type" => "order",
              "order" => [
                [
                    "category" => "Farming tools",
                    "price" => 10000,
                    "product" => "Plastic Silo",
                    "qty" => 165,
                    "src" => "http://138.197.220.176:3000/assets/images/f9ab1da7-cd63-4e3d-8a96-b1c7dcc2cb42.png",
                    "stock" => "",
                    "supplier" => "World Food Program",
                    "unit" => "50 Kgs"
                ],
                [
                    "category" => "Farming tools",
                    "price" => 10000,
                    "product" => "Pics Bags",
                    "qty" => 2,
                    "src" => "http://138.197.220.176:3000/assets/images/Jmugo75136.png",
                    "stock" => "",
                    "supplier" => "World Food Program",
                    "unit" => "50 Kgs"
                ]
              ],
              "payment" => "mm",
              "stature" => "new",
              "status" => "Intransit",
              "type" => "order",
              "user_id" => "AFAHAJOH788007645RUKNYA",
              "vaId" => function() {
                  return factory(VillageAgent::class)->create()->_id;
              },
              "ma_id" => function() {
                  return factory(MasterAgent::class)->create()->_id;
              }
        ];
    }
}
