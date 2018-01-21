#!/bin/bash

cd "$(dirname "$0")"

## start the php server 
# php -S localhost:8888 -t ../../ &
# SERVER_PID=$!

# start the php server (dont show logs)
php -S 0.0.0.0:8888 -t ../../  >& /dev/null &
SERVER_PID=$!

# run the e2e tests
testcafe all test/**/*.test.js
TEST_RESULT=$?

# shutdown the server
kill ${SERVER_PID}

exit ${TEST_RESULT}