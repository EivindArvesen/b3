#!/usr/bin/env bash

if [ $# -lt 2 ]
  then
    echo "Arguments needed: <user>@<server> webroot"
    echo "e.g. l33th4x0r@login.servershop.com /var/www/"
    exit 1
fi

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $(dirname $DIR)

# Create git repo and ignore everything except user content and environment config
git init $DIR/..
cat > $DIR/../.git/config <<- EOM
/*
/*/
!/storage/app/
!/.env
EOM

# Configure environment
cp $DIR/../.env.example $DIR/../.env
KEY=$(php -r "echo md5(uniqid()).\"\n\";")
sed 's/secret/$KEY/g' $DIR/../.env > $DIR/../.env
$EDITOR $DIR/../.env

# Create dummy index page
mkdir -p $DIR/../storage/app/pages
cat > $DIR/../storage/app/pages/index.md <<- EOM
title: About
slug: useless
#    [optional]
published: true
#    [optional]
type: index
#    [optional, get theme template based on name]
style: dark | light | default
#    [optional, set css class based on name]
transparent: false | true
#    [optional, set css class based on name]
-------
<div class="jumbotron">
<div class="container">
<div class="row">
<div class="col-md-6">
<h1>Hello, world!</h1>
<p class="lead">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
</div>
<div class="col-md-6 text-right">
<img class="img-circle-thumbnail" src="https://placeimg.com/480/480/tech" alt="placeholder+image">
</div>
</div>
</div>
</div>

<div class="container">
<!-- Example row of columns -->
<div class="row text-center">
<div class="col-md-12">
<h2>Heading</h2>
<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>
</div>
</div> <!-- /container -->

<div class="container">
<!-- Example row of columns -->
<div class="row text-center">
<div class="col-md-4">
<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
<h2>Heading</h2>
<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>
<div class="col-md-4">
<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
<h2>Heading</h2>
<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>
<div class="col-md-4">
<img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
<h2>Heading</h2>
<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>
</div>
</div>

EOM

# Create dummy post
mkdir -p $DIR/../storage/app/blog/`date +%Y/%m/%d`
cat > $DIR/../storage/app/blog/`date +%Y/%m/%d`/test.md <<- EOM
title: Blog post
language: English
category: Test-Category
tags: one, two, three
slug: URLified-title-here
#    [optional]
modified: 2016-07-30
#    [optional]
lead: intro
#    [optional]
published: true
#    [optional]
type: feature
#    [optional, get theme template based on name]
style: dark | light | default
#    [optional, set css class based on name]
transparent: false | true
#    [optional, set css class based on name]
-------
###Test
This is my **markdown** content!
EOM

# Create dummy project
mkdir -p $DIR/../storage/app/projects/Category
cat > $DIR/../storage/app/pages/contact.md <<- EOM
title: Project One
slug:
#    [optional]
date: 2016-07-30
    [optional]
description: desc
#    [optional]
list-title: Built with
list-content: Technology, more technology
published: true
#    [optional]
type: software
#    [optional, get theme template based on name]
style: dark | light | default
#    [optional, set css class based on name]
transparent: false | true
#    [optional, set css class based on name]
-------
Lorem ipsum
EOM

# Create dummy flat page
cat > $DIR/../storage/app/pages/contact.md <<- EOM
title: Contact
slug: contact
#    [optional]
published: true
#    [optional]
type: page
#    [optional, get theme template based on name]
style: dark | light | default
#    [optional, set css class based on name]
transparent: false | true
#    [optional, set css class based on name]
-------
<p class="lead">Description...</p>

Testings
EOM

# Populate DB
bash $DIR/populate-db.sh

# Set up key exchange with server
cat ~/.ssh/id_rsa.pub | ssh $1 'cat >> .ssh/authorized_keys'

# Set up git hooks and scripts on server and client
HOOK="#!/bin/sh\ngit --work-tree=$2 --git-dir=$(dirname $2)/repo/site.git checkout -f\nbash $2/scripts/populate-db.sh"
ssh $1 "mkdir repo && cd repo && mkdir site.git && cd site.git && git init --bare && cd hooks && echo $HOOK > post-receive && chmod +x post-receive"

git remote add live ssh://$1/$(dirname $2)/repo/site.git

git add -A && git commit -m "Set up repo"

echo "Now you need only to push to publish!"

cd -
