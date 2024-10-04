<?php

namespace Database\Seeders;

use App\Models\ExternalPetition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExternalPetitionSeeder extends Seeder
{
    public function run(): void
    {

        if(! ExternalPetition::where("id","1")->first()){
            ExternalPetition::create([
                'wallet_id' => '1',
                'user_id' => '1',
                'company_id' => '1',
                'external_office_id' => '1',
                'responsible' => '1',
                'delivery_date' => '2024-11-02',
                'type' => '1',
                'customer_name' => fake()->name(),
                'process_number' => '0000548-63.2024.5.10.0104',
                'court' => 'TRT10',
                'notes' => '',
                'amount' => '200',
                'status' => 'completed',
                'payment_status' => 'unpaid',
            ]);
        }
        if(! ExternalPetition::where("id","2")->first()){
            ExternalPetition::create([
                'wallet_id' => '1',
                'user_id' => '1',
                'company_id' => '1',
                'external_office_id' => '2',
                'responsible' => '1',
                'delivery_date' => '2024-11-17',
                'type' => '4',
                'customer_name' => fake()->name(),
                'process_number' => '0000548-63.2024.5.10.0485',
                'court' => 'TRT10',
                'notes' => '',
                'amount' => '150',
                'status' => 'in_progress',
                'payment_status' => 'unpaid',
            ]);
        }
    }
}

   //     customer_name, wallet_id, user_id, company_id, status(iniciada(started), em andamento(in_progress), concluído(completed)),
// origem (escritórios), data recebimento, responsável, data entrega,
// tipo (RT, Contestação, Manifestação, RO, RR, ED, Análise de Sentença, Análise Processual, Análise de Caso),
// cliente, processo, tribunal, observações, valor, payment_status (pago (paid), pendente(pending), atrasado(late))