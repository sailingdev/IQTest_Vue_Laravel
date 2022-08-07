<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('result_translations')) {
            Schema::create('result_translations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('result_id')->unsigned();
                $table->string('locale')->index()->default('en');
                //----------fields for RESULT-------------
                $table->text('description')->nullable();
                //--------------------------------------

                $table->unique(['result_id', 'locale']);
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
        Schema::dropIfExists('result_translations');
    }
}
