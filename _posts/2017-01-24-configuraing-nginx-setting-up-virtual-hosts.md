---
layout: article
title:  "Configuraing and setting up website on NginX"
date:   2017-01-24 10:04:54 +0000
Configuraing and setting up website on NginX.
categories: Linux
permalink: articles/configuraing-and-setting-up-website-on-nginX.html
---
## Website configuration
Move to site available directory.
```
$ cd /etc/nginx/sites-available
```

Create a new site configuration file.
```
$ sudo nano marcov4lente.com
```

Add the server configuration, and save.
```
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/marcov4lente.com;
    index index.php index.html index.htm index.nginx-debian.html;
    server_name marcov4lente.com;

    # enable rewrite
    location / {
            try_files $uri $uri/ /index.php?q=$request_uri;
    }

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }

    # deny access to .htaccess files
    location ~ /\.ht {
            deny all;
    }

```

## Enable the website
By symlinking it's configuration file to the sites-enabled folder:
```
ls -s /etc/nginx/sites-available/marcov4lente.com /etc/nginx/sites-enabled/marcov4lente.com
```

## test nginx changes
Confirm that the server's configuration files contain no errors.
```
$ sudo nginx -t
```

## Restart nginx-php
```
$ sudo systemctl restart php7.0-fpm
```

## Restart nginx-php
```
$ sudo systemctl restart php7.0-fpm
```

## Done
If the configured domain name's DNS is correctly configured, then NginX server should correctly handle incoming requests.
