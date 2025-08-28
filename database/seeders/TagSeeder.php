<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        Tag::factory()
            ->count(3)
            ->create();
    }
}
