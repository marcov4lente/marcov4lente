---
layout: article
title:  "Linux File and Folder Permissions"
date:   2015-11-22 14:44:54 +0000
description: Quick Linux file and folder permission management cheat sheet.
categories: Linux
permalink: articles/linux-file-and-folder-permissions.html
---
Change folder owner
```
$ chown you:yourgroup /home -R
```

Recursively add read/write permissions to an owner's or group's folder
```
$ chmod -R ug+rw foldername
```

For the web root folder permissions, set the group of the folder to *www-data*.
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
