<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CompanySeeder::class,
            CompanyAddressSeeder::class,
            UserSeeder::class,
            UserProfileSeeder::class,
            LabelSeeder::class,
            TaskSeeder::class,
            CustomerSeeder::class,
            CustomerAddressSeeder::class,
            InvoiceSeeder::class,
            CourtCaseSeeder::class,
            PaymentRecordSeeder::class,
            SystemStatusSeeder::class,
            PrioritySeeder::class,
            ExternalOfficeSeeder::class,
            AccessPermissionSeeder::class,
            DocumentTemplateSeeder::class,
            WalletSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
