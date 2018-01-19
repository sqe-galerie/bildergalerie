#!/usr/bin/env bash

MYSQL_USER='travis'
MYSQL_PW=''
MYSQL_DB='sqe_bildergalerie'

# Setup database
sudo echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo echo "DROP DATABASE IF EXISTS sqe_bildergalerie" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo echo "CREATE DATABASE sqe_bildergalerie" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo mysql --user=${MYSQL_USER} --password=${MYSQL_PW} ${MYSQL_DB} < ./Datenmodell/bildergalerie.sql