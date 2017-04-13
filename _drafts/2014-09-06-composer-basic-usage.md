---
layout: article
title: Composer basic usage
date: 2014-09-06 09:04:40 +0000
description: Composer is the default package management application for many modern PHP frameworks, such as Symfony 2 and Laravel. Composer makes third party package management a real pleasure by automatically resolving package dependencies and maintaining package versions..
categories: PHP
permalink: articles/composer-basic-usage.html
---
Composer is the default package management application for many modern PHP frameworks, such as Symfony 2 and Laravel. Composer makes third party package management a real pleasure by automatically resolving package dependencies and maintaining package versions.

Having Packagist as it's default repository, developers have first line access to thousands of quality third party packages. While Packagist may be the default repository, one is by no means confined to it, as composer is flexible enough to make use of any other, private or public, repository.

### Global Installation on Linux

Global installation is generally preferable, as it allows one to access Composer from anywhere in the file system. Additionally, if composer is installed globally, there is no need to repeat the installation procedure for each new project. Composer does have a few package dependencies, namely _PHP_ and _GIT_, therefore prior to installing Composer these packages would need to be installed.

**PHP 5**

```
$ sudo apt-get install php5
```

**Curl for PHP 5.**

```
$ sudo apt-get install php5-curl
```

**GIT version control system.**

```
$ sudo apt-get install git
```

Composer may now be installed as it's dependencies have been satisfied. The following commands will download the composer.phar package and then move it to the system's binary directory. From there it will then be globally accessible from anywhere in the file system by simply running the *$ composer* command from the terminal.

```
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer

```

Confirming that the installation was indeed successful.

```
$ composer about
```

The above command should print out a short description about Composer, similar to _"Composer is a dependency manager tracking local dependencies of your projects and libraries._ _See http://getcomposer.org/ for more information."._ if so, then Composer was successfully installed on the system.

### Starting a new project with Composer

Starting new projects with Composer is a absolute pleasure . To do so, navigate to the project's root directory using the *cd* command.

```
$ cd /path/to/project/directory
```

After which Composer is run with the `create-project` flag as well specifying the package's name, package's vendor, package's version and the destination folder in which to install the package into.

```
$ composer create-project /
```

For example, the following Composer command will install _Symfony 2_ in the `/symfony-2` folder of the current working directory.

```
$ composer create-project symfony/framework-standard-edition symfony-2 '2.5.*'
```

While this Composer command example will install _Laravel 4_ in the `/laravel-4` folder of the current working directory.

```
$ composer create-project laravel/laravel laravel-4 '4.2.*'
```

### Updating application packages

Third party packages are constantly being updated by their developers. For security purposes its always a good idea to keep all third party packages up to date within one's project. The following command will initiate the composer update process, whereby it checks and updates each package if necessary. It must be noted that this command is to be run in the project's root folder.

```
$ composer update
```

In addition to updating already installed packages, this command will install any new packages that have been recently defined in the project's composer.json file, within the `require` array .

### Self update, updating Composer itself

Every so often Composer will issue a warning, stating that it is outdated. In an effort to keep all systems running smoothly and securely, updating it is highly recommended. Updating the Composer application can be done by running the following command.

```
$ composer self-update
```

### The composer.json file

The composer.json file, specific to each project, contains the version information of that project package as well as an inventory of it's required dependency packages. It may also define tasks to be run before _pre_ and after _post_ each package update, such as running class auto-loaders or clearing application caches. As indicated by the file extension, the Composer.json file is written in Javascript Object Notation syntax.

#### The anatomy of the composer.json file

Consider the sample _Laravel 4_ composer.json file below.

```
{
  "name": "laravel/laravel",
  "description": "The Laravel Framework.",
  "keywords": ["framework", "laravel"],
  "license": "MIT",
  "require": {
    "laravel/framework": "4.2.*"
  },
  "autoload": {
    "classmap": [
      "app/commands",
      "app/controllers",
      "app/models",
      "app/database/migrations",
      "app/database/seeds",
      "app/tests/TestCase.php"
    ]
  },
  "scripts": {
    "post-install-cmd": [
      "php artisan clear-compiled",
      "php artisan optimize"
    ],
    "post-update-cmd": [
      "php artisan clear-compiled",
      "php artisan optimize"
    ],
    "post-create-project-cmd": [
      "php artisan key:generate"
    ]
  },
  "config": {
    "preferred-install": "dist"
  },
  "minimum-stability": "stable"
}

```

The first few properties are the project's details, where the project's name, description and license is defined.

```
"name": "laravel/laravel",
"description": "The Laravel Framework.",
"keywords": ["framework", "laravel"],
"license": "MIT",

```

In the `require` array, is where all the required additional packages are defined that the application depends on. Notice that a version wildcard is also set, which allows dependency versions to be constrained to a specific range, if needed.

```
"require": {
  "laravel/framework": "4.2.*"
},

```

Adding packages to the `require` array.

```
"require": {
  "laravel/framework": "4.2.*",
  "barryvdh/laravel-dompdf": "4.2.*"
},

```

After which, the command `$ composer update` would need to be run in the terminal, in order to apply any changes that may have been done to the composer.json file.

As mentioned above, Packagist is the default Composer's repository. Additional repositories can be easily set up in the `repositories` array if needed. The following example defines the the _GIT_ repository location for the package named `awesome/package`.

```
 "repositories": [
  {
  "url": "git@bitbucket.org:awesome/package.git",
  "type": "git"
  }
],

```

In the case of private repositories, such as BitBucket, private / public ssh authentication keys would need to be set up on the system for this to work. This, however, is beyond the scope of this article, there exists a [fantastic tutorial](/web/20150225143904/https://confluence.atlassian.com/display/BITBUCKET/Set+up+SSH+for+Git) on BitBucket though, which beautifully outlines the process of achieving this objective.

The autoload array specifies how and which classes are autoloaded.

```
"autoload": {
  "classmap": [
    "app/commands",
    "app/controllers",
    "app/models",
    "app/database/migrations",
    "app/database/seeds",
    "app/tests/TestCase.php"
  ]
},

```

_Pre_ and _post_ update tasks can be set by added them to the `scripts` array.

```
"scripts": {
  "post-install-cmd": [
    "php artisan clear-compiled",
    "php artisan optimize"
  ],
  "post-update-cmd": [
    "php artisan clear-compiled",
    "php artisan optimize"
  ],
  "post-create-project-cmd": [
    "php artisan key:generate"
  ]
},

```

As illustrated in the above example, the following two commands `php artisan clear-compiled` and `php artisan optimize` will be executed after each `$ composer update`.

The following additional properties may also be declared, but are not required.

- **version**: The version of the application / package.
- **type**: library, project, metapackage or composer-plugin.
- **homepage**: The project's Internet homepage.
- **time**: the release date and time, in MySQL date stamp format.
- **authors**: a sub array containing the author's name, email, homepage and role.
- **support**: support contact email address.

Lastly is the application's minimum stability level requirements. This part is generally quite important when developing packages.

```
"minimum-stability": "dev"
```

```
"minimum-stability": "stable"
```

Setting an incorecct stability level, when working with development packages, could have composer return all sorts of Package-not-found errors.

### More on class autoloading

There are four ways to define class autoloading in the composer.json file. these are:

- Classmap
- Files
- PSR-0 (deprecated)
- PSR-4

**Classmap**

The classmap method scans the specified directories for classes and then maps their namespaces to their locations and saves the map to `/vendor/composer/autoload_classmap.php`.

```
"autoload": {
  "classmap": [
    "app/commands",
    "app/controllers",
    "app/models",
    "app/database/migrations",
    "app/database/seeds",
    "app/tests/TestCase.php"
  ]
},

```

**Files**

The files method, is where each file is explicitly defined to be autoloaded, no scanning or mapping takes place here.
