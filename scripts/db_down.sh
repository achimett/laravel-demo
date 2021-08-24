#!/bin/bash

DB_NAME='example'

echo 'Taking down the DB'
docker container stop mariadb_$DB_NAME
docker container rm mariadb_$DB_NAME
echo 'Done. Bye!'
