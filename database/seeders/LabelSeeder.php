<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if(! Label::where("id","1")->first()){
            Label::create([
                'name' => 'Urgente',
                'hexa_color_bg' => '#ff0000',
                'hexa_color_font' => '#ffffff',
                'company_id' => '1',
            ]);
        }
    }
}
