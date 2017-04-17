---
layout: article
title: Symfony 2 entities and the Doctrine ORM
date: 2014-11-23 09:04:40 +0000
description: Doctrine is a powerful and feature packed Object Relational Mapper (ORM) that is the preferred default in Symfony 2. It's great power does come with a slightly higher learning curve compared to, for example, that of the Eloquent ORM. Object-relational Mapping is the method of accessing and converting data from incompatible systems (in this case MySQL or MariaDB) into an object or virtual object database that may be accessed and manipulate from within PHP.
categories: PHP
permalink: articles/symfony-2-entities-and-doctrine-orm.html
---
Doctrine is a powerful and feature packed Object Relational Mapper (ORM) that is the preferred default in _Symfony 2_. It's great power does come with a slightly higher learning curve compared to, for example, that of the Eloquent ORM.

[Object-relational Mapping](/web/20150225124900/http://en.wikipedia.org/wiki/Object-relational_mapping) is the method of accessing and converting data from incompatible systems (in this case MySQL or MariaDB) into an object or virtual object database that may be accessed and manipulate from within PHP.

Doctrine relies on entities, which represent the database's tables, schema structure and relationships. Before _Doctrine_ may begin reading and writing to the database, these entities need to be created and set up. As mentioned in the article _[Getting started with Symfony 2](/web/20150225124900/http://MarcoValente.com/getting-started-with-symfony-2/ "Getting started with Symfony 2")_, entities may be quickly generated using the console.

```
$ php app/console doctrine:generate:entity
```

This will start an interactive wizard that will go through the process of generating an entity. Once this has been done, the entity will most certainly need to be customised, by perhaps defining inter-entity relationships and field assertions via annotations.

Note: Annotation, is one of a few configuration options available in _Symfony 2_. The following examples, in this article, will be using annotations as the preferred method of configuration.

### Field types and assertions

Entity assertion is database level validation based on the Assert rules defined for the entity and it's fields. Assertions are useful for making sure that the data that is saved to the database is if a type or format required by that field.

The use of assertions within an an entity requires the _Symfony_ constraints validator class.

```
use Symfony\Component\Validator\Constraints as Assert;
```

Consider the example below.

```
   /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

```

or

```
   /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="The title of this entity cannot be blank")
     */
    private $title;

```

Here an assertion is declared stating that the `$title` field cannot be blank. If a blank title field is attempted to be set, the ORM will refuse and raise an exception. An error message is also defined, should the case arise when a value does not meet the assertion criteria. This error message data can then be passed along to the user interface and presented to the user.

There are a variety of assertion that are available, such as verifying an email address' validity by doing an MX DNS record lookup.

```
   /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=255)
     * @Assert\Email(message="Sorry, invalid email address", checkMx=true)
     */
    private $emailAddress;

```

Or ensuring that a field's value is one of a predefined set of choices.

```
   /**
     * @var string
     *
     * @ORM\Column(name="payment_method", type="string", length=255)
     * @Assert\Email(message="Sorry, that is not a valid payment method!", choices={"Credit card","Debit card","Cash on deliver", "Voucher"})
     */
    private $paymentMethod;

```

There are numerous other validation options that all follow this signature, please refer to [Symfony's Validation Constraints Reference page](/web/20150225124900/http://symfony.com/doc/current/reference/constraints.html) for a full list.

### Relationships

Consider the three related entities, _Article,_ _ArticleCategory_ and _ArticleTags._ Where many articles link to one category and many articles link to many tags. With Doctrine ORM, these relationships may be defined so that any one of these entities, as well as their related entities, are easily accessible and manipulatable. Doctrine supports _one to many_, _many to one_ and _many to many_ relationship types. All of which as defined in the entity with annotations.

#### One to many relationships

In the _ArticleCategory_ entity below, ONE category is mapped to MANY articles.

```
    /**
     * @ORM\OneToMany(targetEntity="MarcoValente\DemoBundle\Entity\Article", mappedBy="category")
     */
    private $article;

```

- **targetEntity**: The "Many" in the One to Many relationship, which is the Article entity in this case.
- **mappedBy**: The field in the target entity that represents the current entity, in this example, being the _ArticleCategory_ entity.

#### Many to one relationships

In the _Article_ entity, MANY articles are mapped to ONE category.

```
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="MarcoValente\DemoBundle\Entity\ArticleCategory", inversedBy="article")
     */
    private $category;

```

- **targeEntity**: the "One" in the many to one relationship, in this case this is the Article entity.
- **inversedBy**: The field in the target entity that represents the current entity.

This lazy loads the target entity, meaning that the related target entity will not be fully loaded into the entity object, when calling `->getCategory()`, but instead a string name representation will be used.

It is possible to join a column, so then when an entity is loaded, its object will contain the objects of the related entities to. This is quite simply a MySQL JOIN.

```
    /**
     * @ORM\ManyToOne(targetEntity="MarcoValente\DemoBundle\Entity\ArticleCategory", inversedBy="article")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

```

- **name**: The column name of the current entity where the join is to be made.
- **referencedColumnName**: The column name of the target entity that the current entity is joined to.

The above ORM join definition joins the two entities on the columns defined by `name` the `referencedColumnName` fields, which in the above example would be `article.category = article_category.id`.

With this in place, the _Article_ entity, when accessed, is loaded in full along with it's related _ArticleCategory_ entity. For example: `$resultArticleObject->getCategory()->getName()`, `$resultArticleObject->getCategory()->getDescription()`.

#### Many to many relationships

A good example of a many to many relationship would be a collection articles and a collection of tags, where one article may link to many tags and inversely one tag may have may articles linking to it. In this scenario the _Article_ entity will therefore have a many to many relationship with the _ArticleTags_ entity.

In the _Article_ entity the following is defined.

```
@ORM\ManyToMany(targetEntity="Tag" inversedBy="articles")
```

While in the _ArticleTags_ entity the following is defined.

```
@ORM\ManyToMany(targetEntity="Article" mappedBy="tags")
```

### Reading database records

There exists mainly two ways to access data from a database via the Doctrine ORM. These being via the entity manager object, or via the query builder. Using the entity manager is the most common why of accessing database records, however, these exists instances where a certain query or data set is so complex that the entity manager is no longer suitable.

#### With the entity manager

Initiating the Doctrine repositories.

```
$resultObjects = $this
        ->getDoctrine()
        ->getRepository('MarcoValenteDemoBundle:Product')

```

Returning a record by it's primary key, usually being the id field.

```
->find($id);
```

Find all results where a column or columns equate to certain values.

```
->findBySku('HFJ887');
```

```
->findBy(
    array('size' => 'medium'),
    array('colour' => 'red')
   );

```

Return the first record of where a column or columns equate to certain values.

```
->findOneBySku('LO993');
```

```
->findOneBy(
    array('size' => 'large'),
    array('colour' => 'blue')
   ););

```

Return all records of an entity.

```
->findAll();
```

If the entity being queried has any relationships defined, with the _JoinColumns_ definition, then the entity manager will also load these related entities into the results object.

#### With Doctrine's query builder

For instances where basic record querying s not quire suitable, Doctrine's useful query buider may be employed to do the job. The query builder allows complex queries to be built, that may include al sorts of operations such as joins, unions and even subqueries.

Select the repository, initialize the query builder and assign an alias.

```
$query = $this
->getDoctrine()
->getRepository('MarcoValenteDemoBundle:Article')
->createQueryBuilder('a')

```

Selecting what columns are required.

```
->select('a.title, a.description, a.createdm a.author')
```

Defining the query's conditions.

```
->where('a.id = :id')
->setParameter('id',1)

```

Join additional tables, that already have relationships defined in their entity class.

```
->join('a.category', 'ac', 'ON', 'a.category = ac.id ')
```

```
->innerJoin('a.category', 'ac', 'ON', 'a.category = ac.id ')
```

```
->leftJoin('a.category', 'ac', 'ON', 'a.category = ac.id ')
```

Ordering and grouping.

```
->groupBy('a.category')
->orderBy('name','ASC')

```

It important to remember that the query builder merely builds the query and is not able to actually execute it and return data. The results therefore have to fetched using the query builder's `getResult()` method. The data may be returned in a few formats, the default being an object, as demonstrated in the example below.

```
$result = $query->getResult()
```

```
$result = $query->getSingleResult()
```

```
$result = $query->getArrayResult()
```

```
$result = $query->getSingleArrayResult()
```

```
$result = $query->getScalarResult()
```

```
$result = $query->getSingleScalarResult()
```

An example query in it's entirety.

```
$articleQuery = $this
    ->getDoctrine()
    ->getRepository('MarcoValenteDemoBundle:Article')
    ->createQueryBuilder('a')
    ->select('a.title, a,createdAt')
    ->leftJoin('a.category','c', 'ON', 'a.category = c.id')
    ->where('a.category >= :category')
    ->setParameter('category', 4)
    ->getQuery();

$articleEntity = $query->getResult();

```

### Writing to the database

Writing to the database is done with the `persist()` and `flush()` flush methods, when dealing with an entity manager object.

The `persist()` method adds the changes to the update queue, while `flush()` inserts or updates the database record.

```
->persist()
->flush();

```

Similarly, with the `remove()` function, database records may be deleted.

```
->remove()
->flush();

```

### In conclusion

Despite the learning curve, the Doctrine ORM is a wonderful ORM to work with. It's certainly one of the things that makes _Symfony_ 2 so great!

### References

- [http://www.symfony2cheatsheet.com](/web/20150225124900/http://www.symfony2cheatsheet.com/)
- [http://symfony.com/doc/current/book/doctrine.html#relationship-mapping-metadata](/web/20150225124900/http://symfony.com/doc/current/book/doctrine.html#relationship-mapping-metadata)
- [http://doctrine-orm.readthedocs.org/en/latest/reference/annotations-reference.html](/web/20150225124900/http://doctrine-orm.readthedocs.org/en/latest/reference/annotations-reference.html)
- [http://doctrine-orm.readthedocs.org/en/latest/reference/query-builder.html#executing-a-query](/web/20150225124900/http://doctrine-orm.readthedocs.org/en/latest/reference/query-builder.html#executing-a-query)
- [http://symfony.com/doc/current/reference/constraints.html](/web/20150225124900/http://symfony.com/doc/current/reference/constraints.html)
- [http://stackoverflow.com/questions/18970941/how-to-select-fields-using-doctrine-2-query-builder](/web/20150225124900/http://stackoverflow.com/questions/18970941/how-to-select-fields-using-doctrine-2-query-builder)
