FROM ety001/php:5.6

RUN apk --no-cache add nginx supervisor && \
    mkdir -p /run/nginx && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 256M/g' /etc/php5/php.ini

COPY ./config/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./config/supervisor/supervisord.conf /etc/supervisord.conf

USER nobody
COPY ./df_core /var/www/
COPY ./df_web /var/www/

VOLUME /var/www/df_web/www/upload

ENV DF_USER root \
    DF_PASS 123456 \
    DF_HOST localhost \
    DF_DB   tiktok \
    DF_PREFIX tiktok_ \
    DF_ENV development

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
