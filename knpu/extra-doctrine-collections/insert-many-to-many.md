# Inserting into a ManyToMany

The *big* question is: who is the best superhero of all time? Um, I mean, how
can we *insert* things into this join table? How can we join a `Genus` and a `User`
together?

Doctrine makes this *easy*... and yet... at the same time... kind of confusing!
First, you need to completely forget that a join table exists. Stop thinking about
the database! Stop it! Instead, your *only* job is to get a `Genus` object, put
one or more `User` objects onto its `genusScientists` property and then save. Doctrine
will handle the rest.

## Setting Items on the Collection

Let's see this in action! Open up `GenusController`. Remember `newAction()`? This isn't
a real page - it's just a route where *we* can play around and test out some code.
And hey, it *already* creates and saves a `Genus`. Cool! Let's associate a user
with it!

First, find a user with `$user = $em->getRepository('AppBundle:User')` then `findOneBy()`
with `email` set to `aquanaut1@example.org`:

[[[ code('7b78b1fd98') ]]]

That'll work thanks to our handy-dandy fixtures file! We have scientists with
emails `aquanaut`, `1-10@example.org`:

[[[ code('1038f343fd') ]]]

We've got a `User`, we've got a `Genus`... so how can we smash them together? Well,
in `Genus`, the `genusScientists` property is private. Add a new function so we can
put stuff into it: `public function: addGenusScientist()` with a `User` argument:

[[[ code('fafe248ed0') ]]]

Very simply, add that `User` to the `$genusScientists` property. Technically, that
property is an `ArrayCollection` object, but we can treat it like an array:

[[[ code('7744353a87') ]]]

Then back in the controller, call that: `$genus->addGenusScientist()` and pass it
`$user`:

[[[ code('938feb471a') ]]]

We're done! We don't even need to persist anything new, because we're already persisting
the `$genus` down here.

Try it out! Manually go to `/genus/new`. Ok, genus Octopus15 created. Next, head to
your terminal to query the join table. I'll use:

```bash
./bin/console doctrine:query:sql "SELECT * FROM genus_scientist"
```

Oh yeah! The genus id 11 is now joined - by pure coincidence - to a user who is also
id 11. This successfully joined the Octopus15 genus to the `aquanaut1@example.org`
user.

If adding new items to a ManyToMany relationship is confusing... it's because Doctrine
does all the work for you: add a User to your Genus, and just save. Don't over-think
it!

## Avoiding Duplicates

Let's do some experimenting! What if I duplicated the `addGenusScientist()` line?

[[[ code('b598a827e6') ]]]

Could this *one* new `Genus` be related to the same `User` *two* times? Let's find
out!

Refresh the new page again. Alright! I love errors!

> Duplicate entry '12-11' for key 'PRIMARY'

So this is saying:

> Yo! You can't insert *two* rows into the `genus_scientist` table for the same
> genus and user.

And this is *totally* by design - it doesn't make sense to relate the same `Genus`
and `User` multiple times. So that's great... but I *would* like to avoid this error
in case this happens accidentally in the future.

To do that, we need to make our `addGenusScientist()` method a *little* bit smarter.
Add if `$this->genusScientists->contains()`... remember, the `$genusScientists`
property is actually an `ArrayCollection` object, so it has some trendy methods on
it, like `contains`. Then pass `$user`. If `genusScientists` already has this `User`,
just return:

[[[ code('fe6d7c7c15') ]]]

Now when we go back and refresh, no problems. The `genus_scientist` table now holds
the original entry we created and this *one* new entry: no duplicates for us.

Next mission: if I have a `Genus`, how can I get and print of all of its related
Users? AND, what if I have a `User`, how can I get its related Genuses? This will
take us down the magical - but dangerous - road of *inverse* relationships.
