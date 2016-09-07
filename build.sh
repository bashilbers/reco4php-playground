#!/usr/bin/env bash

docker run -it --rm \
    -v $(pwd)/app:/src \
    -v ~/.composer/cache/ \
    bashilbers/composer update --ignore-platform-reqs