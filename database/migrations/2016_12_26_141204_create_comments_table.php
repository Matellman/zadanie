<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function($table)
        {
            $table->increments('id');
            $table->integer('hotel_id')->index()->unsigned();
            $table->text('comment');
            $table->integer('rating');
            $table->integer('know_from')->index()->unsigned();
            $table->timestamps();
            
            $table->foreign('hotel_id')
                ->references('id')
                ->on('hotels'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function ($table) 
        {
            $table->dropForeign(['hotel_id']);
            $table->drop();
        });
    }
}
