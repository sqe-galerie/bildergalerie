#!/bin/bash


if [ ${TRAVIS_BRANCH} != "feature/setup-cd" ]; then
    exit
fi

echo "http://deploy.hildes-bildergalerie.de/?token=${deploy_token}"
