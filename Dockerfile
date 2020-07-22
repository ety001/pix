FROM ety001/php:5.6

RUN apk --no-cache add nginx supervisor && \
    mkdir -p /run/nginx && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 256M/g' /etc/php5/php.ini

COPY ./config/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./config/php/php-fpm.conf /etc/php5/php-fpm.conf
COPY ./config/supervisor/supervisord.conf /etc/supervisord.conf
COPY ./config/custom-php-fpm5.sh /usr/bin/custom-php-fpm5.sh

COPY --chown=nobody ./df_core /var/www/df_core
COPY --chown=nobody ./df_web /var/www/df_web

VOLUME /var/www/df_web/www/upload
WORKDIR /var/www

ENV DF_USER=root \
    DF_PASS=123456 \
    DF_HOST=localhost \
    DF_DB=tiktok \
    DF_PREFIX=tiktok_ \
    DF_ENV=development

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
