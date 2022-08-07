<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicQuestionTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if(! Schema::hasTable('topic_question_translations')) {
            Schema::create('topic_question_translations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('topic_question_id')->unsigned();
                $table->string('locale')->index()->default('en');
                //----------fields for QUESTION-------------
                $table->string('txt')->nullable();
                $table->string('correct_ans_exp')->nullable();
                //--------------------------------------

                $table->unique(['topic_question_id', 'locale']);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_question_translations');
    }
}
