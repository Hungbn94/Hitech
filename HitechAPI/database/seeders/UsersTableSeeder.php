<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\users;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        users::truncate();

        $faker = \Faker\Factory::create();
        $password = Hash::make('123456');
        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            users::create([
                'UserName' => $faker->firstName,
                'Password' => $password,
                'Name' => $faker->name,
                'UserEmail' => $faker->email,
                'UserNumber' => $faker->phoneNumber,
                'UserAdress' => $faker->address,
                'Permission' => $faker->randomElement($array = array ('1','2','9')),
                'Active' => $faker->randomElement($array = array ('0','1')),
            ]);
        }
    }
}
