# BlaBlaBlog
BlaBlaBlog is a PHP blog system built upon the Laravel [Lumen](http://lumen.laravel.com) micro-framework.

### WORK IN PROGRESS
This project is very much under active development, and is not usable in its current state.
In fact - this readme is not even necessarily up to date.

#### TODO:
http://tyler.io/importing-jekyll-posts-into-wordpress/
- Cement php (markdown) dependencies
- Implement backend functionality
- Script server setup (production-branch)
- Make git hook scripts (pre-commit, master: validate markup) + (post-checkout, production: compile markup, build database)

<!--
[![Build Status](https://travis-ci.org/eivindarvesen/blablablog.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/eivindarvesen/blablablog/downloads.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
[![Latest Stable Version](https://poser.pugx.org/eivindarvesen/blablablog/v/stable.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
[![Latest Unstable Version](https://poser.pugx.org/eivindarvesen/blablablog/v/unstable.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
[![License](https://poser.pugx.org/eivindarvesen/blablablog/license.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
-->

## About

Blog posts are written in Markdown in your favourite editor, and pushed via git.
Posts are validated upon git-commit.
A database of data/metadata is built or updated on git-pull.
Pages are rendered serverside.
Blablablog is themeable; the default theme is built upon Bootstrap 3.
You set your usersettings in dotenv (do not track this in vcs).


To set up your developer-environment:

    composer install
    bower install
    npm install

BlaBlaBlog also needs a database called 'blablablog' to exist, and you need to customize the dotenv-file in the project root.
Then run `php artisan migrate` in the project root.

To populate your database with your markdown blog posts, run `composer dump-autoload`, and then run `php artisan db:seed` (i.e. in your git post-receive script on the server).


<!--
## Official Documentation

Documentation for BlaBlaBlog can be found [here](https://blablablog.readthedocs.org).
-->

### License

The BlaBlaBlog PHP Blog System is open-source software licensed under the [The BSD 3-Clause License](http://opensource.org/licenses/BSD-3-Clause)
