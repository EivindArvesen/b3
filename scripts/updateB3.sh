#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $(dirname $DIR)

php composer.phar update eivindarvesen/b3 --prefer-dist

cd -
