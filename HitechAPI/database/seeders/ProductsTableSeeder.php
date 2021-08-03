<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\products;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        products::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 100; $i++) {
            products::create([
                'ProductCode' => $faker->regexify('20.[0-9]{3}'),
                'CustomerID' => $faker->numberBetween($min = 1, $max = 50),
                'ContractNumber' => $faker->regexify('[0-9]{0-3}.2020'),
                'ProductName' => $faker->name,
                'StartDate' => $faker->date($format = 'Y/m/d', $max = 'now'),
                'EndDate' => $faker->date($format = 'Y/m/d', $max = 'now'),
                'SendStartDate' => $faker->date($format = 'Y/m/d', $max = 'now'),
                'SendEndDate' => $faker->date($format = 'Y/m/d', $max = 'now'),
                'ManuDate' => $faker->date($format = 'Y/m/d', $max = 'now'),
                'ExternalForm' => $faker->randomElement($array = array ('ran','long','khi')),
                'pH' => $faker->randomFloat($nbMaxDecimals = 1, $min = 4, $max = 9),
                'AuthorizedComName' => $faker->name,
                'AuthorizedComAddress' => $faker->address,
                'method423' => $faker->numberBetween($min = 1, $max = 100),
                'method402' => $faker->numberBetween($min = 1, $max = 100),
                'method403' => $faker->numberBetween($min = 1, $max = 100),
                'method406' => $faker->numberBetween($min = 1, $max = 100),
                'method404' => $faker->numberBetween($min = 1, $max = 100),
                'method405' => $faker->numberBetween($min = 1, $max = 100),
                'Active' => $faker->randomElement($array = array ('0','1')),
            ]);
        }
    }
}
