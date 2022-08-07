<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('answer_translations')) {
        Schema::create('answer_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('answer_id')->unsigned();
            $table->string('locale')->index()->default('en');
            //----------fields for ANSWER-------------
            $table->text('txt')->nullable();
            $table->string('result_text')->nullable();
            //--------------------------------------

            $table->unique(['answer_id', 'locale']);
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
        Schema::dropIfExists('answer_translations');
    }
}