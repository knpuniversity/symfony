# Collection Filtering: The Easy Way

I have *one* last cool trick to show you. Go back to `/genus`.

Oh, but real quick, I need to fix two little things that I messed up before we finish.

## Oh my, a Missing inversedBt

First, see that red label on the web debug toolbar? Click it, and scroll down.
It's a mapping warning: the `User.studiedGenuses` property is on the inverse side
of a bidirectional relationship, but the association on blah-blah-blah does not
contain the required `inversedBy`.

In human-speak, this says that my `User` correctly has a `studiedGenuses` property
with a `mappedBy` option... but on `GenusScientist`, I forgot to add the `inversedBy`
that points back to this. I don't really know why Doctrine requires this... since
it didn't seem to break anything, but hey! This fixes the warning.

## Bad Field Type Mapping!

The second thing I need to fix is this `yearsStudied` field. When PhpStorm generated
the annotation for us, it used `type="string"`... and I forgot to fix it! Change
it to `type="integer"`. It hasn't caused a problem yet... but it would if we tried
to do some number operations on it inside the database.

Of course, we need a migration!

```bash
php bin/console doctrine:migrations:diff
```

Just trust that it's correct - live dangerously:

```bash
php bin/console doctrine:migrations:migrate
```

Sweet! Now go back to `/genus`.

## Fetching a Subset of GenusScientist Results

We're already printing the number of scientists that each `Genus` has. *And*
thanks to a fancy query we made inside `GenusRepository`, that joins over and fetches
the related `User` data all at once... this entire page is built with one query.
Well, except for the query that loads my security user from the database.

So this is cool! Well, its *maybe* cool - as we talked about earlier, this is fetching
a lot of extra data. And more importantly, this page may not be a performance problem
in the first place. Anyways, I want to show you something cool, so comment out those joins.

Refresh again! Our *one* query became a bunch! Every row now has a query, but it's
a really efficient COUNT query thanks to our fetch `EXTRA_LAZY` option.

Here's my new wild idea: any scientist that has studied a genus for longer than
20 years should be considered an *expert*. So, in addition to the number of scientists
I also want to print the number of *expert* scientists next to it.

Look inside the list template: we're printing this number by saying
`genus.genusScientists|length`. In other words, call `getGenusScientists()`, fetch
the results, and then count them.

But how could we filter this to *only* return `GenusScientist` results that have
studied the `Genus` for longer than 20 years?

It's easy! In `Genus`, create a new public function called `getExpertScientists()`.
Then, we'll loop over *all* of the scientists to find the experts. And actually,
we can do that very easily by saying `$this->getGenusScientists()->filter()`, which
is a method on the `ArrayCollection` object. Pass *that* an anonymous function with
a `GenusScientist` argument. Inside, return `$genusScientist->getYearsStudied() > 20`.

This will loop over *all* of the genus scientists and return a new `ArrayCollection`
that only contains the ones that have studied for more than 20 years. It's perfect!

To print this in the template, let's add a new line, then
`{{ genus.expertScientists|length }}` and then "experts".

Try it! Refresh! Zero! What!? Oh... I forgot my `return` statement from inside
the filter function. Lame! Try it now. Yes!

Click to check out the queries. It *still* makes a COUNT query for each row...
but wait: it *also* queries for *all* of the `genus_scientist` results for each
`genus`. That sucks! Even if a `Genus` only has two experts... we're fetching *all*
of the data for *all* of its genus scientists.

Why? Well, as soon as we loop over `genusScientists`, Doctrine realizes that it
needs to go and query for all of the genus scientists for this `Genus`. Then, we
happily loop over them to see which ones have more than 20 `yearsStudied`.

This may or may or may not be a huge performance problem. If every `Genus` always
has just a few scientists, no big deal! But if a `Genus` has hundreds of scientists,
this page will grind to a halt while it queries for and hydrates all of those
extra `GenusScientist` objects.

There's a better way: and it uses a feature in Doctrine that - until recently - even
*I* didn't know existed. And I'm super happy it does.
