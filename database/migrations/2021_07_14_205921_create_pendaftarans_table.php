<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', [1, 0]);
            $table->string('status_kesehatan', 191);
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('jadwal_id')->nullable();
            $table->foreignUuid('status_kesehatan_id')->nullable();
            $table->foreignUuid('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade');
            $table->foreign('status_kesehatan_id')->references('id')->on('status_kesehatan')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
}
