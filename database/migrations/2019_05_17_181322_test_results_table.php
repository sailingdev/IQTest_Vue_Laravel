<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('test_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id');
            $table->integer('time');    // second
            $table->text('result');
            $table->text('topic_key');
            $table->string('mobile_number');
            $table->float('pay_amount')->default(0);
            $table->boolean('extra_pay')->default(false);
            $table->string('token')->nullable();
            $table->boolean('pay_status')->default(false);
            $table->timestamps();
            //$table->softDeletes();
            //$table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
