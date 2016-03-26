# The King of Relations: ManyToOne

## Selecting between ManyToOne and ManyToMany

Each `genus` will have *many* `genus_notes`. But, each `genus_note` that someone adds
will relate to only *one* `genus`. There are only *two* possible types of relationships,
and this is by far the most common. It's called a *ManyToOne* association.

The second type is called a *ManyToMany* association. To use a different example,
this would be if each `product` had many tags, but also each tag related to many
products.

And when it comes to Doctrine relations - don't trust the Internet! Some people
will try to confuse you with other relationships like `OneToMany`, `OneToOne` and some
garbage about unidirectional and bidirectional associations. Gross. Ignore it all.
I guarantee, all of that will make sense really soon.

So your first job is simple: decide if you have a `ManyToOne` or `ManyToMany` relationship.
And it's easy. Just answer this question:

> Do either of the sides of the relationship belong to only *one* of the other?

Each `genus_note` belongs to only *one* `genus`, so we have a classic `ManyToOne` relationship.

## Setting up a ManyToOne Relation

Forget about Doctrine: just think about the database. If every `genus_note` should
belong to exactly *one* `genus`, How would you set that up? You'd probably add a
`genus_id` column to the `genus_note` table. Simple!

Since we need to add a new column to `GenusNote`, open that entity class. You *probably*
feel like you want to add a `$genusId` integer property here. That makes sense. But
don't! Instead, add a `$genus` property and give it a `ManyToOne` annotation. Inside
that, add `targetEntity="Genus"`:

[[[ code('ed49a68e83') ]]]

***TIP
You can also use the *full* namespace: `AppBundle\Entity\Genus` - and that's required
if the two entities do not live in the same namespace/directory.
***

Umm, guys? That's it. Relationship finished. Seriously.
