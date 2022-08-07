<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('test_translations')) {
            Schema::create('test_translations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('test_id')->unsigned();
                $table->string('locale')->index()->default('en');
                //----------fields for TEST-------------
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->text('instruction')->nullable();
                $table->text('pre_page_title')->nullable();
                $table->text('pre_page_desc')->nullable();
                $table->text('post_page_title')->nullable();
                $table->text('post_page_desc')->nullable();
                //--------------------------------------

                $table->unique(['test_id', 'locale']);

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
        Schema::dropIfExists('test_translations');
    }
}
