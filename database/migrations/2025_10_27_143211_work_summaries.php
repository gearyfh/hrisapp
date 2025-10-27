<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('work_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            
            // Rekap bulanan
            $table->year('year');
            $table->unsignedTinyInteger('month');

            $table->integer('work_days')->default(0);         // jumlah hari kerja
            $table->decimal('work_hours', 6, 2)->default(0);  // total jam kerja
            $table->decimal('overtime_hours', 6, 2)->default(0); // total jam lembur
            $table->decimal('total_hours', 6, 2)->default(0); // jam kerja + lembur
            
            $table->timestamps();
            
            // Supaya setiap karyawan hanya satu rekap per bulan
            $table->unique(['employee_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('work_summaries');
    }
};
