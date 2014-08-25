<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateYtResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ytResults', function(Blueprint $table) {
			$table->increments('id');
			$table->string('video_id');
			$table->string('url');
			$table->string('title');
			$table->string('username');
			$table->string('user_id');
			$table->string('user_url');
			$table->integer('views');
			$table->datetime('published_at');
			$table->string('thumb');
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
		Schema::drop('ytResults');
	}

}
