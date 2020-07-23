#!/bin/ash
sed -i 's/{DF_USER}/'${DF_USER}'/g' /etc/nginx/nginx.conf
sed -i 's/{DF_PASS}/'${DF_PASS}'/g' /etc/nginx/nginx.conf
sed -i 's/{DF_HOST}/'${DF_HOST}'/g' /etc/nginx/nginx.conf
sed -i 's/{DF_DB}/'${DF_DB}'/g' /etc/nginx/nginx.conf
sed -i 's/{DF_PREFIX}/'${DF_PREFIX}'/g' /etc/nginx/nginx.conf
sed -i 's/{DF_ENV}/'${DF_ENV}'/g' /etc/nginx/nginx.conf
/usr/sbin/nginx -g "daemon off;"
