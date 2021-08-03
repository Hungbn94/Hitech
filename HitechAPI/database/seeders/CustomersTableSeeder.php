<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\customers;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        customers::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            customers::create([
                'CustomerCode' => $faker->regexify('HITECH[0-9]{10}'),
                'CompanyName' => $faker->name,
                'ContactName' => $faker->name,
                'ContactNumber' => $faker->phoneNumber,
                'ContactEmail' => $faker->email,
                'Active' => $faker->randomElement($array = array ('0','1')),
            ]);
        }
    }
}
