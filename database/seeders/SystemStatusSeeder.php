<?php

namespace Database\Seeders;

use App\Models\SystemStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! SystemStatus::where("id","1")->first()){
            SystemStatus::create([
                'name' => 'Aberto',
                'value' => 'open',
            ]);
        }
        if(! SystemStatus::where("id","2")->first()){
            SystemStatus::create([
                'name' => 'Em Andamento',
                'value' => 'in_progress',
            ]);
        }
        if(! SystemStatus::where("id","3")->first()){
            SystemStatus::create([
                'name' => 'Protocolado',
                'value' => 'registered',
            ]);
        }
        if(! SystemStatus::where("id","4")->first()){
            SystemStatus::create([
                'name' => 'Iniciado',
                'value' => 'started',
            ]);
        }
        if(! SystemStatus::where("id","5")->first()){
            SystemStatus::create([
                'name' => 'Cancelado',
                'value' => 'canceled',
            ]);
        }
        if(! SystemStatus::where("id","6")->first()){
            SystemStatus::create([
                'name' => 'Concluído',
                'value' => 'completed',
            ]);
        }
        if(! SystemStatus::where("id","7")->first()){
            SystemStatus::create([
                'name' => 'A Receber',
                'value' => 'to_receive',
            ]);
        }
        if(! SystemStatus::where("id","8")->first()){
            SystemStatus::create([
                'name' => 'Pago',
                'value' => 'paid',
            ]);
        }
        if(! SystemStatus::where("id","9")->first()){
            SystemStatus::create([
                'name' => 'Não Pago',
                'value' => 'unpaid',
            ]);
        }
        if(! SystemStatus::where("id","10")->first()){
            SystemStatus::create([
                'name' => 'Pago Parcialmente',
                'value' => 'partially_paid',
            ]);
        }
    }
}
