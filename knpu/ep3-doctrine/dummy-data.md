# Fixtures: Dummy Data Rocks

It's *so* much more fun to develop when your database has real, interesting data.
We *do* have a way to add some fake genuses into the database, but they're not very
interesting. And when we need more dummy data - like users and genus notes -
it's just not going to work well.

Nope - we can do better. I'm dreaming of a system where we can quickly re-populate
our local database with a really *rich* set of fake data, or *fixtures*.

Search for `DoctrineFixturesBundle`. This bundle is step 1 towards my dream. Copy
the `composer require` line and paste that into the terminal. But hold on! I *also*
want to download something else: `nelmio/alice`. That's just a normal PHP library,
not a bundle. And it's going to make our fixtures amazing:

```bash
composer require --dev doctrine/doctrine-fixtures-bundle nelmio/alice
```

## Conditionally Load Dev Libraries

Oh, and the `--dev` flag isn't too important. It means that these lines will be added
to the `require-dev` section of `composer.json`:

[[[ code('92b38cf055') ]]]

And that's meant for libraries that are only needed for development or to run tests.

When you deploy - if you care enough - you can tell composer to *not* download the libraries
in this section. But frankly, I don't bother.

While Composer is communicating with the mothership, copy the `new` bundle line and
add it to `AppKernel`. But put it in the section that's inside of the `dev` `if`
statement:

[[[ code('4fc938eff2') ]]]

This makes the bundle - and any services, commands, etc that it gives us - *not* available
in the `prod` environment. That's fine for us - this is a development tool - and it keeps
the `prod` environment a little smaller.

## Creating the Fixture Class

Anyways, this bundle gives us a new console command - `doctrine:fixtures:load`. When
we run that, it'll look for "fixture classes" and run them. And in those classes,
we'll create dummy data.

Copy the example fixture class. In AppBundle, add a `DataFixtures/ORM` directory.
Then, add a new PHP class called - well, it doesn't matter - how about `LoadFixtures`.
Paste the example class we so aggressively stole from the docs and update its class
name to be `LoadFixtures`:

[[[ code('9a6bf8b617') ]]]

Clear out that `User` code. We need to create Genuses.. and we have some perfectly
good code in `newAction()` we can steal to do that. Paste that it:

[[[ code('df5d38b45f') ]]]

The `$manager` argument passed to this function is the entity manager. Use it
to persist `$genus` and don't forget the `Genus` `use` statement. Oh, and only
one namespace - whoops!

I know this is *not* very interesting yet - stay with me. To run this, head over
to the terminal and run:

```bash
./bin/console doctrine:fixtures:load
```

This clears out the database and runs all of our fixture classes - we only have 1.
Now, head back to the list page. Here is our *one* random genus. So it's kind of
cool... but I know - totally underwhelming. Enter Alice: she makes fixtures fun
again.
