#!/bin/bash
# Script to reset the database and recreate settings.php.
# Run this script inside /profiles/restaurant/scripts.
echo ""
echo "----------------------------------"
echo "Dropping database..."
echo "----------------------------------"
drush sql-drop -y

echo ""
echo "----------------------------------"
echo "Removing settings.php in sites/default..."
echo "----------------------------------"
cd /home/vagrant/sites/openrestaurantv2
chmod 755 sites/default
cd sites/default
rm -rf settings.php files
cp default.settings.php settings.php
mkdir files
chmod -R 777 settings.php files