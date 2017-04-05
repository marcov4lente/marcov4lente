---
layout: article
title:  "Installing Jekyll on ubuntu 16.04"
date:   2017-04-05 10:04:54 +0000
description: This guide will outline the installation of the above requirements on an Ubuntu 16.04 Linux operating system.
categories: Linux
permalink: articles/installing-jekyll-on-ubuntu-server-16-04-xenial.html
---
## The environment
### System requirements
The basic requirements for Jekyll are:
- GNU/Linux or Apple macOS
- Ruby 2.0
- RubyGems
- GCC
- Make

This guide will outline the installation of the above requirements on an Ubuntu 16.04 Linux operating system.


### Install Ruby
```
$ sudo apt-get install ruby
```


### Install Ruby Dev package
```
$ sudo apt-get install ruby-dev
```


### Install RubyGems
```
$ sudo apt-get install rubygems
```


### Install GCC
GCC should already be installed on the system.
```
$ gcc -v
```


### Install Make
Make should already be installed on the system.
```
$ make -v
```


### Add the gems folder to the system path
```
$ PATH=$PATH:above/path/to/gems >> ~/.bash_profile
```

The Gem directory usually being:
```
/var/lib/gems/2.3.0/gems
```


## Jekyll
### Install Bundler
A jekyll dependency
```
$ sudo gem install bundler
```


### Install Jekyll
```
$ sudo gem install jekyll
```


### Check if the installation was succesfull
```
$ jekyll --version
```


### Install the paginate module
An optional module to generate paginated content lists.
```
$ sudo gem install jekyll
```


### Create a new Jekyll site
```
$ jekyll new sitename
```
