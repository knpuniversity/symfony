# Saving a Relationship

Doctrine will create a `genus_id` integer column for this property and a foreign key to `genus`.

Use the "Code"->"Generate" menu to generate the getter and setter:

[[[ code('55b2518795') ]]]

Add a `Genus` type-hint to `setGenus()`:

[[[ code('25bc257526') ]]]

Yes, when we call `setGenus()`, we'll pass it an entire `Genus` *object* not an ID.
More on that soon.

## Generate the Migration

Generate the migration for the change:

```bash
./bin/console doctrine:migrations:diff
```

And then go check it out... Wow - look at this!

[[[ code('8eb3e76abe') ]]]

Even though we called the property `genus`, it sets up the database *exactly* how
you would have normally: with a `genus_id` integer column and a foreign key. And
we did this with basically 2 lines of code.

Run the migration to celebrate!

```bash
./bin/console doctrine:migrations:migrate
```

Now, how do we actually *save* this relationship?

## Saving a Relation

Head back to `GenusController`. In `newAction()`, create a new `GenusNote` - let's
see *how* we can relate this to a `Genus`:

[[[ code('87fbaafb75') ]]]

I'll paste in some code here to set each of the normal properties - they're *all*
required in the database right now:

[[[ code('0608467d0c') ]]]

So how can we link *this* `GenusNote` to this `Genus`? Simple: `$note->setGenus()`
and pass it the entire `$genus` object:

[[[ code('f3f17b5925') ]]]

That's it. Seriously! The only tricky part is that you set the entire *object*, not
the ID. With Doctrine relations, you almost need to forget about ID's entirely: your
job is to link one object to another. When you save, Doctrine works out the details
of how this should look in the database.

Don't forget to persist the `$note`:

[[[ code('800117e8d5') ]]]

And, you can persist in *any* order: Doctrine automatically knows that it needs to insert
the `genus` first and then the `genus_note`. That's really powerful.

## Defaulting the isPublished Field

And simple! Head to the browser to check it out - `/genus/new`. Whoops - an error:
the `is_published` property cannot be null. My bad - that's totally unrelated.

In `Genus`, give the `$isPublished` field a default value of `true`:

[[[ code('9781a1ad33') ]]]

Now, if you forget to set this field - it'll default to `true` instead of `null`.

Woo! No errors this time. Check out the queries for the page. Nice! Two insert queries:
`INSERT INTO genus` and then `INSERT INTO genus_note` using 46: the new genus's ID.

With two lines to setup the relationship, and one line to link a `GenusNote` to a
`Genus`, you've got a fantastic new relationship.
