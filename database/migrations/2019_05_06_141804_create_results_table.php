<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('results')){
            Schema::create('results', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('min_score');
                $table->integer('max_score');
                
                $table->string('img_url')->nullable();
                $table->string('file_url')->nullable();
                $table->integer('test_id');
                $table->timestamps();
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
        Schema::dropIfExists('results');
    }
}
