#!/bin/bash

echo 'Welcome to the MariaDB Container initializer script'

DIRECTORY='datadir'
MARIADBDB_VERSION='10.5'
DB_NAME='example'

if [ -d "$PWD/$DIRECTORY" ]; then
  echo 'Starting MariaDB Docker Container'
  # shellcheck disable=SC2086
  docker run -p 127.0.0.1:3306:3306 --name mariadb_$DB_NAME -v $PWD/$DIRECTORY:/var/lib/mysql -d mariadb:$MARIADBDB_VERSION
  echo 'Waiting 5 sec for DB startup'
  sleep 5
else
  echo 'Creating local database folder'
  mkdir "$PWD/$DIRECTORY"

  echo 'Starting MariaDB Docker Container'
  # shellcheck disable=SC2086
  docker run -p 127.0.0.1:3306:3306 --name mariadb_$DB_NAME -v $PWD/$DIRECTORY:/var/lib/mysql -e MARIADB_ROOT_PASSWORD=password -d mariadb:$MARIADBDB_VERSION

  echo 'Waiting 60 sec for complete DB startup'
  sleep 60

  echo "Creating database $DB_NAME"
  mysql --host="127.0.0.1" --port="3306" --user="root" --password="password" --execute="CREATE DATABASE $DB_NAME; USE $DB_NAME"
fi

echo 'All done! May the force be with you.'
