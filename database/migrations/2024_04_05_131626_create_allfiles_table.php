<?php

// database/migrations/2024_04_06_000000_create_allfiles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllfilesTable extends Migration
{
    public function up()
    {
        Schema::create('allfiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // You may also define a foreign key for guest_id if necessary
        });
    }

    public function down()
    {
        Schema::dropIfExists('allfiles');
    }
}

