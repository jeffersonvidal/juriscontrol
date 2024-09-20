<?php

namespace Database\Seeders;

use App\Models\CompanyAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! CompanyAddress::where("id","1")->first()){
            CompanyAddress::create([
                'zipcode' => fake()->postcode(),
                'street' => fake()->streetName(),
                'num' => fake()->randomNumber(),
                'complement' => fake()->streetSuffix(),
                'neighborhood' => 'São João',
                'city' => fake()->city,
                'state' => 'DF',
                'company_id' => '1',
                'customer_id' => '1',
            ]);
        }

        if(! CompanyAddress::where("id","2")->first()){
            CompanyAddress::create([
                'zipcode' => fake()->postcode(),
                'street' => fake()->streetName(),
                'num' => fake()->randomNumber(),
                'complement' => fake()->streetSuffix(),
                'neighborhood' => 'Morrinhos',
                'city' => fake()->city,
                'state' => 'DF',
                'company_id' => '2',
                'customer_id' => '2',
            ]);
        }
    }
}
