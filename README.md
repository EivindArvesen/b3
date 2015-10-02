# BlaBlaBlog
BlaBlaBlog is a PHP blog system built upon the Laravel Lumen micro-framework.

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

Blog posts are written in Markdown in your favourite editor, and pushed via git.
Posts are validated upon git-commit.
A database of metadata is built or updated on git-pull.
Pages are rendered serverside.
Blablablog is themeable; the default theme is built upon Bootstrap 3.
You set your usersettings in dotenv (do not track this in vcs).


To set up your developer-environment:

    composer install
    bower install
    npm install

## Official Documentation

Documentation for the framework can be found [here](https://blablablog.readthedocs.org).

### License

The BlaBlaBlog PHP Blog System is open-source software licensed under the [The BSD 3-Clause License](http://opensource.org/licenses/BSD-3-Clause)
