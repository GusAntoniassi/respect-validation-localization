#!/bin/sh

echo "Downloading respect/validation exceptions strings"
rm -rf ./Exceptions
svn export https://github.com/Respect/Validation/trunk/library/Exceptions
echo "Extracting strings"
php extract-strings.php
echo "<?php " > gettext.php
cat api.txt | sed -e "s/\(.*\)/_('\1');/" >> gettext.php
mkdir -p pot/
php vendor/bin/gettext-extractor.php -f gettext.php > pot/$1.pot
echo "Strings extracted into pot/$1.pot"