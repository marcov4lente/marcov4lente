---
layout: article
title: Getting started with Symfony 2
date: 2014-10-01 09:04:40 +0000
description: Routing is a fundamental aspect of any web application, it is responsible for firing off the appropriate actions in the appropriate sequence, so that the correct response is served. Clean URLs are also an important requirement online, not only for SEO purposes but also for user friendliness to!
categories: PHP
permalink: articles/getting-started-symfony-2.html
---
_Symfony 2_ is a PHP rapid development framework developed by [Fabien Potencier](https://twitter.com/fabpot). _Symfony 2_ is an extensive, heavy duty framework and is rather robust, fitting solution for high traffic / complex applications. Many other popular applications have been inspired by or based on _Symfony 2,_ such as [Drupal 8](https://www.drupal.org/drupal-8.0) and [Laravel](http://laravel.com/). Unsurprisingly there exists several similarities between _Laravel 5_ and _Symfony 2_, for instance, annotated routing and the blade template syntax.

_Symfony 2_ includes many built in features but unlike Laravel, it does have a relatively steep learning curve. It is incredibly sturdy, easy to debug and has an abundance of documentation and resources freely available online, both from [SensioLabs](http://sensiolabs.com/) and a substantially large and friendly developer community.

### Installation

Symfony uses [_Composer_](http://marcov4lente.com/beta/composer-basic-usage-guide/ "Composer basic usage") as it's package manager, therefore it is required that _Composer_ is properly installed and fully operational before beginning to make use of the framework. [Click here](http://marcov4lente.com/beta/composer-basic-usage-guide/ "Composer basic usage") for a starter guide on installtion and basic _Composer_ usage.

The following _Composer_ command will install the _Symfony 2_ framework in the folder titled "my-symfony-project"

```
$ _Composer_ create-project symfony/framework-standard-edition my-symfony-project '2.5.*'

```

This process may take a couple of minutes since the framework includes several additional third party vendor packages that would also need to be downloaded. Once the core and vendor packages have been downloaded and installed, the terminal will initiate a brief interactive installation wizard. The installation wizard will ask a few set up questions related to the application and server environment, before concluding the installation process.

_Symfony 2_ is shipped with two public controllers within it's public HTML folder `/web`, namely

-
**app.php:** intended to be used in production.
-
**app_dev.php:** intended for development usage.

The app_dev.php controller includes a code snippet that prevents it from being accessible by any remote host besides localhost. This is to prevent accidental access to the debugging front end controller from production servers. This may be removed or updated, based on the development requirements.

The .htaccess file shipped with _Symfony 2_ is configured to resolve HTTP requests to app.php. For development purposes it's recommended to update this to have HTTP requests resolve to app_dev.php instead.

Once the application has been deployed into a production environment, it is important to revert the .htaccess configuration back to resolve requests to app.php, as well is prevent public access to app_dev.php either via PHP or .htaccess.

### Directory structure

-
**/app:** The kernel, root application configuration, logs, cache and base views.
-
**/src:** Where the developed PHP code resides as bundles.
-
**/vendor:** Third party packages are stored here.
-
**/web:** the public root of the application.

### Console

Similar to _Laravel 4_, _Symfony 2_ comes equipped with a handy command line interface utility.

```
$ php app/console

```

The console is used to access and manage the cache and routing as well as generate boilerplate bundles, entities and CRUDs.

### Bundles

In contrast to _Laravel 4_, where modular components are set up as packages and core code resides in the `/app` directory, _Symfony 2_ structured to organize the code into bundles. These bundles are meant to be mostly self contained sections of the application, much like packages. For example, the _Users_ section would be its own bundle while the _Articles_ section would be another bundle. Each bundle will have it's own set of controllers, assets, views, configuration and dependency injections.

A typical bundle file structure:

-
/src/Vendor/Bundle
-
/src/Vendor/Bundle/Controller
-
/src/Vendor/Bundle/DependencyInjection
-
/src/Vendor/Bundle/Entity
-
/src/Vendor/Bundle/EventListener
-
/src/Vendor/Bundle/Form
-
/src/Vendor/Bundle/Resources
-
/src/Vendor/Bundle/Resources/config
-
/src/Vendor/Bundle/Resources/doc
-
/src/Vendor/Bundle/Resources/public
-
/src/Vendor/Bundle/Resources/translations
-
/src/Vendor/Bundle/Resources/view
-
/src/Vendor/Bundle/Tests

### Configuration formatting

_Symfony 2_ supports 4 types of configuration formats, namely:

- [.yml](http://en.wikipedia.org/wiki/YAML)
- [.xml](http://en.wikipedia.org/wiki/XML)
- .php
- annotation

The choice of which to use is entirely based on preference, it is argued that annotation and yml formats are the most readable, however this is solely dependent on circumstance and developer experience. By default _Symfony 2_ (and it's various command line generators) seems to prefer to set yml for general application and bundle configuration and annotation for routing and entity configuration.

### Entities

An entity is a class that defines a database's table structure, fields, relationships and data types. It's used by the Doctrine [ORM](http://en.wikipedia.org/wiki/Object-relational_mapping) to build it's virtual object database.

The entity class defines a series of private variables that represent the table's columns, it also contains _getter_ and _setter_ methods which enable the retrieval and update of entity data.

A typical entity class would look similar to the example below, note this entity uses annotations to define the various table column properties.

```
namespace marcov4lente\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="marcov4lente\ArticleBundle\Entity\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     * @ORM\Column(name="author", type="integer")
     */

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}

```

The quickest way to get started with entities is to generate one via the console:

```
$ php app/console generate:doctrine:entity

```

This will run through an interactive wizard where one may define the entity's fields and field types. Once complete it will generate the entity class and place it within the `/src/<vendor>/<bundle>/Entity` directory. From there the entity's properties may be further customized, such as define many to one relationships and data type assertions.

What is rather useful is Doctrine's schema update feature that reads the entity, it's changes or updates and applies these to the database table accordingly.

```
$ php app/console doctrine:schema:update --force

```

It must be noted that this command should be used with some caution, as updating database schemata without thought could result in data loss, if one is not careful!

### CRUDs

**C**reate, **R**ead, **U**pdate and **D**elete methods usually reside in the controller layer of an application. With Symfony's generator command line utility a base CRUD may may quickly generated, from where one may start off from. The following command will run through an interactive wizard that will set up a generic CRUD controller, along with views and form types, based on an existing entity.

```
$ php app/console generate:doctrine:crud

```

It's important to note that the entity that the CRUD is based on needs to exist prior to generating the CRUD.

The following files are created during this operation:

-
/Vendor/Bundle/Controller/Controller
-
/Vendor/Bundle/Form/Type
-
/Vendor/Bundle/Views//edit.html.twig
-
/Vendor/Bundle/Views//index.html.twig
-
/Vendor/Bundle/Views//new.html.twig
-
/Vendor/Bundle/Views//show.html.twig

### The web debug tool bar

The web debug bar appears at the bottom of each page, when accessing the application via app_dev.php. The debug bar displays various technical data regarding the application and the previous HTTP request, such as the [stack trace](http://en.wikipedia.org/wiki/Stack_trace) and database query count.

### Conclusion

With the help of Composer, starting a new _Symfony 2_ projecy is decently painless. Additionaly, swiftly generating bundles and CRUDs takes almost no time thank's to its built in command line utility. From there onwards a developer may dive into the application's development by adding custom functionality to the controllers and entities as well as template styles to the views. As previously stated, _Symfony 2_ has a steep learning curve, however this is generously compensated for by its powerful, robust features.

### References

-
[http://symfony.com/doc](http://symfony.com/doc)
-
[http://doctrine-common.readthedocs.org/en/latest/reference/annotations.html](http://doctrine-common.readthedocs.org/en/latest/reference/annotations.html)
-
[http://www.symfony2cheatsheet.com](http://www.symfony2cheatsheet.com/)

