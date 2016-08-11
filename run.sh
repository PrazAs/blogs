#!/bin/bash
chown www-data:www-data /var/www/html -R

sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
a2enmod rewrite

source /etc/apache2/envvars
tail -F /var/log/apache2/* &
exec apache2 -D FOREGROUND