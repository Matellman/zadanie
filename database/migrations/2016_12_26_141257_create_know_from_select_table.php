<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKnowFromSelectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('know_from_select', function($table)
        {
            $table->increments('id');
            $table->string('name');
        });
 
        Artisan::call('db:seed', array('--class' => 'KnowFromSelectSeeder'));
        
        Schema::table('comments', function($table)
        {
            $table->foreign('know_from')
                ->references('id')
                ->on('know_from_select'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function($table)
        {
           $table->dropForeign(['know_from']);
        });
        
        Schema::table('know_from_select', function ($table) 
        {           
            $table->drop();
        });
    }
}
