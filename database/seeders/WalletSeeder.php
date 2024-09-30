<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**Company 1 */
        if(! Wallet::where("id","1")->first()){
            Wallet::create([
                'name' => 'Nubank Escritório',
                'agency' => '0001',
                'current_account' => '4',
                'balance' => '900',
                'type' => 'business',
                'holder' => 'Brandão Vidal Advogados',
                'main' => '1',
                'company_id' => '1',
            ]);
        }
    }
}
