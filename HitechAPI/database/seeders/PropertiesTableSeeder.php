<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\properties;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        properties::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 100; $i++) {
            $percent1 = $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 80);
            properties::create([
                'ProductID' => $i + 1,
                'PropertiesName' => $faker->name,
                'Quantity' => $percent1,
            ]);
            $percent2 = $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 100 - $percent1);
            properties::create([
                'ProductID' => $i + 1,
                'PropertiesName' => $faker->name,
                'Quantity' => $percent1,
            ]);
            properties::create([
                'ProductID' => $i + 1,
                'PropertiesName' => $faker->name,
                'Quantity' => 100 - $percent1 - $percent2,
            ]);
        }
    }
}
