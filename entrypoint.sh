#!/bin/bash

echo "env[RECAPTCHA] = $RECAPTCHA" >> /etc/php/7.0/fpm/pool.d/www.conf
echo "env[RECAPTCHA_SECRET] = $RECAPTCHA_SECRET" >> /etc/php/7.0/fpm/pool.d/www.conf

if [[ -v DOMAIN ]]; then
    /root/acme.sh --issue --standalone -d $DOMAIN --key-file /etc/ssl/private/nginx.key  --fullchain-file /etc/ssl/certs/nginx.crt
else
    echo "WARNING: NO DOMAIN SET"
fi

/usr/sbin/php-fpm7.0
/usr/sbin/nginx
/go/bin/factom-walletd -s $FACTOMD