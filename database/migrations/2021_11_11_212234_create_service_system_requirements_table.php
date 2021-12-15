<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSystemRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_system_requirements', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->string('note')->nullable();
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('network')->nullable();
            $table->string('storage')->nullable();
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
        Schema::dropIfExists('service_system_requirements');
    }
}
