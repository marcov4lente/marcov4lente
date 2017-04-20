---
layout: article
title:  "Installing Jekyll on ubuntu 16.04"
date:   2016-08-05 11:45:54 +0000
description: Jekyll is a popular blogging platform, predominantly with developers. Jekyll, unlike PHP blogging platforms, is precompiled and built, as opposed to being compiled at runtime. This means that a Jekyll site is generally faster! The pages it serves require no computer processing to build, as they are already plain HTML.
categories: Linux
permalink: articles/installing-jekyll-on-ubuntu-server-16-04-xenial.html
---
Jekyll is a popular blogging platform, predominantly with developers. Jekyll, unlike PHP blogging platforms, is precompiled and built, as opposed to being compiled at runtime. This means that a Jekyll site is generally faster! The pages it serves require no computer processing to build, as they are already plain HTML.

## The environment
The basic requirements for Jekyll are:
- GNU/Linux or Apple macOS
- Ruby 2.0
- RubyGems
- GCC
- Make

This guide will outline the installation of the above requirements on an Ubuntu 16.04 Linux operating system.


## Installation
Install Ruby
```
$ sudo apt-get install ruby
```


Install Ruby Dev package
```
$ sudo apt-get install ruby-dev
```


Install RubyGems
```
$ sudo apt-get install rubygems
```


Install GCC - GCC should already be installed on the system.
```
$ gcc -v
```


 Install Make - Make should already be installed on the system.
```
$ make -v
```


Add the gems folder to the system path
```
$ PATH=$PATH:above/path/to/gems >> ~/.bash_profile
```

The Gem directory usually being:
```
/var/lib/gems/2.3.0/gems
```


## Jekyll
Install Bundler, a jekyll dependency
```
$ sudo gem install bundler
```

Install  Bundler
```
$ sudo bundle install
```

Install Jekyll
```
$ sudo gem install jekyll
```

Check if the installation was successful
```
$ jekyll --version
```

Install the new paginate module , an optional module to generate paginated content lists.
```
$ gem install jekyll-paginate-v2
```

Create a new Jekyll site
```
$ jekyll new sitename
```
