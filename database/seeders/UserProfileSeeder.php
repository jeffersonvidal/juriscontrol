<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**Profiles */
        if(! UserProfile::where("id","1")->first()){
            UserProfile::create([
                'profile' => 'Estagiário',
            ]);
        }
        
        if(! UserProfile::where("id","2")->first()){
            UserProfile::create([
                'profile' => 'Advogado',
            ]);
        }

        if(! UserProfile::where("id","3")->first()){
            UserProfile::create([
                'profile' => 'Financeiro',
            ]);
        }

        if(! UserProfile::where("id","4")->first()){
            UserProfile::create([
                'profile' => 'Administrador',
            ]);
        }

        if(! UserProfile::where("id","5")->first()){
            UserProfile::create([
                'profile' => 'Escritório Externo',
            ]);
        }

        if(! UserProfile::where("id","6")->first()){
            UserProfile::create([
                'profile' => 'God Mode',
            ]);
        }
    }
}
