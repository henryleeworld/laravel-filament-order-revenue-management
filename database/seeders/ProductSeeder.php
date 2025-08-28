<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        $tags = Tag::all();
        for($i = 0; $i < 10; $i++) {
            Product::factory(1)
                ->hasAttached(
                    $tags->random(rand(1, $tags->count()))
                )
                ->create();
        }
    }
}
