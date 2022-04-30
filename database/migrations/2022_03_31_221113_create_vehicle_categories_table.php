<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 

        Schema::create('vehicle_categories', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('range');
            $table->string('model');
            $table->string('vehicle_type');
            $table->text('derivative'); // this will be removed
            $table->index(['make','range','model']); 
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
        Schema::dropIfExists('vehicle_categories');
    }
}
