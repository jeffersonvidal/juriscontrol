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
            ]);
        }
        if(! SystemStatus::where("id","2")->first()){
            SystemStatus::create([
                'name' => 'Em Andamento',
            ]);
        }
        if(! SystemStatus::where("id","3")->first()){
            SystemStatus::create([
                'name' => 'Protocolado',
            ]);
        }
        if(! SystemStatus::where("id","4")->first()){
            SystemStatus::create([
                'name' => 'Iniciado',
            ]);
        }
        if(! SystemStatus::where("id","5")->first()){
            SystemStatus::create([
                'name' => 'Cancelado',
            ]);
        }
        if(! SystemStatus::where("id","6")->first()){
            SystemStatus::create([
                'name' => 'Concluído',
            ]);
        }
        if(! SystemStatus::where("id","7")->first()){
            SystemStatus::create([
                'name' => 'A Receber',
            ]);
        }
        if(! SystemStatus::where("id","8")->first()){
            SystemStatus::create([
                'name' => 'Pago',
            ]);
        }
    }
}
