<?php

namespace Database\Seeders;

use App\Models\CustomerContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! CustomerContract::where("id","1")->first()){
            CustomerContract::create([
                'title' => fake()->title(),
                'content' => fake()->text(),
                'email' => fake()->companyEmail(),
                'author_id' => '1',
                'company_address_id' => '1',
            ]);
        }
    }
}
