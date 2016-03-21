# Database Migrations

Google for `DoctrineMigrationsBundle`. To install it, copy the `composer require`
line. But again, we don't need to have the version - Composer will find the best
version for us:

```bash
composer require doctrine/doctrine-migrations-bundle
```

While Jordi is preparing that for us, let's keep busy. Copy the `new` statement from
the docs and paste that into the `AppKernel` class:

[[[ code('f7cad0761a') ]]]

Beautiful!

We already know that the *main* job of a bundle is to give us new services. But this
bundle primarily gives us something different: a new set of console commands. Run
`bin/console` with no arguments:

```bash
./bin/console
```

Hiding in the middle is a whole group starting with `doctrine:migrations`. These
are our new best friend.

## The Migrations Workflow

Our goal is to find a way to *safely* update our database schema both locally *and*
on production.

To do this right, drop the database entirely to remove all the tables: like we have
a new project.

```bash
./bin/console doctrine:database:drop --force
```

This is the *only* time you'll need to do this. Now, re-create the database:

```bash
./bin/console doctrine:database:create
```

Now, instead of running `doctrine:schema:update`, run:

```bash
./bin/console doctrine:migrations:diff
```

This created a new file in `app/DoctrineMigrations`. Go open that up:

[[[ code('322923f8bb') ]]]

Check this out: the `up()` method executes the *exact* SQL that we would have gotten
from the `doctrine:schema:update` command. But instead of running it, it saves it
into this file. This is *our* chance to look at it and make sure it's perfect.

When you're ready, run the migration with:

```bash
./bin/console doctrine:migrations:migrate
```

Done! Obviously, when you deploy, you'll *also* run this command. But here's the
*really* cool part: this command will *only* run the migration files that have *not*
been executed before. Behind the scenes, this bundle creates a `migrations_versions`
table that keep strack of which migration files it has already executed. This means
you can safely run `doctrine:migrations:migrate` on every deploy: the bundle will
take care of only running the new files.

***TIP
You *can* run migration in reverse in case something fails. Personally, I never
do this and I never worry about `down()` being correct. If you have a migration
failure, it's a bad thing and it's better to diagnose and fix it manually.
***

## Making Columns nullable

In `newAction()`, I'll add some code that sets fake data on the `subFamily`
and `speciesCount` properties. But, I'll keep `funFact` blank: maybe some genuses just aren't
very fun:

[[[ code('d1c1ecb635') ]]]

Ok, head over to `/genus/new` to try it out! Woh, a huge explosion!

> Integrity constraint violation: 1048 Column `fun_fact` cannot be null

Here's the deal: Doctrine configures *all* columns to be required in the database
by default. If you *do* want a column to be "nullable", find the column and add
`nullable=true`:

[[[ code('254f35a53c') ]]]

## Creating Another Migration

Of course, just because we made this change doesn't mean that our table was automatically
updated behind the scenes. Nope: we need another migration. No problem! Go back to
the terminal and run:

```bash
./bin/console doctrine:migrations:diff
```

Open up the new migration file: `ALTER TABLE genus CHANGE fun_fact` to have a default
of `null`. This look perfect. Run it with:

```bash
./bin/console doctrine:migrations:migrate
```

So easy! Refresh the page again: *no* errors. Migrations are awesome.
