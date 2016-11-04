# Criteria System: Champion Collection Filtering

Filtering a collection from inside of your entity like this is really convenient...
but unless you *know* that you will always have a small number of scientists...
it's likely to slow down your page big.

Ready for a better way?! Introducing, Doctrine's Criteria system: a part of Doctrine
that's *so* useful... and yet... I don't think anyone knows it exists!

Here's how it looks: create a `$criteria` variable set to `Criteria::create()`. Next,
we'll chain off of this and build something that looks *quite* similar to a Doctrine
query builder. Say, `andWhere()`, then `Criteria::expr()->gt()` for a greater than
comparison. There are a ton of other methods for equals, less than and any other
operator you can dream up. Inside `gt`, pass it `'yearsStudied', 20`. And hey! Let's
show off: add an `orderBy()` passing it an array with `yearsStudied` set to `DESC`.

This Criteria describes *how* we want to filter. To use it, return
`$this->getGenusScientists()->matching()` and pass that `$criteria`. That is it!

Now check this out: when we go back and refresh, we get all the same results. But
the queries are *totally* different. It still counts all the scientists for the first
number. But then, instead of querying for all of the genus scientists, it uses a
WHERE clause with `yearsStudied > 20`. It's now doing the filtering in the *database*
instead of in PHP.

As a bonus, because we're simply *counting* the results, it ultimately makes a COUNT
query. But if - in our template - we wanted to loop over the experts, maybe to print
their names, Doctrine would be smart enough to make a SELECT statement for that data,
instead of a COUNT. But that SELECT would *still* have the WHERE statement that filters
in the database.

In other words guys, the Criteria system kicks butt: we can filter a collection from
*anywhere*, but do it efficiently. Congrats to Doctrine on this.

## Organizing Criteria into your Repository

But, to keep my code organized, I prefer to have all of my query logic inside of
repository classes, including Criteria. No worries! Open `GenusRepository` and create
a new `static public function`, `createExpertCriteria()`.

Copy the criteria line from genus, paste it here and return it directly. Oh, and
be sure you type the "a" on `Criteria` and hit tab so that PhpStorm autocompletes
the `use` statement.

But wait, gasp! A static method! Why!? Well, because I need to be able to access
it from my `Genus` class... and that's only possible if it's static. And I think
it's fine: this method doesn't make a query, it simply returns a small, descriptive
value object.

Back inside `Genus`, we can simplify things
`$this->getGenusScientists()->matching(GenusRepository::createExpertCriteria())`.

Refresh that! Yes! It works just like before.

## Criteria in Query Builder

Another advantage of building the `Criteria` inside of your repository is that you
can use them in a query builder. Imagine that we needed to query for *all* of the
experts in the entire system. To do that we could create a new public function -
`findAllExperts()`. But, I want to *avoid* duplicating the query logic that we
already have in the Criteria!

No worries! Just return `$this->createQueryBuilder('genus')` then,
`addCriteria(self::createExpertCriteria())`. Finish with the normal `getQuery()`
and `execute()`.

How cool is that!?

Ok guys, that's it - that's everything. We just attacked the stuff that *really*
frustrates people with Doctrine and Symfony. Collections are hard, but if you understand
the mapping and the inverse side reality, you write your code to update the mapping
side *from* the inverse side, and understand a few things like `orphanRemoval` and
`cascade`, everything just falls into place.

Now that you guys know what to do, go forth and don't be afraid of collections. Instead,
attack them and create something amazing.

All right guys, see you next time.
