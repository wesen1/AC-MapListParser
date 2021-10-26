#!/usr/bin/env bash

# array usage in apt-get: https://gist.github.com/edouard-lopez/10008944

# Package list
packages=(

  # PHP7
  php7.0-common php7.0-cli

  ## The zip package is needed for composer
  php7.0-zip

  php7.0-curl php7.0-mbstring

  unzip
)

apt-get update
apt-get install -y "${packages[@]}"


# Install composer
cd /usr/local/bin
EXPECTED_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig)
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');")

if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
then
    >&2 echo 'ERROR: Invalid installer signature'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet --filename=composer
RESULT=$?
rm composer-setup.php
chmod a+x composer
cd
