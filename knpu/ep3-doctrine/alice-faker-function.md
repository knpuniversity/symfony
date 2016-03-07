# Custom Alice Faker Function

The Faker `name()` function gives us a *poor* genus name. Yea, I know - this is just
*fake* data - but it's *so* wrong that it fails at its one job: to give us some
*somewhat* realistic data to make development easy.

Here's our goal: use a new `<genus()>` function in Alice and have *this* return the
name of a random ocean-bound genus. This shouldn't work yet - but try it to see the
error:

```bash
php bin/console doctrine:fixtures:load
```

> Unknown formatter "genus"

Faker calls these functions "formatters". Can we create our own formatter? Absolutely.

## Adding a Custom Formatter (Function)

In `LoadFixtures`, break the `load()` call onto multiple lines to keep things short
and civilized.  Now, add a third argument - it's sort of an "options" array. Give
it a key called `providers` - these will be additional objects that *provide* formatter
functions - and set it to an array with `$this`.

And we're nearly done! To add a new `genus` formatter, add `public function genus()`.
I've already prepared a lovely list of some fantastic genuses that live in the ocean.

Finish this with `$key = array_rand($genera)` and then `return $genera[$key]`. Let's
give it a try:

```bash
php bin/console doctrine:fixtures:load
```

No errors! Refresh! Ah, *so* much better.

## New Random Boolean Column

Now, hold on, we have a *new* requirement: we need the ability to have published
and *unpublished* genuses - for those times when we create a new genus, but we're
still trying to think of a fun fact before it shows up on the site. With our beautiful
migration and fixtures systems, this will be a breeze.

First, open `Genus` and add a new `private property` - call it `$isPublished`. Next,
use the Code->Generate shortcut - or Ctrl+Enter - to generate the annotations. Hey
that was cool! Because the property started with `is`, PhpStorm correctly guessed
that this is a `boolean` column. Go team!

At the bottom, generate *just* the setter function. We can add a getter function
later... if we need one.

We need to update the fixtures. But first, find the command line and generate the
migration:

```bash
bin/console doctrine:migrations:diff
```

Be a responsible dev and make sure the migration looks right. Actually, it looks
*perfect*. Run it:

```bash
bin/console doctrine:migrations:migrate
```

Last step: we want to have a *few* unpublished genuses in the random data set. Open
the Faker documentation and search for "boolean". Perfect! There's a built-in `boolean()`
function *and* we can control the `$chanceOfGettingTrue`. In the fixtures file,
add `isPublished` and set that to `boolean(75)` - so that *most* genuses are published.

Re-run the fixtures!

```bash
bin/console doctrine:fixtures:load
```

Hey, no errors! Now, to only show the published genuses on the list page, we need
a custom query.
