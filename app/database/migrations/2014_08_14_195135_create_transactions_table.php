<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
			$table->increments('id');
      $table->integer('user_id')->unsigned()->index();
      $table->foreign('user_id')->references('id')->on('users');
			$table->tinyInteger('type');
			$table->tinyInteger('mean');
			$table->float('credit');
			$table->float('amount');
			$table->string('target_info');
			$table->integer('target_user_id');
			$table->integer('target_card_id');
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
		Schema::drop('transactions');
	}

}
