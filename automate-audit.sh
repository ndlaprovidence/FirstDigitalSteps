#!/bin/bash
cd /var/www/FirstDigitalSteps
echo "Vérification des dépendances du projet..."
/usr/bin/composer audit || exit 1
echo "Aucune faille connue détectée."