# Criteria System: Champion Collection Filtering

Filtering a collection from inside of your entity like this is really convenient...
but unless you *know* that you will always have a small number of total scientists...
it's likely to slow down your page big.

Ready for a better way?! Introducing, Doctrine's Criteria system: a part of Doctrine
that's *so* useful... and yet... I don't think anyone knows it exists!

Here's how it looks: create a `$criteria` variable set to `Criteria::create()`:

[[[ code('0f7e2cd5f6') ]]]

Next, we'll chain off of this and build something that looks *somewhat* similar
to a Doctrine query builder. Say, `andWhere()`, then `Criteria::expr()->gt()`
for a greater than comparison. There are a ton of other methods for equals, less than
and any other operator you can dream up. Inside `gt`, pass it `'yearsStudied', 20`:

[[[ code('505fefc56b') ]]]

And hey! Let's show off: add an `orderBy()` passing it an array with `yearsStudied`
set to `DESC`:

[[[ code('c87c2d5d0a') ]]]

This Criteria describes *how* we want to filter. To use it, return
`$this->getGenusScientists()->matching()` and pass that `$criteria`:

[[[ code('ebde980bd5') ]]]

That is it!

Now check this out: when we go back and refresh, we get all the same results. But
the queries are *totally* different. It still counts all the scientists for the first
number. But then, instead of querying for all of the genus scientists, it uses a
WHERE clause with `yearsStudied > 20`. It's now doing the filtering in the *database*
instead of in PHP.

As a bonus, because we're simply *counting* the results, it ultimately makes a COUNT
query. But if - in our template, for example - we wanted to loop over the experts,
maybe to print their names, Doctrine would be smart enough to make a SELECT statement
for that data, instead of a COUNT. But that SELECT would *still* have the WHERE clause
that filters in the database.

In other words guys, the Criteria system kicks serious butt: we can filter a collection
from *anywhere*, but do it efficiently. Congrats to Doctrine on this feature.

## Organizing Criteria into your Repository

But, to keep my code organized, I prefer to have all of my query logic inside of
repository classes, including Criteria. No worries! Open `GenusRepository` and create
a new `static public function createExpertCriteria()`:

[[[ code('33ea28f5c2') ]]]

***TIP
Whoops! It would be better to put this method in `GenusScientistRepository`, since
it operates on that entity.
***

Copy the criteria line from genus, paste it here and return it. Oh, and be sure you
type the "a" on `Criteria` and hit tab so that PhpStorm autocompletes the `use` statement:

[[[ code('8c8285a797') ]]]

But wait, gasp! A static method! Why!? Well, it's because I need to be able to access
it from my `Genus` class... and that's only possible if it's static. And also, I
think it's fine: this method doesn't make a query, it simply returns a small, descriptive,
static value object: the `Criteria`.

Back inside `Genus`, we can simplify things
`$this->getGenusScientists()->matching(GenusRepository::createExpertCriteria())`:

[[[ code('ea20f3d06c') ]]]

Refresh that! Sweet! It works just like before.

## Criteria in Query Builder

Another advantage of building the `Criteria` inside of your repository is that you
can use it in a query builder. Imagine that we needed to query for *all* of the
experts in the entire system. To do that we could create a new public function -
`findAllExperts()`:

[[[ code('b4b1466f23') ]]]

***TIP
Once again, this method should *actually* live in `GenusScientistRepository`, but
the idea is exactly the same :).
***

But, I want to *avoid* duplicating the query logic that we already have in the Criteria!

No worries! Just return `$this->createQueryBuilder('genus')` then,
`addCriteria(self::createExpertCriteria())`:

[[[ code('f798456c7e') ]]]

Finish with the normal `getQuery()` and `execute()`:

[[[ code('34358350e2') ]]]

How cool is that!?

Ok guys, that's it - that's everything. We just attacked the stuff that *really*
frustrates people with Doctrine and Forms. Collections are hard, but if you understand
the mapping and the inverse side reality, you write your code to update the mapping
side *from* the inverse side, and understand a few things like `orphanRemoval` and
`cascade`, everything falls into place.

Now that you guys know what to do, go forth, attack collections and create something
amazing.

All right guys, see you next time.
