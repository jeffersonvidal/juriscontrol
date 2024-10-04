<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**Company 1 */
        if(! User::where("id","1")->first()){
            User::create([
                'name' => 'Jason Voorhees',
                'company_id' => '1',
                'email' => 'adm@adm.com',
                'password' => Hash::make('123', ['rounds' => 12]),
                'user_profile_id' => '4',
                'phone' => '61987654321',
                'cpf' => '65478932194',
                'birthday' => '1983-11-21',
            ]);
        }

        if(! User::where("id","2")->first()){
            User::create([
                'name' => fake()->name(),
                'company_id' => '2',
                'email' => 'user@email.com',
                'password' => Hash::make('123', ['rounds' => 12]),
                'user_profile_id' => '4',
                'phone' => '61987654321',
                'cpf' => '65478932194',
                'birthday' => '1983-11-21',
            ]);
        }

        /**Company 2 */
        if(! User::where("id","3")->first()){
            User::create([
                'name' => fake()->name(),
                'company_id' => '1',
                'email' => 'bbb@bbb.com',
                'password' => Hash::make('123', ['rounds' => 12]),
                'user_profile_id' => '1',
                'phone' => '61987654321',
                'cpf' => '32145689727',
                'birthday' => '2000-08-17',
            ]);
        }

        if(! User::where("id","4")->first()){
            User::create([
                'name' => fake()->name(),
                'company_id' => '2',
                'email' => 'ccc@ccc.com',
                'password' => Hash::make('123', ['rounds' => 12]),
                'user_profile_id' => '1',
                'phone' => '61987654321',
                'cpf' => '32145689727',
                'birthday' => '2000-08-17',
            ]);
        }
    }
}
