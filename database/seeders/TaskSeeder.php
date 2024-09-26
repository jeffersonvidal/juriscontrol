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
                'title' => 'Levantamento dos documentos do cliente',
                'description' => '',
                'status' => '1',
                'source' => '1',
                'delivery_date' => '2024-11-09',
                'end_date' => '2024-11-05',
                'responsible_id' => '3',
                'client' => fake()->name(),
                'process_number' => '0000230-47.2024.5.10.0018',
                'court' => 'TRT10',
                'priority' => '1',
                'label_id' => '1',
                'author_id' => '1',
                'company_id' => '1',
            ]);
        }
    }
}
