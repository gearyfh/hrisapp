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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('leave_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason')->nullable();

            // status aktif/tidak
            $table->enum('status', ['active', 'inactive'])->default('active');

            // approval fields
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // foreign keys
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_requests');
    }
};
