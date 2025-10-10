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
        Schema::create('leave_types', function (Blueprint $table) {
        $table->id();
        $table->enum('type',['cuti', 'izin_sakit'])->default('cuti'); // Cuti 1 / Izin atau sakit 2
        $table->string('name'); // Cuti Tahunan, Sakit, Izin
        $table->boolean('deduct_quota')->default(true);
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
    }
};
