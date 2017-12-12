#!/bin/bash

## start the php server 
# php -S localhost:8888 -t ../../ &
# SERVER_PID=$!

# start the php server (dont show logs)
php -S localhost:8888 -t ../../  >& /dev/null &
SERVER_PID=$!

# run the e2e tests
testcafe all test/**/*.test.js

# shutdown the server
kill $SERVER_PID
