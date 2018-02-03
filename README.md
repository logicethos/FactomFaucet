# FactomFaucet

**Prerequisites**

 - A domain name (this will automatically be registered with letsencrypt).
 - A reCAPTCHA key from https://www.google.com/recaptcha/admin#list
 - A running factomd node, accessible from container. 
 - Docker server
    
   
**Build Docker Container**

    docker build https://github.com/logicethos/FactomFaucet factom_faucet

**Start Container**

    docker run -d \
       -e "FACTOMD=localhost:8088" \
       -e "RECAPTCHA=6LdR50MUAAAAADdV1OJZUazmjcwefqfw_vK-5UZe" \
       -e RECAPTCHA_SECRET="6LdR50MUAAAAAD8ybRsVlqwewef710" \
       -e DOMAIN="faucet.mydomain.com" \
       -p 80:80 -p 443:443 factom_faucet


**Set up wallet, using factom-cli**

    docker exec -it factom_faucet /bin/bash
    /go/bin/factom-cli .......
    
**Configure faucet**

edit  the file /var/www/faucet.php

**Test**

Visit https://mydomain.com
