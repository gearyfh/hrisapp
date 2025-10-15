<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();

            // Relasi ke karyawan & absensi (opsional)
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('attendance_id')->nullable()->constrained('attendances')->onDelete('set null');

            // Data lembur
            $table->date('date');                     // tanggal lembur
            $table->time('start_time');               // jam mulai lembur
            $table->time('end_time');                 // jam selesai lembur
            $table->decimal('duration', 5, 2)->nullable(); // durasi jam lembur (otomatis dihitung)
            $table->text('reason')->nullable();       // alasan lembur

            // Status approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('comment')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('overtime-requests');
    }
};
