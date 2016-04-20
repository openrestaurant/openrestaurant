#!/bin/bash
# Script to reset the database and recreate settings.php.
# Run this script inside /profiles/openrestaurant/scripts.
echo ""
echo "-----------------------------------------"
echo "Dropping database..."
echo "-----------------------------------------"
drush sql-drop -y

echo ""
echo "-----------------------------------------"
echo "Setting permissions for sites/default..."
echo "-----------------------------------------"
cd ~/Sites/devdesktop/openrestaurant
chmod 755 sites/default

echo ""
echo "-----------------------------------------"
echo "Removing settings.php in sites/default..."
echo "-----------------------------------------"
cd sites/default
rm -rf settings.php

echo ""
echo "-----------------------------------------"
echo "Removing files in sites/default..."
echo "-----------------------------------------"
rm -rf files
