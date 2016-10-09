#!/usr/bin/env bash

if [ $# -lt 2 ]
  then
    echo "Arguments needed: <user>@<server> webroot"
    echo "e.g. l33th4x0r@login.servershop.com www/"
    exit 1
fi

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $(dirname $DIR)

SERVERROOT=$(ssh $1 "pwd")
WEBROOT=$SERVERROOT/"$2"

$DIR/../. $1:$WEBROOT/

rsync -alz --delete --stats --progress --exclude=".*" --exclude 'public/content' $DIR/../. $1:$WEBROOT/

cd - > /dev/null 2>&1

echo "SYNCED TO SERVER!"
