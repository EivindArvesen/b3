<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_categories', function(Blueprint $table)
		{
			/**
			 * Table for associating posts with a category
			 */
			$table->integer('post_id');
			$table->increments('category_id');

			$table->unique('category_id');
		});

		Schema::create('post_tags', function(Blueprint $table)
		{
			/**
			 * Table associating posts with tags
			 */
			$table->integer('post_id');
			$table->increments('tag_id');

			$table->unique('tag_id');
		});

		Schema::create('languages', function(Blueprint $table)
		{
			/**
			 * Table for languages
			 */
			$table->increments('language_id');
			$table->string('language_title');

			$table->unique('language_id');
		});

		Schema::create('categories', function(Blueprint $table)
		{
			/**
			 * Table for categories
			 */
			$table->increments('category_id');
			$table->string('category_title');

			$table->unique('category_id');
		});

		Schema::create('tags', function(Blueprint $table)
		{
			/**
			 * Table for tags
			 */
			$table->increments('tag_id');
			$table->string('tag_title');

			$table->unique('tag_id');
		});

		Schema::create('blogposts', function(Blueprint $table)
		{
			/**
			 * Table for blog posts
			 */
			$table->increments('post_id');
			$table->dateTime('created_at');
			$table->dateTime('modified_at');
			$table->integer('language_id')->unsigned();
			$table->foreign('language_id')->references('language_id')->on('languages');
			//$table->string('category');
			//$table->string('tags');
			$table->string('post_title');
			$table->string('slug');
			$table->string('body');
			$table->string('author');
			$table->boolean('published');

			$table->unique('post_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog');
	}

}
