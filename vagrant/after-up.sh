#!/usr/bin/env bash

MYSQL_USER='homestead'
MYSQL_PW='secret'

sudo echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}