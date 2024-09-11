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
        if(! User::where("id","1")->first()){
            User::create([
                'name' => 'Mévio Pereira',
                'company_id' => '1',
                'email' => 'adm@adm.com',
                'password' => Hash::make('123456', ['rounds' => 12]),
                'user_profile_id' => '4',
                'phone' => '(61) 98765-4321',
                'cpf' => '654.789.321-94',
                'birthday' => '1983-11-21',
            ]);
        }
    }
}
