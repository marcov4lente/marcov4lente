---
layout: article
title:  "Installing and setting up Gulp on an Ubuntu 16.04 Server"
date:   2015-03-15 13:34:54 +0000
description: This guide will outline the installation of the Node and NPM on an Ubuntu 16.04 Linux operating system.
categories: Linux
permalink: articles/installing-and-setting-up-Gulp-on-an-Ubuntu-16-04-xenial-server.html
---
An outline of what is to be done.
- Installation
- Install Node packages on a Vagrant virtual machine
- Install Node packages on a Vagrant physical machine
- Initiate a Project
- Configuring the Gulp File
- Executing Gulp
- Troubleshooting

## Installation
Installing Node and NPM on Ubuntu Linux (if not already installed), using the Node maintained Ubuntu repos.
```
$ curl -sL https://deb.nodesource.com/setup | sudo bash -
$ sudo apt-get install nodejs
$ sudo apt-get install npm
$ sudo ln -s /usr/bin/nodejs /usr/bin/node

```

Installing Gulp:
```
$ sudo npm install --global gulp
$ sudo npm install -g gulp-cli
```


## Install Node packages on a Vagrant virtual machine
Install the above defined packages to the project:
```
$ npm install gulp --no-bin-links
$ npm install gulp-util --no-bin-links
$ npm install gulp-sass --no-bin-links
$ npm install gulp-clean-css --no-bin-links
$ npm install gulp-uglify --no-bin-links
$ npm install obal gulp-concat --no-bin-links
$ npm install gulp-connect --no-bin-links
$ npm install gulp-sourcemaps --no-bin-links
```
This will create a node_modules directory in the project root.

## Install Node packages on a physical machine
Install the above defined packages to the project:
```
$ npm install gulp --g
$ npm install gulp-util --g
$ npm install gulp-sass --g
$ npm install gulp-clean-css --g
$ npm install gulp-uglify --g
$ npm install obal gulp-concat --g
$ npm install gulp-connect --g
$ npm install gulp-sourcemaps --g
```
This will create a node_modules directory in the project root.


## Initiate the Project
Create a package.json file in the root of the project.
```
{
  "name": "marcov4lente.com",
  "version": "0.1",
  "description": "marcov4lente.com",
  "main": "index.js",
  "keywords": [
    "Marco",
    "Valente",
    "Development"
  ],
  "author": "Marco Valente",
  "contributors": [
    "Marco Valente <marcov4lente@gmail.com> (http://marcov4lente.com)"
  ],
  "license": "MIT"
}
```

Add the following package requirements to the package.json.
```
"dependencies": {
    "gulp": "latest",
    "gulp-util": "latest",
    "gulp-sass": "latest",
    "clean-css": "latest",
    "gulp-uglify": "latest",
    "gulp-concat": "latest",
    "gulp-connect": "latest",
    "gulp-sourcemaps": "latest"
}
```
### gulp
npmjs.com definition:The streaming build system
https://www.npmjs.com/package/gulp

### gulp-util
npmjs.com definition: none.
https://www.npmjs.com/package/gulp-util

### gulp-sass
npmjs.com definition: Sass plugin for Gulp..
https://www.npmjs.com/package/gulp-sass

### coffee-gulp
npmjs.com definition: A tiny module which wraps Gulp to use CoffeeScript for your gulpfile.
https://www.npmjs.com/package/coffee-gulp

### gulp-uglify
npmjs.com definition: Minify files with UglifyJS.
https://www.npmjs.com/package/gulp-uglify

### gulp-concat
npmjs.com definition: Concatenates files.
https://www.npmjs.com/package/gulp-concat

### gulp-connect
npmjs.com definition: Gulp plugin to run a webserver (with LiveReload).
https://www.npmjs.com/package/gulp-connect



## Configuring the Gulp File (gulpfile.js)
The Gulp File defines the Gulp tasks to be carried out. This resides in the root of the project. A sample Gulp File (based on https://www.npmjs.com/package/gulp) as follows:
```
var gulp = require('gulp');
var sass = require('gulp-sass');
var cleancss = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');


// compile scss to css
gulp.task('styles', function() {
    gulp.src('./assets/scss/*.scss')
        .pipe(sass())
        .pipe(concat('app.css'))
        .pipe(cleancss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./public'))
});

// concatenate and minify javascript
gulp.task('scripts', function() {
    gulp.src('./assets/js/*.js')
        .pipe(sourcemaps.init())
        // .pipe(uglify())
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public'));
});


// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch('assets/js', ['scripts']);
    gulp.watch('assets/scss', ['compile-styles']);
});


// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'scripts', 'styles']);


```

The above Gulp FIle configuration is based on that in the Gulp documentation https://www.npmjs.com/package/gulp

## Executing Gulp
This will launch a persistant instance of gulp, which will watch the defined folders for changes and publish them to the defined destination files.
```
$ gulp
```

## Troubleshooting
### NPM error

```
npm ERR! File: /path/to/file
npm ERR! Failed to parse package.json data.
npm ERR! package.json must be actual JSON, not just JavaScript.
npm ERR!
npm ERR! This is not a bug in npm.
npm ERR! Tell the package author to fix their package.json file. JSON.parse
```

Solution: Correct the JSON syntax errors in package.json.

### CLI error (Windows)
```
'gulp' is not recognized as an internal or external command,
operable program or batch file.
```

Caused by missing environmental variables.
```
rem for future
setx NODE_PATH %AppData%\npm\node_modules
rem for current session
set NODE_PATH=%AppData%\npm\node_modules
```
