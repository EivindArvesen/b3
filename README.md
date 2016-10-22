# B3
B3 (BlaBlaBlog) is a PHP blog system built upon the [Lumen](http://lumen.laravel.com) micro-framework.

The package is available on [Packagist](https://packagist.org/packages/eivindarvesen/b3)

### WORK IN PROGRESS
This project is very much under active development, and is not usable in its current state.
In fact - this readme is not even necessarily up to date.

<!--
[![Build Status](https://travis-ci.org/eivindarvesen/b3.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/eivindarvesen/b3/downloads.svg)](https://packagist.org/packages/eivindarvesen/b3)
[![Latest Stable Version](https://poser.pugx.org/eivindarvesen/b3/v/stable.svg)](https://packagist.org/packages/eivindarvesen/b3)
[![Latest Unstable Version](https://poser.pugx.org/eivindarvesen/b3/v/unstable.svg)](https://packagist.org/packages/eivindarvesen/b3)
[![License](https://poser.pugx.org/eivindarvesen/b3/license.svg)](https://packagist.org/packages/eivindarvesen/b3)
-->

## About
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

BlaBlaBlog also needs a database, the connection to which is specified in the dotenv-file in the project root.

To automatically set up your site, run the `setupB3.sh` script in the scripts-directory.

## Development

To set up your developer-environment:
```shell
composer install
bower install
npm install
```

<!--
## Official Documentation

Documentation for BlaBlaBlog can be found [here](https://b3.readthedocs.org).
-->

### License

The BlaBlaBlog PHP Blog System is open-source software licensed under the [The BSD 3-Clause License](http://opensource.org/licenses/BSD-3-Clause)
