<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTables extends Migration {

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
			$table->integer('category_id');

			//$table->unique('post_id');
		});

		Schema::create('post_tags', function(Blueprint $table)
		{
			/**
			 * Table associating posts with tags
			 */
			$table->integer('post_id');
			$table->integer('tag_id');
		});

		Schema::create('languages', function(Blueprint $table)
		{
			/**
			 * Table for languages
			 */
			$table->increments('language_id');
			$table->string('language_title');

			$table->unique('language_title');
		});

		Schema::create('categories', function(Blueprint $table)
		{
			/**
			 * Table for categories
			 */
			$table->increments('category_id');
			$table->string('category_title');
			$table->string('category_slug');

			$table->unique('category_title');
		});

		Schema::create('tags', function(Blueprint $table)
		{
			/**
			 * Table for tags
			 */
			$table->increments('tag_id');
			$table->string('tag_title');
			$table->string('tag_slug');

			$table->unique('tag_title');
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
			//$table->foreign('language_id')->references('language_id')->on('languages');
			$table->string('post_title');
			$table->string('slug');
			$table->string('cover');
			$table->string('lead');
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
		Schema::dropIfExists('blogposts');
		Schema::dropIfExists('tags');
		Schema::dropIfExists('categories');
		Schema::dropIfExists('languages');
		Schema::dropIfExists('post_tags');
		Schema::dropIfExists('post_categories');
	}

}
