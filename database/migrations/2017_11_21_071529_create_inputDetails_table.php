<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_details', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->double('amount');
			$table->integer('category_id');
			$table->integer('consumption_flag');
			$table->integer('currency_id');
			$table->string('location');
			$table->string('comment');
			$table->string('image_url');
			$table->integer('delete_flag')->default=0;
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
        Schema::dropIfExists('input_details');
    }
}
