# FactomFaucet

**Prerequisites**

 - A domain name (this will automatically be registered with letsencrypt).
 - reCAPTCHA keys from https://www.google.com/recaptcha/admin#list
 - A running factomd node, accessible from this container. 
 - A Docker server
    
   
**Build Docker Container**

    docker build -t factom_faucet_img https://github.com/logicethos/FactomFaucet.git

**Start Container**

    docker run -d \
       -e "FACTOMD=localhost:8088" \
       -e "RECAPTCHA=6LdR50MUAAAAADdV1OJZUazmjcwefqfw_vK-5UZe" \
       -e "RECAPTCHA_SECRET=6LdR50MUAAAAAD8ybRsVlqwewef710" \
       -e "DOMAIN=faucet.mydomain.com" \
       -p 80:80 -p 443:443 --name factom_faucet factom_faucet_img


**To use factom-cli**

    docker exec -it factom_faucet factom-cli ......

**To access bash shell**

    docker exec -it factom_faucet /bin/bash
    
**Configure faucet**

edit the file /var/www/wallet.php in the container.

**To use the Faucet**

Visit https://.your-domain.com
