<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('instructions');
            $table->string('condition');
			$table->set('recurring', ['0', '1']);
            $table->string('calendar_interval');
			$table->set('calendar_interval_unit', ['day', 'week', 'month', 'year']);
            $table->string('running_hours_interval');
            $table->string('alternative_interval')->nullable();
            $table->string('alternative_interval_description')->nullable();
            $table->string('service_group')->nullable();
            $table->string('model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
