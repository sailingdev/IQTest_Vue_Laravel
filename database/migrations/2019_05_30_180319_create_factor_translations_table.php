<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactorTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factor_id')->unsigned();
            $table->string('locale')->index()->default('en');
            //----------fields for FACTOR-------------
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            //--------------------------------------

            $table->unique(['factor_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factor_translations');
    }
}