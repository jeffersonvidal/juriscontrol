<?php

namespace Database\Seeders;

use App\Models\Hearing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HearingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! Hearing::where("id","1")->first()){
            Hearing::create([
                'object' => 'hearing',
                'company_id' => '1',
                'user_id' => '1',
                'responsible' => '1',
                'status' => 'open',
                'date_happen' => '2024-11-23',
                'external_office_id' => '1',
                'client' => fake()->name(),
                'local' => 'CEJUSC BSB',
                'time_happen' => '14:30',
                'type' => 'initial',
                'process_num' => '',
                'modality' => 'in_person',
                'informed_client' => 'n',
                'informed_witnesses' => 'n',
                'link' => '',
                'notes' => '',
                'amount' => '150',
                'payment_status' => 'unpaid',
            ]);
        }
    }
}
