# ManyToMany: The Inverse Side of the Relationship

Our goal is clear: list all of the genuses studied by this `User`.

## The Owning vs Inverse Side of a Relation

Back in our [Doctrine Relations][doctrine_relations] tutorial, we learned that *every*
relationship has two different sides: a mapping, or *owning* side, and an *inverse* side.
In that course, we added a `GenusNote` entity and gave it a `ManyToOne` relationship
to `Genus`:

[[[ code('30cb2ef4a9') ]]]

This is the *owning* side, and it's the only one that we actually needed to create.

If you look in `Genus`, we also mapped the *other* side of this relationship: a `OneToMany`
back to `GenusNote`:

[[[ code('6f6d60bb28') ]]]

This is the *inverse* side of the relationship, and it's optional. When we mapped
the *inverse* side, it caused *no* changes to our database structure. We added
it *purely* for convenience, because we decided it sure would be fancy and nice
if we could say `$genus->getNotes()` to automagically fetch all the `GenusNotes`
for this `Genus`.

With a `ManyToOne` relationship, we don't choose which side is which: the `ManyToOne`
side is *always* the required, *owning* side. And that makes sense, it's the table
that holds the foreign key column, i.e. `GenusNote` has a `genus_id` column.

## Owning and Inverse in ManyToMany

We can *also* look at our `ManyToMany` relationship in two different directions.
If I have a `Genus` object, I can say: 

> Hello fine sir: please give me all Users related to this Genus.

But if I have a `User` object, I should also be able to say the opposite:

> Good evening madame: I would like all Genuses related to this User.

The tricky thing about a `ManyToMany` relationship is that you get to *choose*
which side is the *owning* side and which is the *inverse* side. And, I hate choices!
The choice *does* have consequences.... but don't worry about that - we'll learn
why soon.

## Mapping the Inverse Side

Since we only have one side of the relationship mapped now, it's the *owning* side.
To map the *inverse* side, open `User` and add a new property: `$studiedGenuses`.
This will *also* be a `ManyToMany` with `targetEntity` set to `Genus`. But also add
`mappedBy="genusScientists`:

[[[ code('a782dcd1b5') ]]]

That refers to the property inside of `Genus`:

[[[ code('2599c82c52') ]]]

Now, on *that* property, add `inversedBy="studiedGenuses`, which points *back*
to the property we just added in `User`:

[[[ code('6dde6644c2') ]]]

When you map *both* sides of a `ManyToMany` relationship, this `mappedBy` and `inversedBy`
configuration is how you tell Doctrine which side is which. We don't *really* know
why that's important yet, but we will soon.

Back in `User`, remember that whenever you have a relationship that holds a collection
of objects, like a collection of "studied genuses", you need to add a `__construct`
function and initialize that to a `new ArrayCollection()`:

[[[ code('8370a0e336') ]]]

Finally, since we'll want to be able to access these `studiedGenuses`, go to the
bottom of `User` and add a new `public function getStudiedGenuses()`. Return that
property inside. And of course, we love PHP doc, so add `@return ArrayCollection|Genus[]`:

[[[ code('ee23f3d8d7') ]]]

## Using the Inverse Side

And *just* by adding this new property, we are - as I *love* to say - dangerous.

Head into the `user/show.html.twig` template that renders the page we're looking
at right now. Add a column on the right side of the page, a little "Genuses Studied"
header, then a `ul`. To loop over all of the genuses that this user is studying, just
say `for genusStudied in user.studiedGenuses`. Don't forget the `endfor`:

[[[ code('d8aa8cbde5') ]]]

Inside, add our favorite `list-group-item` and then a link. Link this *back* to
the `genus_show` route, passing `slug` set to `genusStudied.slug`. Print out
`genusStudied.name`:

[[[ code('1df555e346') ]]]

But will it blend? I mean, will it work? Refresh!

Hot diggity dog! There are the *three* genuses that this `User` studies. We did
nothing to deserve this nice treatment: Doctrine is doing all of the query work for
us.

In fact, click the database icon on the web debug toolbar to see what the query looks
like. When we access the property, Doctrine does a `SELECT` from `genus` with an
`INNER JOIN` to `genus_scientist` where `genus_scientist.user_id` equals this User's
id: 11. That's perfect! Thanks Obama!

## Ordering the Collection

The *only* bummer is that we can't control the order of the genuses. What if we
want to list them alphabetically? We can't - we would instead need to make a custom
query for the genuses in the controller, and pass them into the template.

What? Just kidding! In `User`, add another annotation: `@ORM\OrderBy({"name" = "ASC")`:

[[[ code('279ca9f219') ]]]

Refresh that!

If you didn't *see* a difference, you can double-check the query to prove it. Boom!
There's our new `ORDER BY`. Later, I'll show you how you can mess with the query
made for collections even more via [Doctrine Criteria][doctrine_criteria].

But up next, the last missing link: what if a `User` *stops* studying a `Genus`?
How can we remove that link?

[doctrine_relations]: https://knpuniversity.com/screencast/doctrine-relations
[doctrine_criteria]: https://knpuniversity.com/screencast/collections/criteria-collection-filtering
