<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! Company::where("id","1")->first()){
            Company::create([
                'fantasy_name' => fake()->name(),
                'corporate_reason' => fake()->company(),
                'email' => fake()->companyEmail(),
                'cnpj' => '',
                'phone' => '6232145879',
                'user_id' => '1',
                'company_address_id' => '1',
            ]);
        }

        if(! Company::where("id","2")->first()){
            Company::create([
                'fantasy_name' => fake()->name(),
                'corporate_reason' => fake()->company(),
                'email' => fake()->companyEmail(),
                'cnpj' => '',
                'phone' => '3133567418',
                'user_id' => '2',
                'company_address_id' => '2',
            ]);
        }
    }
}
