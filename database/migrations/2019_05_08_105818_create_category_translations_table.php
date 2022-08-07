<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if(! Schema::hasTable('category_translations')) {
            Schema::create('category_translations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->string('locale')->index()->default('en');
                $table->string('title');
                //added
                $table->string('question')->nullable();
                $table->text('short_desc')->nullable();
                //-----
                $table->text('description')->nullable()->default(null);
                $table->unique(['category_id', 'locale']);

                //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
                //$table->string('title')->nullable();
                //$table->text('description')->nullable();
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
        Schema::dropIfExists('category_translations');
    }
}
