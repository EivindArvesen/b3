<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			/**
			 * Table for pages
			 */
			$table->increments('page_id');
			$table->string('page_title');
			$table->longText('body');
			$table->boolean('published');
			$table->string('type');
			$table->string('style');
			$table->string('transparent');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pages');
	}

}
