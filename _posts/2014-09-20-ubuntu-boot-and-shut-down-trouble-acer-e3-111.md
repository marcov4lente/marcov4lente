---
layout: article
title: Ubuntu boot up and shut down trouble on the Acer E3 111
date: 2014-09-20 10:54:40 +0000
description: I recently purchased the Acer E3 111 notebook. It's a charming, small and compact device with enough power for its designated use, as well as a pocket-sized price tag to! As soon as it arrived home, I spared no time in installing a fresh copy of Ubuntu Gnome on it. However, to my dismay, I noticed that after the installation process had completed it struggled to boot up and almost always never shut down completely.
categories: Linux
permalink: articles/ubuntu-boot-and-shut-down-trouble-acer-e3-111.html
---
I recently purchased the Acer E3 111 notebook. It's a charming, small and compact device with enough power for its designated use, as well as a pocket-sized price tag to! As soon as it arrived home, I spared no time in installing a fresh copy of Ubuntu Gnome on it. However, to my dismay, I noticed that after the installation process had completed it struggled to boot up and almost always never shut down completely.

My initial instinct was that the selected graphics driver was incorrect and thus the cause of this issue. I updated all my drivers and upgraded the Linux kernel to the latest (and at the time beta) version 3.17.0. Unfortunately these actions did not solve my boot trouble. After further investigation, it turned out that the problem was due to two modprobe kernel loaded modules. The offending modules were

- dw_dmac
- dw_dmac_core

The solution was therefore to blacklist these modules, which I did, and after doing so my machine worked like a charm!

## Blacklist the offending modules

Open the */etc/modprobe.d/blacklist.conf* file as super user.

```
$ sudo gedit /etc/modprobe.d/blacklist.conf
```

Add the following lines to the end of the file.

```
// modprobe fix for the Acer E3 111
blacklist dw_dmac
blacklist dw_dmac_core

```

Save and close the file, and restart the operating system to have these changes take effect.

## References

- [http://askubuntu.com/questions/524894/boot-and-shutdown-issues-on-aspire-e-11-model-e3-111-c0wa](/web/20150225143918/http://askubuntu.com/questions/524894/boot-and-shutdown-issues-on-aspire-e-11-model-e3-111-c0wa)
- [https://bugs.launchpad.net/ubuntu/+source/linux/+bug/1341925](/web/20150225143918/https://bugs.launchpad.net/ubuntu/+source/linux/+bug/1341925)
