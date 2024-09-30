<?php

namespace Database\Seeders;

use App\Models\InvoiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! InvoiceCategory::where("id","1")->first()){
            InvoiceCategory::create([
                'name' => 'month',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","2")->first()){
            InvoiceCategory::create([
                'name' => 'year',
                'company_id' => '1',
            ]);
        }
    }
}
