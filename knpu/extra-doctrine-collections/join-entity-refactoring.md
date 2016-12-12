# Join Entity App Refactoring

In some ways, not much just changed. Before, we had a `genus_scientist` table
with `genus_id` and `user_id` columns. And... we still have that, just with two
new columns:

[[[ code('9737f55b87') ]]]

But, in our app, a ton just changed. That's my nice way of saying: we just broke
everything!

## Collection of GenusScientists, not Users

For example, before, `genusScientists` was a collection of `User` objects, but now
it's a collection of `GenusScientist` objects:

[[[ code('dd27a7e640') ]]]

The same thing is true on `User`:

[[[ code('96bbf1a975') ]]]

Wherever our code was using the `studiedGenuses` property - to get the collection or
change it - well, that code is done broke.

Let's clean things up! And see some cool stuff along the way.

## Creating new Join Entity Links

First, because we just emptied our database, we have no data. Open the fixtures
file and temporarily comment-out the `genusScientists` property:

[[[ code('d5e2de45d4') ]]]

We can't simply set a `User` object on `genusScientists` anymore: this *now* accepts
`GenusScientist` objects. We'll fix that in a second.

But, run the fixtures:

```bash
./bin/console doctrine:fixtures:load
```

While that's working, go find `GenusController` and `newAction()`. Let's once again
use this method to hack together and save some interesting data.

First, remove the two `addGenusScientist` lines:

[[[ code('68d10df3ca') ]]]

These don't make any sense anymore!

How can we add a new row to our join table? Just create a new entity:
`$genusScientist = new GenusScientist()`. Then, set `$genusScientist->setGenus($genus)`,
`$genusScientist->setUser($user)` and `$genusScientist->setYearsStudied(10)`. Don't
forget to `$em->persist()` this new entity:

[[[ code('66b5081d9a') ]]]

There's nothing fancy going on anymore: `GenusScientist` is a normal, boring entity.

## Using the new Collections

In your browser, try it: head to `/genus/new`. Genus created! Click the link to
see it! Explosion! That's no surprise: our template code is looping over `genusScientists`
and expecting a `User` object. Silly template! Let's fix that and the fixtures next.
