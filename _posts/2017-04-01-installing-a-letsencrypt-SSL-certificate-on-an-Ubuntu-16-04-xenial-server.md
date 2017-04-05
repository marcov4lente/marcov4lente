---
layout: article
title:  "Installing a Letsencrypt.org SSL certificate on an Ubuntu 16.04 server"
date:   2017-04-01 10:04:54 +0000
description: Installing a Letsencrypt.org SSL certificate on an Ubuntu 16.04 server on an Ubuntu 16.04 Linux operating system.
categories: Linux
permalink: articles/installing-a-letsencrypt-ssl-certificate-on-an-Ubuntu-16-04-xenial-server.html
---
## Install Certbot
Add the Certbot repositories and install it.
```
$ sudo add-apt-repository ppa:certbot/certbot
$ sudo apt-get update
$ sudo apt-get install certbot
```


## Install the SSL certificate
Using the Webroot option, specifiy the server root and domain name of the website.
```
$ sudo certbot certonly --webroot -w /var/www/marcov4lente.com/ -d marcov4lente.com
```

Remember to respond to the interactive command prompts to complete the installation.

If this process fails with a "...Failed authorization procedure ... urn:acme:error:unauthorized :: The client lacks sufficient authorization..." kind of error, enable access to the .well-known directory that Certbot will create fron the NginX config.

```
    location ~ \.well-known {
        try_files $uri $uri/ =404;
    }
```

Once done, the a success message should pop up.
```
...
 - Congratulations! Your certificate and chain have been saved at
   /etc/letsencrypt/live/example.com/fullchain.pem. Your
...
```


## Configure Nginx
### Inside the main server block, update:
```
    # listen 80;
    # listen [::]:80;

    listen 443 ssl;
    listen [::]:443;

    ssl_certificate /etc/letsencrypt/live/marcov4lente.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/marcov4lente.com/privkey.pem;
```


### Outside the main server block
Add an additional server block to redirect HTTP traffic to HTTPS.
```
    server {
        listen 80;
        server_name example.com www.example.com;
        return 301 https://$host$request_uri;
    }
```

Test for NginX configuration file syntax errors.
```
$ sudo nginx -t
```

Restart NginX.
```
$ sudo service nginx restart
```

## Automatic certificate renewal
Automating the certificate renwal can be done via the system's crontab.
```
$ sudo crontab -e
```

Add the following to the crontab.
```
30 2 * * 1 /usr/local/sbin/certbot-auto renew >> /var/log/le-renew.log
35 2 * * 1 /etc/init.d/nginx reload
```



