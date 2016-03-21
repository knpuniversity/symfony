# Custom Queries

Time to put that *lazy*  `isPublished` field to work. I *only* want to show *published*
genuses on the list page. Up until now, we've been the lazy ones - by using `findAll()`
to return *every* Genus object. We've avoided writing queries.

There *are* a few other methods besides `findAll()` that you can use to customize
things a bit, but look: someday we're going to need to grow up and write a custom
query. It's time to grow up.

## What is the Repository?

To query, we always use this repository object. But, uh, what *is* that object anyways?
Be curious and dump `$em->getRepository('AppBundle:Genus)` to find out:

[[[ code('a2f57b3aec') ]]]

Refresh! I didn't add a `die` statement - so the dump is playing hide-and-seek down
in the web debug toolbar. Ah, it turns out this is an `EntityRepository` object -
something from the core of Doctrine. And *this* class has the helpful methods on
it - like `findAll()` and `findOneBy()`.

Ok, wouldn't it be sweet if we could add *more* methods to this class - like `findAllPublished()`?
Well, I think it would be cool. So let's do it!

## Creating your own Repository

No no, not by hacking Doctrine's core files: we're going to create our *own* repository
class. Create a new directory called `Repository`. Inside, add a new class - `GenusRepository`.
None of these names are important. Keep the class empty, but make it extend that
`EntityRepository` class so that we *still* have the original helpful methods:

[[[ code('0247ff3f8a') ]]]

Next, we need to tell Doctrine to use *this* class instead when we call `getRepository()`.
To do that, open `Genus`. At the top, `@ORM\Entity` is empty. Add parentheses,
`repositoryClass=`, then the full class name to the new `GenusRepository`:

[[[ code('8e29c1549a') ]]]

That's it! Refresh! *Now* the dump shows a `GenusRepository` object. And *now* we
can start adding custom functions that make custom queries. So, each entity that needs
a custom query will have its own repository class. And every custom query you write
will live inside of these repository classes. That's going to keep your queries
*super* organized.

## Adding a Custom Query

Add a new `public function` called `findAllPublishedOrderedBySize()`:

[[[ code('bc4210dac8') ]]]

I'm following Doctrine's naming convention of `findAllSOMETHING` for
an array – or `findSOMETHING` for a single result.

Fortunately, custom queries always look the same:  start with, return
`$this->createQueryBuilder('genus')`:

[[[ code('4f6b653f04') ]]]

This returns a `QueryBuilder`. His favorite things are pizza and helping you
easily write queries. Because we're *in* the `GenusRepository`, the query already
knows to select from that table. The `genus` part is the table alias - it's like
in MySQL when you say `SELECT * FROM genus g` - in that case `g` is an alias you
can use in the rest of the query. I like to make my aliases a little more descriptive.

### WHERE

To add a `WHERE` clause, chain `->andWhere()` with `genus.isPublished = :isPublished`:

[[[ code('91dbd6aa3d') ]]]

I know: the `:isPublished` looks weird - it's a parameter, like a placeholder.
To fill it in, add `->setParameter('isPublished', true)`:

[[[ code('ad17707873') ]]]

We always set variables like this using parameters to avoid SQL injection attacks.
Never concatenate strings in a query.

### ORDER BY

To order... well you can kind of guess. Add `->orderBy()` with `genus.speciesCount`
and `DESC`:

[[[ code('4abe6274b0') ]]]

Query, done!

### Finishing the Query

To execute the query, add `->getQuery()` and then `->execute()`:

[[[ code('e2db1b3923') ]]]

That's it! Your query will always end with either `execute()` - if you want an *array*
of results - or `getOneOrNullResult()` - if you want just *one* result... or obviously
null if nothing is matched.

Let's really show off by adding some PHP doc above the method. Oh, we can do better
than `@return mixed`! *We* know this will return an array of `Genus` objects - so
use `Genus[]`:

[[[ code('149524a94d') ]]]

## Using the Custom Query

Our hard work is done - using the new method is simple. Replace `findAll()` with
`findAllPublishedOrderedBySize()`:

[[[ code('b4ccc7c04a') ]]]

Go back, refresh... and there it is! A few disappeared because they're unpublished.
And the genus with the most species is first. Congrats!

We have an entire tutorial on doing crazy custom queries in Doctrine. So if you want
to start selecting only a few columns, using raw SQL or doing really complex joins,
check out the [Go Pro with Doctrine Queries][1].

Woh guys - we just *crushed* all the Doctrine basics - go build something cool and
tell me about it. There's just *one* big topic we *didn't* cover - relationships.
These are *beautiful* in Doctrine, but there's a lot of confusing and over-complicated
information about there. So let's master that in the next tutorial. Seeya guys next
time!


[1]: https://knpuniversity.com/screencast/doctrine-queries
