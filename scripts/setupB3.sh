#!/usr/bin/env bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

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
$EDITOR $DIR/../.env

# Create dummy post

# Create dummy index page

# Create dummy project

# Create dummy flat page

# Populate DB
