<?php

namespace Database\Seeders;

use App\Models\ExternalOffice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExternalOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! ExternalOffice::where("id","1")->first()){
            ExternalOffice::create([
                'company_id' => '1',
                'name' => 'Wemerson Guimarães Adv',
                'responsible' => 'Wemerson Guimarães',
                'phone' => '61992903384',
                'email' => 'wgadvogadobsb@gmail.com',
                'cnpj' => '41422256000174',
                'pix' => '',
                'agency' => '',
                'current_account' => '',
                'bank' => '',
            ]);
        }
        if(! ExternalOffice::where("id","2")->first()){
            ExternalOffice::create([
                'company_id' => '1',
                'name' => 'Dias e Medeiros Adv',
                'responsible' => 'Livia Carolina',
                'phone' => '61991847266',
                'email' => 'advocaciadiasmedeiros@gmail.com',
                'cnpj' => '50008789000103',
                'pix' => '',
                'agency' => '',
                'current_account' => '',
                'bank' => '',
            ]);
        }
        if(! ExternalOffice::where("id","3")->first()){
            ExternalOffice::create([
                'company_id' => '1',
                'name' => 'Carrijo Belarmino',
                'responsible' => 'Tatiele Carrijo',
                'phone' => '61996066955',
                'email' => 'contato@belarminoadvogados.com.br',
                'cnpj' => '23154242000135',
                'pix' => '',
                'agency' => '',
                'current_account' => '',
                'bank' => '',
            ]);
        }
        
    }
}