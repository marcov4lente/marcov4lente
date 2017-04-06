---
layout: article
title:  "PHP code style fixer"
date:   2015-01-12 22:34:54 +0000
description: How to install and set up a LEMP (Linux, NginX, MySQL, PHP) server.
categories: PHP
permalink: articles/php-code-style-fixer.html
---
I recently stumbed upon a marvelous tool, licensed with the MIT license by Sensio Labs, called PHP Coding Standard Fixer. It automatically analyses an application's PHP source code and corrects the coding format by applying PSR-0, PSR-1 and PSR-2 standards.

## Installation

Download the file to the global binary folder.

```
$ sudo wget http://get.sensiolabs.org/php-cs-fixer.phar -O /usr/local/bin/php-cs-fixer

```

If at this stage the terminal returns a message similar to "wget: command not found", it means that wget is not installed. The following command will install wget.

```
$ sudo apt-get install wget
```

Make it executable.

```
chmod +x /usr/local/bin/php-cs-fixer

```

## Usage

Before making any changes one may opt to have the utility perform a dry run, where it scan the files of the application and outputs the proposed changes for analysis.

```
$ php-cs-fixer fix /application/folder --dry-run --verbose --diff
```

If the proposed changes are satisfactory, we may proceed to apply the proposed fixes .

```
$ php-cs-fixer fix /application/folder
```

By defualt, this utility applies PSR-0, PSR-1 and PSR-2 coding standards simultenously. If required, this behavour can be altered to have it apply only certain PSR coding standards to the source code.

```
$ php-cs-fixer fix /application/folder --level=psr1

```

## Conclusion

Legacy applications are often a painful reminder of the perils of not paying attention to good stadards and practices. While this isnt a complete dirty-code antidote, it is a small step in the right direction of reducing the technical debt of older applications. There are quite a few advanced options that this utility supports, please refer to the [official project homepage](http://cs.sensiolabs.org) for more information.

## References

- http://cs.sensiolabs.org/
