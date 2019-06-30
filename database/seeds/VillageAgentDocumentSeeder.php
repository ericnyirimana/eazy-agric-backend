<?php

use App\Models\VillageAgent;
use Illuminate\Database\Seeder;

class VillageAgentDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(VillageAgent::class, 5)->create();
        // You can add more seeds here
    }
}
