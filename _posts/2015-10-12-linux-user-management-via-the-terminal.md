---
layout: article
title:  "Linux user management via the terminal"
date:   2015-10-12 10:04:54 +0000
description: Linux user management via the terminal.
categories: Linux
permalink: articles/linux-user-management-via-the-terminal.html
---
## Create new user
```
$ adduser username
```

## Add user to sudo group
```
$ usermod -aG sudo username
```

## Change password
```
$ passwd
```

