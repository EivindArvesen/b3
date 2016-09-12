<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			/**
			 * Table for projects
			 */
			$table->increments('project_id');
			$table->string('slug');
			$table->string('category');
			$table->string('project_title');
			$table->string('date');
			$table->string('description');
			$table->string('list_title');
			$table->longText('list_content');
			$table->longText('body');
			$table->boolean('published');
			$table->string('type');
			$table->string('style');
			$table->string('transparent');
			$table->string('sticky');
			$table->string('seamless');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('projects');
	}

}
