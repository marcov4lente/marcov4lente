---
layout: article
title: Symfony 2 event listeners and subscribers
date: 2015-01-02 09:04:40 +0000
description: The concept of event listeners and subscribers is similar to that of entity lifecycle callbacks, where they are objects that perform specific actions upon the occurrence of certain events. They are, however, used in a broader context to that of the entity lifecycle callbacks, which pertain solely to the Doctrine ORM. With event listeners and event subscribers one may tap into more than just Doctrine events, such as routing or kernel operations.
categories: PHP
permalink: articles/symfony-2-event-listeners-and-subscribers.html
---
The concept of _event listeners_ and subscribers is similar to that of entity [_lifecycle callbacks_](/web/20150225124905/http://MarcoValente.com/beta/doctrine-orm-life-cycle-call-backs/ "Doctrine ORM lifecycle callbacks"), where they are objects that perform specific actions upon the occurrence of certain events. They are, however, used in a broader context to that of the entity _lifecycle callbacks_, which pertain solely to the Doctrine ORM. With _event listeners_ and _event subscribers_ one may tap into more than just Doctrine events, such as routing or kernel operations.

### Listeners and subscribers?

The difference between an _event listener_ and an _event subscriber_ is that an _event subscriber_ is a collection of _event listeners_. At first glance this may seem silly, however consider the following two scenarios:

- Scenario 1: One may have a task that has to be actioned upon the occurrence of various events. Here an event listener would be most optimal as this would allow the code of this action to be re-used across the application's various events and therefore avoid the violation of the fundamental [DRY rule](/web/20150225124905/http://en.wikipedia.org/wiki/Don%27t_repeat_yourself).
- Scenario 2: One requires a series of specific tasks to be carried out on the occurrence of a specific event. Here, an event subscriber would likely be more suitable.

### How it all fits together

In brief the entire process of building event listeners and subscribers is as follows

- Create the event listener or subscriber class, usually in the `/src/<vendor>/<bundle>/EventListener</bundle></vendor>` directory.
- Register the event listener as a service, along with the relevant tags, within the `/app/config/config.yml` file, in the application's configuration directory.

### Creating an event listener

Event listeners, by default are placed in the Event listeners, by default are placed in the `/src/<vendor>/<bundle>/EventListener</bundle></vendor>` directory. This however this is not set in stone, and they may reside anywhere else that is more suitable to the application's design pattern.

As illustrated below, a typical _event listener_ object, which listens for a _PrePersist_ event, then checks to see if the entity being persisted is an instance of the `MarcoValente\ArticleBundle\Entity\Article` entity. If so, it sets the _created_ and _modified_ fields.

```
namespace MarcoValente\ArticleBundle\EventListener;

class NewArticle
{
    public function prePersist(\Doctrine\ORM\Event\LifeCycleEventArgs $args)
    {
        $entity = $args->getEntity();
        var_dump($entity);
        if($entity instanceof \MarcoValente\ArticleBundle\Entity\Article) {
            $entity->setModified(new \DateTime());
            $entity->setCreated(new \DateTime());
        }
    }
}

```

To activate this event listener, it needs to be registered with the application as a service in the application's configuration `/app/config/config.yml` file.

```
# services
services:
    Article.listener.new_article :
        class: MarcoValente\ArticleBundle\EventListener\NewArticle
        tags:
            - {name : doctrine.event_listener, event : prePersist}

```

Where:

- **class**: the namespaced class of our event listener.
- **name**: The name of the dependency injection that we wish to use for this service.
- **event**: The event that the service is to listen for.

### Creating an event subscriber

Similarly, an _event subscriber_ generally resides in the `/src/<vendor>/<bundle>/EventListener</bundle></vendor>` directory. The _event subscriber_ object however contains several methods, the first of which much be the `getSubscribedEvents()` method, that contains an array containing the subscriber's methods.
