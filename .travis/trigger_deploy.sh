#!/bin/bash


if [ ${TRAVIS_BRANCH} != "develop" ]; then
    exit
fi

curl "http://deploy.hildes-bildergalerie.de/?token=${deploy_token}"
