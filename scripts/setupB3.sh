#!/usr/bin/env bash

if [ $# -lt 3 ]
  then
    echo "Arguments needed: <user>@<server> webroot url-without-www"
    echo "e.g. l33th4x0r@login.servershop.com www/ sitename.com"
    exit 1
fi

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $(dirname $DIR)

SERVERROOT=$(ssh $1 "pwd")
WEBROOT=$SERVERROOT/"$2"

# remove repo stuff if installed via git
rm -rf $(dirname $DIR)/.git

# Edit config
$EDITOR $DIR/../config/bbb_config.php

# Configure server environment
cat > $DIR/../.env <<- EOM
# SERVER ENVIRONMENT CONFIGURATION

EOM
cat $DIR/../.env.example >> $DIR/../.env

KEY=$(php -r "echo md5(uniqid()).\"\n\";")
sed -i '' -e 's/secret/'$KEY'/g' $DIR/../.env
$EDITOR $DIR/../.env

# Create dummy index page
mkdir -p $DIR/../public/content/pages
cat > $DIR/../public/content/pages/index.md <<- EOM
---

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

---

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
mkdir -p $DIR/../public/content/blog/`date +%Y/%m/%d`
curl -o $DIR/../public/content/blog/`date +%Y/%m/%d`/Lenna.png https://upload.wikimedia.org/wikipedia/en/2/24/Lenna.png
cat > $DIR/../public/content/blog/`date +%Y/%m/%d`/test.md <<- EOM
---

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

---

###Test
![alt text](Lenna.png "Logo Title Text 1")

This is my **markdown** content!

EOM

# Create dummy project
mkdir -p $DIR/../public/content/projects/Category
cat > $DIR/../public/content/projects/Category/project.md <<- EOM
---

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

---

Lorem ipsum
EOM

# Create dummy flat page
cat > $DIR/../public/content/pages/contact.md <<- EOM
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

---

<p class="lead">Description...</p>

Testings
EOM

# Install composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Populate local DB
bash $DIR/populate-db.sh

# Set up key exchange with server
cat ~/.ssh/id_rsa.pub | ssh $1 'cat >> .ssh/authorized_keys'

# Set up apache redirect to public root
ACCESS="RewriteEngine On
RewriteCond %{THE_REQUEST} /public/([^\s?]*) [NC]
RewriteRule ^ %1 [L,NE,R=302]
RewriteRule ^((?!public/).*)$ public/"'$1 [L,NC]'

ssh $1 "echo '$ACCESS' > $WEBROOT/.htaccess"

# Copy B3 installation to server
scp -rp $DIR/../. $1:$WEBROOT/

# Create git repo
git init $DIR/..

# Ignore everything except user content
cat > $DIR/../.gitignore <<- EOM
*
!*/
/storage
/vendor
!/public/content/**
EOM

# Add first commit
git add -A && git commit -m "Set up repo"

# Set up git hooks and scripts on server and client
HOOK="#!/bin/sh
git --work-tree=$WEBROOT --git-dir=$SERVERROOT/repo/site.git checkout -f master
cd $WEBROOT && bash $WEBROOT/scripts/populate-db.sh"
ssh $1 "mkdir repo && cd repo && mkdir site.git && cd site.git && git init --bare && cd hooks && echo '$HOOK' > post-receive && chmod +x post-receive"

git remote add live ssh://$1$SERVERROOT/repo/site.git

# Configure local environment
cat > $DIR/../.env <<- EOM
# LOCAL ENVIRONMENT CONFIGURATION

EOM
cat $DIR/../.env.example >> $DIR/../.env

KEY=$(php -r "echo md5(uniqid()).\"\n\";")
sed -i '' -e 's/secret/'$KEY'/g' $DIR/../.env
$EDITOR $DIR/../.env

git push live master

cd - > /dev/null 2>&1

echo "To publish changes, issue the following command:    git push live master"
