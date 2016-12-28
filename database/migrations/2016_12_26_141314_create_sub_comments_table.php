<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_comments', function($table)
        {
            $table->increments('id');
            $table->integer('comment_id')->index()->unsigned();
            $table->text('comment');
            $table->timestamps();
            
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_comments', function ($table) 
        {
            $table->dropForeign(['comment_id']);
            $table->drop();
        });
    }
}
