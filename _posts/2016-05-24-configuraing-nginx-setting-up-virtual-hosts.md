---
layout: article
title: "Configuraing and setting up website on NginX"
date: 2016-05-24 19:14:54 +0000
description: Configuraing and setting up a website on an NginX server.
categories: Linux
permalink: articles/configuraing-and-setting-up-website-on-nginX.html
---
## Website configuration
Move to the *sites-available* directory.
```
$ cd /etc/nginx/sites-available
```

Create a new site configuration file.
```
$ sudo nano MarcoValente.com
```

Add the following server configuration to the site config file, replacing the domain and direcotry names appropriately. Then save.
```
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/MarcoValente.com;
    index index.php index.html index.htm index.nginx-debian.html;
    server_name MarcoValente.com;

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

Enable the website, by symlinking it's configuration file to the *sites-enabled* folder:
```
ls -s /etc/nginx/sites-available/MarcoValente.com /etc/nginx/sites-enabled/MarcoValente.com
```

Confirm that the server's configuration files contain no errors.
```
$ sudo nginx -t
```

Restart nginx-php
```
$ sudo systemctl restart nginx
```


## Done
If the configured domain name's DNS is correctly configured, then NginX server should correctly handle incoming requests for the domain name configured.
