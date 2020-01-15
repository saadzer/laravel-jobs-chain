<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobChainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_chains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id');
            $table->integer('child_id');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('job_statuses');
            $table->foreign('child_id')->references('id')->on('job_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_chains');
    }
}
