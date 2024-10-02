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
                'name' => 'Salário',
                'value' => 'salario',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","2")->first()){
            InvoiceCategory::create([
                'name' => 'Empréstimo',
                'value' => 'emprestimo',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","3")->first()){
            InvoiceCategory::create([
                'name' => 'Investimento',
                'value' => 'investimento',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","4")->first()){
            InvoiceCategory::create([
                'name' => 'Honorários',
                'value' => 'honorarios',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","5")->first()){
            InvoiceCategory::create([
                'name' => 'Contrato',
                'value' => 'contrato',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","6")->first()){
            InvoiceCategory::create([
                'name' => 'Acordo',
                'value' => 'acordo',
                'company_id' => '1',
            ]);
        }
        if(! InvoiceCategory::where("id","7")->first()){
            InvoiceCategory::create([
                'name' => 'Diversos',
                'value' => 'diversos',
                'company_id' => '1',
            ]);
        }
    }
}
