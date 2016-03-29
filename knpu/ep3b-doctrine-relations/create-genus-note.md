# Create Genus Note

It's you again! Welcome back friend! In this tutorial, we're diving back into
Doctrine: this time to master database relations. And to have fun of course - databases
are *super* fun.

Like usual, you should code along with me or risk 7 years of bad luck. Sorry.
To do that, download the code from the course page and use the `start` directory.
I already have the code - so I'll startup our fancy, built-in web server:

```bash
./bin/console server:run
```

You may also need to run `composer install` and a few other tasks. Check the
README in the download for those details.

When you're ready, pull up the genus list page at `http://localhost:8000/genus`.
Nice!

## Create the GenusNote Entity

Click to view a specific genus. See these notes down here? These are loaded via
a ReactJS app that talks to our app like an API. But, the notes themselves are
still hardcoded right in a controller. Bummer! Time to make them dynamic - time to
create a second database table to store genus notes.

To do that, create a new `GenusNote` class in the `Entity` directory. Copy the ORM
`use` statement from `Genus` that all entities need and paste it here:

[[[ code('2a257e7e37') ]]]

With that, open the "Code"->"Generate" menu - or `Cmd` + `N` on a Mac - and select
"ORM Class":

[[[ code('64be433559') ]]]

Bam! This is now an entity!

Next: add the properties we need. Let's see... we need a `username`, an `userAvatarFilename`,
`notes` and a `createdAt` property:

[[[ code('2193da2bf1') ]]]

When we add a user table later - we'll replace `username` with a relationship to that table.
But for now, keep it simple.

Open the "Code"->"Generate" menu again and select "ORM Annotation". Make sure each
field `type` looks right. Hmm, we probably want to change `$note` to be a `text`
type - that type can hold a lot more than the normal 255 characters:

[[[ code('bf4a5616a8') ]]]

Finally, go back to our best friend - the "Code"->"Generate" menu - and generate the
getter and setters for every field - except for `id`. You don't usually want to
set the `id`, but generate a getter for it:

[[[ code('1e81ac012d') ]]]

### Generate Migrations

Entity done! Well, *almost* done - we still need to somehow *relate* each `GenusNote`
to a `Genus`. We'll handle that in a second.

But first, don't forget to generate a migration for the new table:

```bash
./bin/console doctrine:migrations:diff
```

Open up that file to make sure it looks right - it lives in `app/DoctrineMigrations`.
`CREATE TABLE genus_note` - it looks great! Head back to the console and run the
migration:

```bash
./bin/console doctrine:migrations:migrate
```

## Adding Fixtures

Man, that was *easy*. We'll want some good dummy notes too. Open up the `fixtures.yml`
file and add a new section for `AppBundle\Entity\GenusNote`. Start just like before:
`genus.note_` and - let's create 100 notes - so use `1..100`:

[[[ code('1f82953ada') ]]]

Next, fill in each property using the Faker functions: `username: <username()>` and
then `userAvatarFilename:` Ok, eventually users might upload their *own* avatars,
but for now, we have two hardcoded options: `leanna.jpeg` and `ryan.jpeg`. Let's select
one of these randomly with a sweet syntax: `50%? leanna.jpeg : ryan.jpeg`. That's Alice
awesomeness:

[[[ code('78b13d3970') ]]]

The rest are easy: `note: <paragraph()>` and `createdAt: <dateTimeBetween('-6 months', 'now')>`:

[[[ code('4150db33cf') ]]]

Ok, run the fixtures!

```bash
./bin/console doctrine:fixtures:load
```

Double-check them with a query:

```bash
./bin/console doctrine:query:sql 'SELECT * FROM genus_note'
```

So awesome! Ok team, we have two entities: let's add a relationship!
