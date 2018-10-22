<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('phone');
            $table->string('work_hour');
            $table->string('facebook');
            $table->string('email');
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->text('google_id')->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('webmaster')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
