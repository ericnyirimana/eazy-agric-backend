<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class, 1)->create();
        // You can add more seeds here
    }
}
