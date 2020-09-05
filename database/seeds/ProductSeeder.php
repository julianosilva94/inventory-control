<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $now = \Carbon\Carbon::now();

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Product::create([
                'sku' => strtoupper($faker->slug(2)),
                'name' => $faker->company,
                'description' => $faker->text,
                'quantity' => 0,
            ]);
        }
    }
}
