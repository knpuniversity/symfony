# JoinColumn & Relations in Fixtures

Is the relationship *required* in the database? I mean, could I save a `GenusNote`
*without* setting a `Genus` on it? Actually, I could! Unlike a normal column, relationship
columns - for whatever reason - are *optional* by default. But does it make sense
to allow a `GenusNote` without a `Genus`? No! That's crazy talk! Let's prevent it.

Find the `ManyToOne` annotation and add a *new* annotation below it: `JoinColumn`.
Inside, set `nullable=false`:

[[[ code('bb984a579e') ]]]

The `JoinColumn` annotation controls how the foreign key looks in the database.
And obviously, it's optional. Another option is `onDelete`: that literally
changes the `ON DELETE` behavior in your database - the default is `RESTRICT`,
but you can also use `CASCADE` or `SET NULL`.

Anyways, we just made a schema change - so time to generate a migration!

```bash
./bin/console doctrine:migrations:diff
```

This time, I'll be lazy and trust that it's correct. Run it!

```bash
./bin/console doctrine:migrations:migrate
```

## When Migrations Go Wrong

Ah, it explodes! Null value not allowed? Why? Think about what's happening: we have
a bunch of *existing* `GenusNote` rows in the database, and each still has a `null`
`genus_id`. We can't set that column to `NOT NULL` because of the data that's already
in the database.

If the app were already deployed to production, we would need to fix the migration:
maybe UPDATE each existing `genus_note` and set the `genus_id` to the first `genus`
in the table.

But, alas! We haven't deployed to production yet: so there isn't any existing production
database that we'll need to migrate. Instead, just start from scratch: drop the
database completely, re-create it, and re-migrate from the beginning:

```bash
./bin/console doctrine:database:drop --force
```
```bash
./bin/console doctrine:database:create
```
```bash
./bin/console doctrine:migrations:migrate
```

Phew! Now it works great.

## Relations in Fixtures

Last step! Our fixtures are broken: we need to associate each `GenusNote` with a
`Genus`. We know how to set normal properties, like `username` and `userAvatarFilename`.
But how can we set relations? As usual with Alice: it's *so* nice. Use `genus: @`
then the internal name of one of the 10 genuses - like `genus_1`. That's it!

But, you know what? That's not awesome enough. I *really* want this to be a *random*
Genus. Ok: change that `genus_1` to `genus_*`:

[[[ code('452aacf257') ]]]

Alice will now look at the 10 Genus objects matching this pattern and select
a random one each time.

Reload the fixtures:

```bash
./bin/console doctrine:fixtures:load
```

It's alive! Check out the results again with `doctrine:query:sql`:

```bash
./bin/console doctrine:query:sql 'SELECT * FROM genus_note'
```

Every single one has a random genus. Do you love it? I love it.
