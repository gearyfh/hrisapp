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
        Schema::create('request_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('module_type'); // leave, correction, overtime
            $table->unsignedBigInteger('module_id');
            $table->foreignId('approved_by')->constrained('users');
            $table->enum('status', ['approved', 'rejected']);
            $table->text('note')->nullable();
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
    }
};
