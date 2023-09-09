#!/bin/sh

# Install composer dependencies
if [ ! -d "vendor" ] && [ -f "composer.json" ]; then
    composer config --global process-timeout 6000
    composer install
    composer dump-autoload
fi

# Install npm dependencies
if [ ! -d "node_modules" ] && [ -f "package.json" ]; then
    yarn add vite
    yarn install
    yarn build
fi
# Run apache foreground
apachectl -D FOREGROUND