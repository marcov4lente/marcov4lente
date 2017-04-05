---
layout: article
title:  "Linux File and Folder Permissions"
date:   2016-11-22 10:04:54 +0000
description: Quick Linux file and folder permissions management cheat sheet.
categories: Linux
permalink: articles/linux-file-and-folder-permissions.html
---
## Change folder owner
```
$ chown you:yourgroup /home -R
```

## Recursively add read/write permissions to an owner's or group's folder
```
$ chmod -R ug+rw foldername
```

## Web root folder permissions
Set group of folder to www-data.
```
$ sudo chgrp www-data /var/www
```

Make it writable.
```
sudo chmod 775 /var/www
```

Set group id for subfolders.
```
sudo chmod g+s /var/www
```

Add username to the group
```
sudo useradd -G www-data [USERNAME]
```
