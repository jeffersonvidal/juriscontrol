<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! Task::where("id","1")->first()){
            Task::create([
                'description' => 'Levantamento dos documentos do vendedor',
                'priority' => 'Média',
                'label_id' => '1',
                'end_date' => '2024-08-30',
                'law_suit_case_id' => '1',
                'owner_user_id' => '1',
                'company_id' => '1',
                'employees_id' => '1,2',
            ]);
        }
    }
}
