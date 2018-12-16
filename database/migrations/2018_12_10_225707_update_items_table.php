<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('item_category_parent_id')->default(0);
            $table->integer('brand_id');
            $table->tinyInteger('homepage_active')->default(0);
            $table->integer('size_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('item_category_parent_id')->default(0);
            $table->dropColumn('brand_id');
            $table->dropColumn('homepage_active');
            $table->dropColumn('size_id');
        });
    }
}
