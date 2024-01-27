<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_lists', function (Blueprint $table) {
            $table->id();
            $table->string('merk', 255);
            $table->string('model', 255);
            $table->string('no_car', 255);
            $table->integer('price');
            $table->string('photo');
            $table->boolean('status');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('car_lists');
    }
}
