<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('CardsTableSeeder');
		$this->call('TransactionsTableSeeder');
		$this->call('CardinstancesTableSeeder');
		$this->call('Yt_resultsTableSeeder');
		$this->call('YtresultsTableSeeder');
	}

}
