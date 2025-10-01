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
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('jenis', ['WFH', 'WFO'])->after('id');
            $table->date('tanggal')->after('jenis');
            $table->time('jam')->after('tanggal');
            $table->string('lokasi')->nullable()->after('jam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'tanggal', 'jam', 'lokasi']);
        });
    }
};
