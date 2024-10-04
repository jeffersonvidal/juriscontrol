<?php

namespace Database\Seeders;

use App\Models\TypePetition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypePetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! TypePetition::where("id","1")->first()){
            TypePetition::create([
                'name' => 'RT - Reclamação Trabalhista',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","2")->first()){
            TypePetition::create([
                'name' => 'Contestação',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","3")->first()){
            TypePetition::create([
                'name' => 'Manifestação',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","4")->first()){
            TypePetition::create([
                'name' => 'RO - Recurso Ordinário',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","5")->first()){
            TypePetition::create([
                'name' => 'RR - Recurso Repetitivo',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","6")->first()){
            TypePetition::create([
                'name' => 'ED - Embargo de Declaração',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","7")->first()){
            TypePetition::create([
                'name' => 'Análise de Sentença',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","8")->first()){
            TypePetition::create([
                'name' => 'Análise Processual',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
        if(! TypePetition::where("id","9")->first()){
            TypePetition::create([
                'name' => 'Análise de Caso',
                'company_id' => '1',
                'user_id' => '1',
            ]);
        }
    }
}

