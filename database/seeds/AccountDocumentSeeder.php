<?php

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Account::class, 5)->create();
    }
}
