<?php

use App\Models\OurCrop;
use Illuminate\Database\Seeder;

class OurCropDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OurCrop::class, 5)->create();
    }
}
