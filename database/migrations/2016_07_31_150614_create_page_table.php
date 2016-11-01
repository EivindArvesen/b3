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
			$table->string('slug');
			$table->string('page_title');
			$table->string('bg');
			$table->string('feature');
			$table->longText('body');
			$table->boolean('published');
			$table->string('type');
			$table->string('style');
			$table->string('transparent');
			$table->string('sticky');
			$table->string('seamless');

			$table->unique('slug');
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
