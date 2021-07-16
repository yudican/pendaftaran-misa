<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataUmatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_umat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_lengkap', 50);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('linkungan', 191);
            $table->string('wilayah', 191);
            $table->string('telepon', 15);
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
        Schema::dropIfExists('data_umat');
    }
}
