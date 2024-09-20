<?php

namespace Database\Seeders;

use App\Models\CustomerAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! CustomerAddress::where("id","1")->first()){
            CustomerAddress::create([
                'zipcode' => fake()->postcode(),
                'street' => fake()->streetName(),
                'num' => fake()->randomNumber(),
                'complement' => fake()->streetSuffix(),
                'neighborhood' => 'São João',
                'city' => fake()->city,
                'state' => 'DF',
                'company_id' => '1',
                'customer_id' => '2',
            ]);
        }

        if(! CustomerAddress::where("id","2")->first()){
            CustomerAddress::create([
                'zipcode' => fake()->postcode(),
                'street' => fake()->streetName(),
                'num' => fake()->randomNumber(),
                'complement' => fake()->streetSuffix(),
                'neighborhood' => 'Morrinhos',
                'city' => fake()->city,
                'state' => 'DF',
                'company_id' => '2',
                'customer_id' => '1',
            ]);
        }
    }
}
