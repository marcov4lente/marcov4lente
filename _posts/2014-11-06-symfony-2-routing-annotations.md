---
layout: article
title: Symfony 2 - routing with annotations
date: 2014-11-06 09:04:40 +0000
description: Routing is a fundamental aspect of any web application, it is responsible for firing off the appropriate actions in the appropriate sequence, so that the correct response is served. Clean URLs are also an important requirement online, not only for SEO purposes but also for user friendliness to!
categories: PHP
permalink: articles/symfony-2-routing-annotations.html
---
Routing is a fundamental aspect of any web application, it is responsible for firing off the appropriate actions in the appropriate sequence, so that the correct response is served. Clean URLs are also an important requirement online, not only for SEO purposes but also for user friendliness to!

Of all the different methods of routing in _Symfony 2_, annotation seems to be the most popular for route management. This is likely because the routes are declared in the controller itself, right above their corresponding methods, which certainly increases their accesibility during development.

For faster application execution, _Symfony 2_ caches all application routes, this cache is built manually via the route cache command in the terminal console. In order for _Symfony 2_ to actually detect these routes though, each controller that makes use of annotated routes needs to be registered in it's bundle's local routes.yml configuration file `/src/Vendor/Bundle/Resources/config/routing.yml`. Furthermore, each bundle's local routing.yml file needs to be registered with in the core application's routing.yml file `/app/config//routing.yml` .

The following example illustrates a generic route annotation definition. Note that these annotations are declared in docblock format, directly above the target class and method.

```
**//  FILE: /src/MarcoValente/DemoBundle/Controller/ArticleController.php**

    /**
     * Article controller.
     *
     * @Route("/articles")
    */
    class ArticleController extends Controller
    {

        /**
         * Lists all Article entities.
         *
         * @Route("/list", name="list")
         * @Method("GET")
         * @Template()
         */
        public function indexAction()
        {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('MarcoValenteDemoBundle:Article')->findAll();
           return array(
                'entities' => $entities,
            );
        }

```

In the above code, a class wide base route, `/articles` , has been defined, which is to prefix all subsequent routes that will be defined by the class' methods. The `indexAction` method has been assigned the route `/list` , therefore its full route would be the concatenation of the class' base route `/articles` and the method's route `/list` which will be `/articles/list`. An example of additional routes, defined in this manner for this class, may include edit and update methods, such as `/aticles/edit` and `/aticles/view`.

Routes may also contain variable data, for instance: slugs, content id's or pagination indexes, which is then passed through to the method.

```
**//  FILE: /src/MarcoValente/DemoBundle/Controller/ArticleController.php**

     /**
     * Show an Article entity.
     *
     * @Route("/view/{id}", name="list")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MarcoValenteDemoBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

```

HTTP methods, such `GET`, illustrated in the example above, may also be set to limit the route to a specific HTTP method. This is mighty useful for when setting up identical URL's that map to different controllers and/or methods, for instance an edit and update method.

### Registering controllers that use annotated routes

General bundle routing is usually configured in the bundle's routing.yml configuration file `/src/Vendor/Bundle/Resources/config/routing.yml`. This configuration file is responsible for declaring all bundle classes that make use of annotated routing (and other types of routing to, if so desired by a developer). An example configuration would look like the following:

```
**//  FILE: /src/MarcoValente/DemoBundle/Resources/config/routing.yml**

    MarcoValente_demoBundle_article:
        resource: "@MarcoValenteDemoBundle/Controller/ArticleController.php"
        type:   annotation

```

The above code declares the controller class where the annotated routes have been defined. As many of these may be added as needed to the configuration, to point to as many annotated controllers as the bundle contains.

If there is a large amount of controllers to register within the routing.yml file, one may avoid onerous configuration definitions and simply import an entire directory of controllers that contain annotated routes with a single configuration item.

```
**//  FILE: /src/MarcoValente/DemoBundle/Resources/config/routing.yml**

    MarcoValente_demoBundle_article:
        resource: "@MarcoValenteDemoBundle/Controller"
        type:   annotation

```

Remember that ,since this is a YML file, correct indentation and spacing is essential to avoid any _Symfony_ errors.

### Lastly register the bundle's route configuration

Now that the bundle has been correctly set up to use annotation based routing, the core _Symfony 2_ application needs to be made aware of the presence of the bundle's routing configuration so that it may build its routing cache. This is done by registering each bundle's routing.yml within the core routing.yml `/app/config/routing.yml` configuration file.

```
**//  FILE: /app/config/routing.yml**
    MarcoValente_DemoBundle:
        resource: "@MarcoValenteDemoBundle/Resources/config/routing.yml"
        prefix:   /demo-bundle

```

### A short cut

Registering an arbitrary bundle's routes in that bundle's routing.yml and then registering that arbitrary bundle's routing.yml in the core routing.yml file, as demonstrated above, allows for an enormous amount of granular control over the application's routing. If such granular control is not required, one may simply define all route annotated controllers, of any bundle, directly from the application's core routes.yml `/app/config/routing.yml` file. Therefore bypassing the bundle's local routing.yml configuration file altogether. The example below illustrates how all annotated routes for all controllers, found within the `MarcoValenteDemoBundle/Controller` namespace is registered directly within the core routing.yml file.

```
**//  FILE: /app/config/routing.yml**

    MarcoValente_DemoBundle:
        resource: "@MarcoValenteDemoBundle/Controller"
        prefix:   /demo-bundle

```

### The route prefix

The route prefix, defined in the routing.yml file, is the prefix that will be applied to all URLs of the bundle. For example: if the prefix is defined as `demo-bundle` in the routing.yml file, and an arbitrary route of that bundle is defined as `articles/list` then the resulting route would be a concatenation of these two values `demo-bundle/articles/list`.

### Accessing routes in controllers and views

Often during the development of an application, routes need to defined, in order to build `href` hyperlinks in the views or to define redirect destination URLs within a controller. To keep the application as portable as possible, it certainly would be a good idea to not hard code routes into the application.The following methods allow for routes to be accessed or displayed in a portable manner,by means of the route's name, and not it's path.

To print out a route's absolute URL path within a Twig template.

```
[View article](%7B%7B%20url('article.view',%7B'id':'23'%7D)%20%7D%7D "View article")

```

Printing a route's relative path within a Twig template.

```
[View article](%7B%7B%20path('article.view',%7B'id':'23'%7D)%20%7D%7D%20title=)

```

Specify a route in a controller.

```
$this->generateUrl('article.view', array('id' => 23));

```

By default, the above code will generate a relative URL, adding a `false` boolean parameter will generate an absolute URL.

```
$this->generateUrl('article.view', array('id' => 23), false);

```

Should a route's path or the application's domain name ever change, the above methods will ensure that the generated URL's would remain unaffected.

### Route caching

To improve performance, _Symony 2_ caches all routes defined throughout the system. As a result of route caching, route updates and changes will not take effect once the route cache has been flushed. The cache is managed from the console, using the following commands.

Clearing the cache.

```
$ php app/console cache:clear
```

Cache warm up. This essentially prepares an empty cache.

```
$ php app/console cache:warmup
```

List all routes that have been cached.

```
$ php app/console router:debug

```

### In conclusion

_Symfony 2's_ routing capabilities can by brilliantly simple or incredibly complex. Annotation is just one of the few ways to manage application routing in _Symfony 2_, as XML and PHP routing methods are supported to!

### References

- [http://symfony.com/doc](/web/20150225143913/http://symfony.com/doc)
- [http://www.symfony2cheatsheet.com/](p://www.symfony2cheatsheet.com/)
- [http://stackoverflow.com/questions/17346821/how-do-i-make-symfony2-autoload-my-routing-yml-for-my-bundles-that-i-create-in-v](/web/20150225143913/http://stackoverflow.com/questions/17346821/how-do-i-make-symfony2-autoload-my-routing-yml-for-my-bundles-that-i-create-in-v)
