# ManyToMany with Extra Fields

Head back to `/genus` and click into one of our genuses. Thanks to our hard work,
we can link genuses and users. So I know that Eda Farrell is a `User` that studies
this `Genus`.

But, hmm, what if I need to store a little extra data on that relationship, like
the number of *years* that each `User` has studied the `Genus`. Maybe Eda has studied
this `Genus` for 10 years, but Marietta Schulist has studied it for only 5 years.

In the database, this means that we need our join table to have *three* fields
now: `genus_id`, `user_id`, but also `years_studied`. How can we add that extra
field to the join table?

The answer is simple, you can't! It's not possible. Whaaaaat? 

You see, `ManyToMany` relationships only work when you have *no* extra fields on
the relationship. But don't worry! That's by design! As soon as your join table need
to have even *one* extra field on it, you need to build an entity class for it.

## Creating the GenusScientist Join Entity

In your `Entity` directory, create a new class: `GenusScientist`. Open `Genus` and
steal the ORM `use` statement on top, and paste it here.

Next, add some properties: `id` - we could technically avoid this, but I like to
give every entity an `id` - `genus`, `user`, and `yearsStudied`.

Use the `Code->Generate` menu, or `Command+N` on a Mac, and select `ORM Class` to
generate the class annotations. Oh, and notice! This generated a table name of
`genus_scientist`: that's perfect! I want that to match our existing join table:
we're going to migrate it to this new structure.

Go back to `Code->Generate` and this time select `ORM Annotation`. Generate the annotations
for `id` and `yearsStudied`.

Perfect!

So how should we map the `genus` and `user` properties? Well, think about it: each
is now a classic `ManyToOne` relationship. Every `genus_scientist` row should have
a `genus_id` column and a `user_id` column. So, above `genus`, say `ManyToOne` with
`targetEntity` set to `Genus` Below that, add the optional `@JoinColumn` with
`nullable=false`.

Copy that and put the same thing above `user`, changing the `targetEntity` to `User`.

And... that's it! Finish the class by going back to the `Code->Generate` menu, or
`Command+N` on a Mac, selecting Getters and choosing `id`. Do the same again for
`Getters and Setters`: choose the rest of the properties.

Entity, done!

## Updating the Existing Relationships

Now that the join table has an entity, we need to update the relationships in `Genus`
and `User` to point to it. In `Genus`, find the `genusScientists` property. Guess
what? This is *not* a `ManyToMany` to `User` anymore: it's now a `OneToMany` to
`GenusScientist`. Yep, it's now the *inverse* side of the `ManyToOne` relationship
we just added. That means we need to change `inversedBy` to `mappedBy` set to `genus`.
And of course, `targetEntity` is `GenusScientist`.

You *can* still keep the `fetch="EXTRA_LAZY"`: that works for any relationship
that holds an array of items. But, we *do* need to remove the `JoinTable`: annotation:
both `JoinTable` and `JoinColumn` can only live on the *owning* side of a relationship.

There are more methods in this class - like `addGenusScientist()` that are now totally
broken. But we'll fix them later. In `GenusScientist`, add `inversedBy` set to the
`genusScientists` property on `Genus`.

Finally, open `User`: we need to make the exact same changes here.

For `studiedGenuses`, the `targetEntity` is now `GenusScientist`, the relationship
is `OneToMany`, and it's `mappedBy` the `user` property inside of `GenusScientist`.
The `OrderBy` doesn't work anymore. Well, technically it *does*, but we can only
order by a field on `GenusScientist`, not on `User`. Remove that for now.

***TIP
You should also add the `inversedBy="studiedGenuses"` to the `user` property in
`GenusScientist`. It didn't hurt anything, but I forgot that!
***

## The Truth About ManyToMany

Woh! Ok! Step back for a second. Our `ManyToMany` relationship is now *entirely*
gone: replaced by 3 entities and 2 classic `ManyToOne` relationships. And if you think
about it, you'll realize that a `ManyToMany` relationship is nothing more than two
`ManyToOne` relationships in disguise. All along, we could have mapped our original
setup by creating a "join" `GenusScientist` entity with only `genus` and `user`
`ManyToOne` fields. A `ManyToMany` relationship is just a convenience layer when
that join table doesn't need any extra fields. But as soon as you *do* need extra,
you'll need this setup.

## Generating (and Fixing) the Migration

Last step: generate the migration:

```bash
php bin/console doctrine:migrations:diff
```

Look in the `app/DoctrineMigrations` directory and open that migration.

So freakin' cool! Because we already have the `genus_scientist` join table, the migration
does *not* create any new tables. Nope, it simply modifies it: drops a couple of
foreign keys, adds the `id` and `years_studied` columns, and then re-adds the foreign
keys. Really, the only thing that changed of importance is that we now have an `id`
primary key, and a `years_studied` column. But otherwise, the table is still there,
just the way it always was.

If you try to run this migration...it will blow up, with this rude error:

> Incorrect table definition; there can be only one auto column...

It turns out, Doctrine has a bug! Gasp! The horror! Yep, a bug in its MySQL
code generation that affects this *exact* situation: converting a `ManyToMany` to
a join entity. No worries: it's easy to fix... and I can't think of *any* other
bug like this in Doctrine... and I use Doctrine *a lot*.

Take this last line: with `ADD PRIMARY KEY id`, copy it, remove that line, and
then - after the `id` is added in the previous query - paste it and add a comma.
MySQL needs this to happen all in one statement.

But now, our migrations are in a *crazy* weird state, because this one *partially*
ran. So let's start from scratch: drop the database fully, create the database,
and then make sure all of our migrations can run from scratch:

```bash
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Success!

Now that we have a different type of relationship, our app is broken! Yay! Let's
fix it and update our forms to use the `CollectionType`.
