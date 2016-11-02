# Join Entity App Refactoring

In some ways, not much just changed. Before, we had a `genus_scientist` table
with a `genus_id` and a `user_id` columns. And... we still have that, with two
new columns.

But, in our app, a ton just changed. That's my nice way of saying: we just broke
a bunch of stuff!

## Collection of GenusScientists, not Users

For example, before, `genusScientist` was a collection of `User` objects, but now
it's a collection of `GenusScientist` objects. The same thing is true on `User`:
wherever our code was using the `studiedGenuses` property - to get the collection
or change it - well, that code is done broke.

Let's clean things up! And see some really interesting things along the way.

## Creating new Join Entity Links

First, because we just emptied our database, we have no data. Open the fixtures
file and temporarily comment-out the `genusScientist` property. We can't simply set
a `User` object on `genusScientist` anymore: this *now* needs `GenusScientist`
objects. We'll fix that in a second.

But, run the fixtures:

```bash
php bin/console doctrine:fixtures:load
```

While that's working, go find `GenusController` and `newAction()`. Let's once again
use this method to hack together some more interesting data.

First, remove the two `addGenusScientist` lines. These don't make any sense anymore!
How can we add a new row to our join table? Just create a new entity:
`$genusScientist = new GenusScientist()`. Then, set `$genusScientist->setGenus($genus)`,
`$genusScientist->setUser($user)` and `$genusScientist->setYearsStudied(10)`. Don't
forget to `$em->persist()` this new entity.

There's nothing fancy going on anymore: `GenusScientist` is a normal, boring entity.

## Using the new Collections

In your browser, try it: head to `/genus/new`. Genus created! Click the link to
see it! Explosion! That's no surprise: our template code is looping over `genusScientists`
and expecting a `User` object. Silly template! Let's fix that and the fixtures next.