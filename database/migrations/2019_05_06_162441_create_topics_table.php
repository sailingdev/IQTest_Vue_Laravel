<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('topics')){
            Schema::create('topics', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('value')->nullable();
                $table->text('description')->nullable();
                //$table->integer('test_id');
                $table->timestamps();
                //$table->softDeletes();
                //$table->index(['deleted_at']);
            });
        //}
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
