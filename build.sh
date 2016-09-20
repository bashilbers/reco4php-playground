#!/usr/bin/env bash

docker run -it --rm \
    -v $(pwd)/app:/src \
    -v ~/.composer:/root/.composer \
    bashilbers/composer update --ignore-platform-reqs