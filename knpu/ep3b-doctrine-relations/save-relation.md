# Saving a Relation

Head back to `GenusController`. In `newAction()`, create a new `GenusNote` - let's
see *how* we can relate this to a `Genus`. I'll paste in some code here to set each
of the normal properties - they're *all* required in the database right now.

So how can we link *this* `GenusNote` to this `Genus`? Simple: `$genusNote->setGenus()`
and pass it the entire genus object.

That's it. Seriously! The only tricky part is that you set the entire *object*, not
the id. With Doctrine relations, you almost need to forget about id's entirely: your
job is to link one object to another. When you save, Doctrine works out the details
of how this should look in the database.

Don't forget to persist the `$genusNote`. And, you can persist in *any* order: Doctrine
automatically knows that it needs to insert the `genus` first and then the `genus_note`.
That's really powerful.

## Defaulting the isPublished Field

And simple! Head to the browser to check it out - `/genus/new`. Whoops - an error:
the `publishedAt` property cannot be null. My bad - that's unrelated. 

In `Genus`, give the `isPublished` field a default value of `true`. Now, if you forget
to set this field - it'll default to true instead of null.

Woo! No errors this time. Check out the queries for the page. Nice! Two insert queries:
`INSERT INTO genus` and then `INSERT INTO genus_note` using 46: the new genus's id.

With two lines to setup the relationsip, and one line to link a `GenusNote` to a
`Genus`, you've got a fantastic new relationship.
