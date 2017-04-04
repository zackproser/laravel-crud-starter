<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates a table 'items'
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('image_url');
            $table->enum('type', array('type1', 'type2', 'type3'));
            $table->datetime('created_at');
            $table->datetime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the items table.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
