<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**Cliente para empresa 1 */
        if(! Customer::where("id","1")->first()){
            Customer::create([
                'name' => fake()->name(),
                'company_id' => '1',
                'email' => fake()->email(),
                'phone' => '61987453241',
                'rg' => '78654183',
                'rg_expedidor' => 'SSP-DF',
                'cpf' => '45698712354',
                'marital_status' => 'solteiro(a)',
                'nationality' => 'brasileiro(a)',
                'profession' => 'engenheiro',
                'birthday' => fake()->date(),
                'met_us' => 'google',
            ]);
        }
        
        if(! Customer::where("id","2")->first()){
            Customer::create([
                'name' => fake()->name(),
                'company_id' => '2',
                'email' => fake()->email(),
                'phone' => '61987453241',
                'rg' => '32145698',
                'rg_expedidor' => 'SSP-DF',
                'cpf' => '98745632132',
                'marital_status' => 'solteiro(a)',
                'nationality' => 'brasileiro(a)',
                'profession' => 'serviços gerais',
                'birthday' => fake()->date(),
                'met_us' => 'instagram',
            ]);
        }

        /**Cliente para empresa 2 */
        if(! Customer::where("id","3")->first()){
            Customer::create([
                'name' => fake()->name(),
                'company_id' => '1',
                'email' => fake()->email(),
                'phone' => '61987453241',
                'rg' => '4513256',
                'rg_expedidor' => 'SSP-DF',
                'cpf' => '12365478965',
                'marital_status' => 'solteiro(a)',
                'nationality' => 'brasileiro(a)',
                'profession' => 'porteiro(a)',
                'birthday' => fake()->date(),
                'met_us' => 'google',
            ]);
        }

        if(! Customer::where("id","4")->first()){
            Customer::create([
                'name' => fake()->name(),
                'company_id' => '2',
                'email' => fake()->email(),
                'phone' => '61987453241',
                'rg' => '7898654',
                'rg_expedidor' => 'SSP-DF',
                'cpf' => '3456982545',
                'marital_status' => 'solteiro(a)',
                'nationality' => 'brasileiro(a)',
                'profession' => 'auxiliar administrativo',
                'birthday' => fake()->date(),
                'met_us' => 'tiktok',
            ]);
        }
    }
}
