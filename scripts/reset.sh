#!/bin/bash
# Script to reset the database and recreate settings.php.
# Run this script inside /profiles/openrestaurant/scripts.
echo ""
echo "----------------------------------------------"
echo "Dropping database..."
echo "----------------------------------------------"
drush sql-drop -y

echo ""
echo "----------------------------------------------"
echo "Setting permissions for sites/default..."
echo "----------------------------------------------"
cd ../../..
chmod 755 sites/default

echo ""
echo "----------------------------------------------"
echo "Removing settings.php in sites/default..."
echo "----------------------------------------------"
cd sites/default
rm -rf settings.php
cp default.settings.php settings.php

echo ""
echo "----------------------------------------------"
echo "Removing files in sites/default..."
echo "----------------------------------------------"
rm -rf files
mkdir files

echo ""
echo "----------------------------------------------"
echo "Setting permissions for files and settings.php"
echo "----------------------------------------------"
chmod -R 777 files settings.php
