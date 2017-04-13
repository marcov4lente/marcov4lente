---
layout: article
title: Doctrine ORM lifecycle callbacks
date: 2014-12-15 09:04:40 +0000
description: Lifecycle callbacks are Doctrine ORM event driven tasks that can be attached to certain, entity specific, events and executed when those events take place. Lifecycle callbacks are especially useful for generating or modifying entity field data such as created or modified times.
categories: PHP
permalink: articles/doctrine-orm-lifecycle-callbacks.html
---
_Lifecycle callbacks_ are _Doctrine_ ORM event driven tasks that can be attached to certain, entity specific, events and executed when those events take place. _Lifecycle callbacks_ are especially useful for generating or modifying entity field data such as _created_ or _modified_ times.

### Available life cycle callbacks

There are various lifecycle callbacks made available by the _Doctrine_ ORM for execution, they are:

- PrePersist (This is only run once, during record creation.)
- PostPersist
- PreUpdate
- PostUpadte
- PreRemove
- PostRemove
- PostLoad

### Enabling lifecycle callbacks

To make use of _lifecycle callbacks_, the application needs to be made aware that the entity implements lifecycle callbacks. This is done via the entity's annotation configuration.

```
/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="marcov4lente\DemoBundle\Entity\ArticleRepository")
 * @ORM\Haslife cycleCallbacks()
 */
class Article
{

```

_Doctrine_ ORM is now aware that this entity implements lifecycle callbacks and will trigger them when appropriate.

### The callbacks

Each _lifecycle callback_ is defined by creating a method for it, which is then annotated with its callback type, for example: `* @ORM\PrePersist`. The below callback example will be executed during a PrePersist event which occurs, only once, when an entity is created. When triggered, it will set the _created_ and _modified_ time fields to the current time as a `\DateTime()` object.

```
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAndModified()
    {
        $this->created = new \DateTime();
        $this->modified = new \DateTime();
    }

```

The following _lifecycle callback_ example will update the modified time field as a new `\DateTime()` object, it will be executed every time the entity is updated. This _lifecycle callback_ type is defined as `* @ORM\PreUpdate`.

```
    /**
     * @ORM\PreUpdate
     */
    public function updateModified()
    {
        $this->modified = new \DateTime();
    }

```

Note: _Lifecycle_ methods cannot receive any arguments.

### Conclusion

_Lifecycle callbacks_ are simple, internal data modifiers. They are a great solution for automating the transformation of entity data at various stages of entity manipulation. If more complex processing is required, it is then suggested to consider implementing event listeners or event subscribers instead.

### References

- [http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#life cycle-events](/web/20150225124850/http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#life%20cycle-events)
- [http://culttt.com/2014/08/04/understanding-doctrine-2-life cycle-events/](/web/20150225124850/http://culttt.com/2014/08/04/understanding-doctrine-2-life%20cycle-events)
- [http://symfony.com/doc/current/book/doctrine.html](/web/20150225124850/http://symfony.com/doc/current/book/doctrine.html)
- [http://mossco.co.uk/symfony-2/using-life cyclecallbacks-for-createdat-and-updatedat-in-symfony-2/](/web/20150225124850/http://mossco.co.uk/symfony-2/using-life%20cyclecallbacks-for-createdat-and-updatedat-in-symfony-2)
