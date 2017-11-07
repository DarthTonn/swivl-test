#!/bin/bash

# Update DB
php bin/console doctrine:schema:update --force
echo -e "Database was updated successfully."


# Clear cache
rm -R var/cache/*
echo -e "Clearing the cache was successfully done."

# Update CSS, JS, Image styles
php bin/console assets:install web --symlink
echo -e "Symlinks were updated successfully."

# Installing CSS, JS and Image styles
#php bin/console assetic:dump
echo -e "Symlinks were installed successfully." 

# Set needed permissions for var folders
chmod 777 -R var/cache/ var/logs/
echo -e "All post deploy procedures are finished successfully!"

