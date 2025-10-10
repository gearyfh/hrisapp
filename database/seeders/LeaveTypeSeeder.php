<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            [
                'type' => 'cuti',
                'name' => 'Cuti Tahunan',
                'deduct_quota' => true,
            ],
            [
                'type' => 'cuti',
                'name' => 'Cuti Melahirkan',
                'deduct_quota' => true,
            ],
            [
                'type' => 'izin_sakit',
                'name' => 'Sakit',
                'deduct_quota' => false,
            ],
            [
                'type' => 'izin_sakit',
                'name' => 'Izin Pribadi',
                'deduct_quota' => false,
            ],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::updateOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}
