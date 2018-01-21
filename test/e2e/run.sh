#!/bin/bash

## start the php server 
# php -S localhost:8888 -t ../../ &
# SERVER_PID=$!

# start the php server (dont show logs)
php -S 0.0.0.0:8888 -t ../../  >& /dev/null &
SERVER_PID=$!

# run the e2e tests
#$(npm bin)/testcafe all test/**/*.test.js
SERVER_URL=http://5.5.5.5 $(npm bin)/testcafe chrome test/**/*.test.js
# shutdown the server
kill $SERVER_PID
