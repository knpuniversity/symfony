# OneToMany: Inverse Side of the Relation

We have the `Genus` object. So how can we get the collection of related `GenusNote`
Well, the simplest way is just to make a query - in fact, you could fetch the `GenusNote`
repository and call `findBy(['genus' => $genus])`. It's really that simple.

***TIP
You can also pass the Genus's *ID* in queries, instead of the entire `Genus` object.
***

But what if we could be even lazier? What if we were able to just say `$genus->getNotes()`?
That'd be cool! Let's hook it up!

## Setting up the OneToMany Side

Open up `GenusNote`. Remember, there are only two types of relationships: `ManyToOne`
and `ManyToMany`. For this, we needed `ManyToOne`.

But actually, you can think about any relationship in two directions: each `GenusNote`
has *one* `Genus`. Or, each `Genus` has many `GenusNote`. And in Doctrine, you can
*map* just one side of a relationship, *or* both. Let me show you.

Open `Genus` and add a new `$notes` property:

[[[ code('5614b3f258') ]]]

This is the *inverse* side of the relationship. Above this, add a `OneToMany` annotation
with `targetEntity` set to `GenusNote` and a `mappedBy` set to `genus` - that's the *property*
in `GenusNote` that forms the main, side of the relation:

[[[ code('e9830d3df4') ]]]

But don't get confused: there's still only *one* relation in the database: but now
there are two ways to access the data on it: `$genusNote->getGenus()` and now
`$genus->getNotes()`.

Add an `inversedBy` set to `notes` on this side: to point to the other property:

[[[ code('e21dbdeea8') ]]]

I'm not sure why this is *also* needed - it feels redundant - but oh well.

Next, generate a migration! Not! This is *super* important to understand: this didn't
cause any changes in the database: we just added some sugar to our Doctrine setup.

## Add the ArrayCollection

Ok, one last detail: in `Genus`, add a `__construct()` method and initialize the
`notes` property to a new `ArrayCollection`:

[[[ code('cfe068f712') ]]]

This object is like a PHP array on steroids. You can loop over it like an array,
but it has other super powers we'll see soon. Doctrine always returns one of these
for relationships instead of a normal PHP array.

*Finally*, go to the bottom of the class and add a getter for `notes`:

[[[ code('8eb7c026f3') ]]]

Time to try it out! In `getNotesAction()` - just for now - loop over `$genus->getNotes()`
as `$note` and `dump($note)`:

[[[ code('442904aae5') ]]]

Head back and refresh! Let the AJAX call happen and then go to `/_profiler` to find
the dump. Yes! A *bunch* of `GenusNote` objects.

Oh, and look at the Doctrine section: you can see the extra query that was made to
fetch these. This query doesn't happen until you *actually* call `$genus->getNotes()`.
Love it!

## Owning and Inverse Sides

That was pretty easy: *if* you want this shortcut, just add a few lines to map
the *other* side of the relationship.

But actually, you just learned the *hardest* thing in Doctrine. Whenever you have
a relation: start by figuring out which entity should have the foreign key column
and then add the `ManyToOne` relationship there first. *This* is the only side of
the relationship that you *must* have - it's called the "owning" side.

Mapping the *other* side - the `OneToMany` *inverse* side - is always optional. I don't
map it until I *need* to - either because I want a cute shortcut like `$genus->getNotes()`
or because I want to join in a query from `Genus` to `GenusNote` - something we'll
see in a few minutes.

***TIP
`ManyToMany` relationships - the only other *real* type of relationship - also have
an owning and inverse side, but you can *choose* which is which. We'll save that
topic for later.
***

Now, there is *one* gotcha. Notice I did *not* add a `setNotes()` method to `Genus`.
That's because you cannot *set* data on the inverse side: you can only set it on
the *owning* side. In other words, `$genusNote->setGenus()` will work, but `$genus->setNotes()`
would *not* work: Doctrine will ignore that when saving.

So when you setup the inverse side of a relation, do yourself a favor: do *not*
generate the setter function.
