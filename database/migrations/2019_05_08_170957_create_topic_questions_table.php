<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('topic_questions')) {
            Schema::create('topic_questions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('img_url')->nullable();
                $table->integer('topic_id');
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
        Schema::dropIfExists('topic_questions');
    }
}
