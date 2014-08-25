<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardInstancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cardInstances', function(Blueprint $table) {
			$table->increments('id');
      $table->integer('from_user_id')->unsigned()->index();
      $table->foreign('from_user_id')->references('id')->on('users');
			$table->float('amount');
			$table->tinyInteger('currency');
			$table->integer('to_user_id');
			$table->string('to_user_email');
      $table->integer('card_id')->unsigned();
      $table->foreign('card_id')->references('id')->on('cards');
			$table->tinyInteger('status')->default(0);
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
		Schema::drop('cardInstances');
	}

}
