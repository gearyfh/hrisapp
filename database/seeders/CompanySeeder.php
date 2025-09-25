<?php

// database/seeders/CompanySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'company_code' => '001',
            'company_name' => 'Laravel Inc.',
        ]);
    }
}

