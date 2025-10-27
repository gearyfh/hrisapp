<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Company, User, Employee, Attendance,
    OvertimeRequest, LeaveRequest, LeaveType
};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HugeDummySeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Sakit'],
            ['name' => 'Izin'],
            ['name' => 'Cuti Tahunan']
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::firstOrCreate(['name' => $type['name']]);
        }

        for($c = 1; $c <= 3; $c++) {

            $company = Company::create([
                'company_code' => "CMP00$c",
                'company_name' => "Company $c",
                'address' => "Address $c",
                'email' => "company$c@mail.com"
            ]);

            for($u = 1; $u <= 10; $u++) {

                $role = $u == 1 ? 'admin' : 'employee';

                $user = User::create([
                    'company_id' => $company->id,
                    'name' => "User$c$u",
                    'email' => "user$c$u@mail.com",
                    'password' => Hash::make('password'),
                    'role' => $role,
                ]);

                $employee = Employee::create([
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'name' => "Karyawan $c$u",
                    'hire_date' => now()->subMonths(rand(1,12)),
                ]);

                for ($d = 1; $d <= 12; $d++) {
                    $date = now()->subDays($d);

                    // Absen probabilitas: hadir 80%, izin 10%, sakit 10%
                    $status = ['hadir','izin','sakit'][array_rand([0,1,2])];

                    if ($status == 'hadir') {
                        $in = now()->setTime(rand(7,9), rand(0,59));
                        $out = (clone $in)->addHours(rand(7,10));

                        // Insert attendance
                        Attendance::create([
    'employee_id' => $employee->id,
    'jenis' => 'WFO',
    'tanggal_masuk' => $date->format('Y-m-d'),
    'jam_masuk' => $in->format('H:i:s'),
    'tanggal_keluar' => $date->format('Y-m-d'),
    'jam_keluar' => $out->format('H:i:s'),
    'lokasi' => 'Office',
    'work_hours' => $out->diffInHours($in),
]);


                        // Random lembur 30%
                        if (rand(1, 100) > 70) {
                            OvertimeRequest::create([
    'employee_id' => $employee->id,
    'attendance_id' => null,
    'date' => $date->format('Y-m-d'),
    'start_time' => $out->format('H:i:s'),
    'end_time' => $out->addHours(rand(1,3))->format('H:i:s'),
    'duration' => rand(1,3),
    'status' => 'approved'
]);

                        }

                    } else {
                        LeaveRequest::create([
                            'employee_id' => $employee->id,
                            'leave_type_id' => LeaveType::inRandomOrder()->first()->id,
                            'start_date' => $date,
                            'end_date' => $date,
                            'total_days' => 1,
                            'status' => 'approved'
                        ]);
                    }
                }
            }
        }

        echo "✅ Huge dummy data generated successfully!\n";
    }
}
