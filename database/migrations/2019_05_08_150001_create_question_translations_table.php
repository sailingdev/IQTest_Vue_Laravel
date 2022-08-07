<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('question_translations')) {
        Schema::create('question_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            $table->string('locale')->index()->default('en');
            //----------fields for QUESTION-------------
            $table->text('txt')->nullable();
            $table->string('correct_ans_exp')->nullable();
            //--------------------------------------

            $table->unique(['question_id', 'locale']);

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
        Schema::dropIfExists('question_translations');
    }
}