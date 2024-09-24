<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! Priority::where("id","1")->first()){
            Priority::create([
                'name' => 'Padrão',
                'color' => 'light',
            ]);
        }
        if(! Priority::where("id","2")->first()){
            Priority::create([
                'name' => 'Baixa',
                'color' => 'secondary',
            ]);
        }
        if(! Priority::where("id","3")->first()){
            Priority::create([
                'name' => 'Média',
                'color' => 'warning',
            ]);
        }
        if(! Priority::where("id","4")->first()){
            Priority::create([
                'name' => 'Alta',
                'color' => 'danger',
            ]);
        }
        
    }
}
