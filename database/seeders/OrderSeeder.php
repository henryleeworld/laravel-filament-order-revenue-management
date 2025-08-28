<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        Order::factory()
            ->count(50)
            ->create();
    }
}
