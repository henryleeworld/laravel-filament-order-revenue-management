<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => __('Administrator'),
            'email' => 'admin@admin.com',
            'is_admin' => 1,
        ]);
        User::factory()->create([
            'name' => __('Accountant'),
            'email' => 'accountant@admin.com',
            'is_accountant' => 1,
        ]);
        User::factory()->count(10)->create();
    }
}
