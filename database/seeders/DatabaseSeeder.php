<?php

namespace Database\Seeders;

use App\Models\Compte;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Compte::create([
            'username'=>"admin",
            'idTypecompte'=>1,
            'pasword'=>Hash::make("secret")
        ]);
    }
}
