<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $users = User::all();
        for($i = 0; $i < 2; $i++) {
            Company::factory(1)
                ->hasAttached(
                    $users->random(rand(1, $users->count()))
                )
                ->create();
        }
    }
}
