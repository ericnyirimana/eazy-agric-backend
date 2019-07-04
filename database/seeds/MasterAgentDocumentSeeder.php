<?php

use App\Models\MasterAgent;
use Illuminate\Database\Seeder;
//use Faker\Generator as Faker;

class MasterAgentDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MasterAgent::class, 5)->create();

        // You can add more seeds here
        $faker = \Faker\Factory::create();
        $districts = ['Rukungiri', 'Rubirizi', 'Ntoroko', 'Buhweju', 'Bushenyi'];
        $district = $faker->randomElement($districts);
        MasterAgent::create([
            '_id' => $faker->uuid,
            'address' => $faker->address,
            'contact_person' => $faker->name,
            'district' => $district,
            'eloquent_type' => 'ma',
            'type' => 'ma',
            'email' => 'masteragent2121@gmail.com',
            'firstname' => $faker->firstName,
            'lastname' => $faker->lastName,
            'password' => '123123',
            'phonenumber' => $faker->phoneNumber,
            'status' => 'demo',
            'value_chain' => 'Crop',
        ]);
    }
}
