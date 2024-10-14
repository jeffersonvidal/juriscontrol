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
                'fantasy_name' => 'Brandão Vidal Advogados',
                'corporate_reason' => 'Brandão Vidal Adv',
                'email' => 'contato@brandaovidaladvogados.com.br',
                'cnpj' => '55768652000162',
                'phone' => '61981261073',
                'user_id' => '1',
                'company_address_id' => '1',
                'gdrive_client_id' => '190531505058-1rq8aorlhg31k62desttmg6v91uittbu.apps.googleusercontent.com',
                'gdrive_client_secret' => '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',
                'gdrive_refresh_token' => '1//041qdWUWV80dJCgYIARAAGAQSNwF-L9Irf17dHd-qKS52H5xrr9R-PK9n3qP9B7dJ96oIkPqK1uJKxuzzXPg1zRoEfge5KeCNA_o',
                'gdrive_customers_folder' => '1ftvWHP_TJHhLoUOzfQroDW9bttnb_tmx',
                'gdrive_partners_folder' => '1rlF_wdwPHfkR8-e5ypd0_50xRIgIe7ay',
            ]);
        }

        if(! Company::where("id","2")->first()){
            Company::create([
                'fantasy_name' => fake()->name(),
                'corporate_reason' => fake()->company(),
                'email' => fake()->companyEmail(),
                'cnpj' => '88793055000147',
                'phone' => '3133567418',
                'user_id' => '2',
                'company_address_id' => '2',
            ]);
        }
    }
}
