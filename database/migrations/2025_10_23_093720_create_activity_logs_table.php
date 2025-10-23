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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->string('action'); // misal: checkin, checkout, update-profile
        $table->string('model')->nullable(); // misal: Attendance
        $table->unsignedBigInteger('model_id')->nullable();
        $table->text('description')->nullable();
        $table->ipAddress('ip_address')->nullable();
        $table->string('user_agent')->nullable();
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
        Schema::dropIfExists('activity_logs');
    }
};
