FROM factominc/factom-walletd

RUN apt-get update \
    && apt-get -y install nginx php-fpm less socat joe

# Make php socket
RUN mkdir /run/php
RUN touch /run/php/php7.0-fpm.sock

# Copy in factom-cli
WORKDIR $GOPATH/src/github.com/FactomProject
RUN git clone https://github.com/FactomProject/factom-cli.git
WORKDIR $GOPATH/src/github.com/FactomProject/factom-cli

# Install dependencies & build factom-cli
RUN glide install -v
RUN go install

# Copy in entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Make self-cert (fallback if no domain supplied)
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx.key -out /etc/ssl/certs/nginx.crt -subj "/C=UK/ST=England/L=England/O=OrgName/OU=IT Department/CN=example.com"

COPY index.php /var/www/
COPY factpost.php /var/www/
COPY wallet.php /var/www/

COPY nginx-default /etc/nginx/sites-available/default

# Install letsencrypt SSL service
WORKDIR /root
RUN wget https://raw.githubusercontent.com/Neilpang/acme.sh/master/acme.sh
RUN chmod +x acme.sh

ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80 443