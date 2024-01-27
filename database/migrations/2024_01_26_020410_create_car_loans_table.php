<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_loans', function (Blueprint $table) {
            $table->id();
            $table->integer('car_id');
            $table->integer('user_id');
            $table->string('no_loan', 255);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->nullable()->default(true);
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
        Schema::dropIfExists('car_loans');
    }
}
