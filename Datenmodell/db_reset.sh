#!/bin/bash
MYSQL_USER='homestead'
MYSQL_PW='secret'
MYSQL_DB='sqe_bildergalerie'
VM_SYNC_FOLDER='/vagrant_data'

sudo mysql --user=${MYSQL_USER} --password=${MYSQL_PW} ${MYSQL_DB} < ./db_reset.sql
