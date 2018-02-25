#!/bin/bash


if [ ${TRAVIS_BRANCH} != "feature/setup-cd" ]; then
    exit
fi

curl "http://localhost:4326/?token=${deploy_token}"
