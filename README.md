# B3
B3 (BlaBlaBlog) is a PHP blog system built upon the [Lumen](http://lumen.laravel.com) micro-framework.

The package is available on [Packagist](https://packagist.org/packages/eivindarvesen/b3)

### WORK IN PROGRESS
This project is very much under active development, and is not usable in its current state.
In fact - this readme is not even necessarily up to date.

<!--
[![Build Status](https://travis-ci.org/eivindarvesen/blablablog.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/eivindarvesen/blablablog/downloads.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
[![Latest Stable Version](https://poser.pugx.org/eivindarvesen/blablablog/v/stable.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
[![Latest Unstable Version](https://poser.pugx.org/eivindarvesen/blablablog/v/unstable.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
[![License](https://poser.pugx.org/eivindarvesen/blablablog/license.svg)](https://packagist.org/packages/eivindarvesen/blablablog)
-->

## About
Blogposts should not use higher level headers than h3!

Blog posts are written in Markdown in your favourite editor, and pushed via git.
Posts are validated upon git-commit.
A database of data/metadata is built or updated on git-pull.
Pages are rendered serverside.
Blablablog is themeable; the default theme is built upon Bootstrap 3.
You set your usersettings in dotenv (do not track this in vcs).

## Installation
To install B3, run
```shell
composer create-project eivindarvesen/b3 <SITE> *@dev --prefer-dist
```
or run `installB3.sh` in the scripts-directory.

The webroot must be set to 'b3/public'

BlaBlaBlog also needs a database called 'blablablog' to exist, and you need to customize the dotenv-file in the project root.
Then run `php artisan migrate` in the project root.

To populate your database with your markdown blog posts, run `populate-db.sh` in the scripts-directory. (i.e. in your git post-receive script on the server).

## Development

To set up your developer-environment:
```shell
composer install
bower install
npm install
```

<!--
## Official Documentation

Documentation for BlaBlaBlog can be found [here](https://blablablog.readthedocs.org).
-->

### License

The BlaBlaBlog PHP Blog System is open-source software licensed under the [The BSD 3-Clause License](http://opensource.org/licenses/BSD-3-Clause)
