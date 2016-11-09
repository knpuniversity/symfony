# Give me Clean URL Strings (slugs!)

Yes! Collections! Ladies and gentleman, this course is going to take us somewhere
special: to the center of *two* topics that each, single-handedly, have the power
to make you hate Doctrine and hate Symfony forms. Seriously, Doctrine and the form
system are probably the two most *powerful* things included in the Symfony Framework...
and yet... they're also the two parts that drive people insane! How can that be!?

The answer: collections. Like, when you have a database relationship where one
Category is related to a collection of Products. And for forms, it's how you build
a form where you can edit that category and add, remove or edit the related products
all from one screen. If I may, it's a collection of chaos.

But! But, but but! I have good news: if we can understand just a *few* important
concepts, Doctrine collections are going to fall into place beautifully. So let's
take this collection of chaos and turn it into a collection of.. um... something awesome...
like, a collection of chocolate, or ice cream. Let's do it!

## Code and Setup!

You should *definitely* code along with me by downloading the course code from this
page, unzipping it, and then finding the `start/` directory. And don't forget to
also pour yourself a fresh cup of coffee or tea: you deserve it.

That `start/` directory will have the exact code that you see here. Follow the instructions
in the `README.md` file: it will get your project setup.

The last step will be to open a terminal, move into the directory, and start the
built-in PHP web server with:

```bash
./bin/console server:run
```

Now, head to your browser and go to `http://localhost:8000` to pull up our app:
Aquanote! Head to `/genus`: this lists all of the *genuses* in the system, which
is a type of animal classification.

***TIP
The plural form of genus is actually *genera*. But irregular plural words like
this can make your code a bit harder to read, and don't work well with some of
the tools we'll be using. Hence, we use the simpler, genuses.
***

## Clean, Unique URLs

Before we dive into collection stuff, I *need* to show you something else first.
Don't worry, it's cool. Click one of the genuses. Now, check out the URL: we're
using the *name* in the URL to identify this genus. But this has two problems. First,
well, it's kind of ugly: I don't really like upper case URLs, and if a genus had
a *space* in it, this would look *really* ugly - nobody likes looking at `%20`. Second,
the name might not be unique! At least while we're developing, we might have two
genuses with the same name - like `Aurelia`. If you click the second one... well,
this is actually showing me the *first*: our query *always* finds only the first
Genus matching this name.

How could I let this happen!? Honestly, it was a shortcut: I wanted to focus on more
important things before. But now, it's time to right this wrong.

What we really need is a clean, unique version of the name in the url. This is commonly
called a *slug*. No, no, not the slimy animal - it's just a unique name.

## Create the slug Field

How can we create a slug? First, open the `Genus` entity and add a new property
called `slug`:

[[[ code('ec1cb901c0') ]]]

We *will* store this in the database like any other field. The only difference is
that we'll force it to be unique in the database.

Next, go to the bottom and use the "Code"->"Generate" menu, or `Command`+`N` on a
Mac, to generate the getter and setter for `slug`:

[[[ code('c92046358e') ]]]

Finally, as always, generate a migration. I'll open a new terminal tab, and run:

```bash
./bin/console doctrine:migrations:diff
```

Open that file to make sure it looks right:

[[[ code('b20aa65e82') ]]]

Perfect! It adds a column, and gives it a unique index. Run it:

```bash
./bin/console doctrine:migrations:migrate
```

## Ah, Migration Failed!

Oh no! It failed! Why!? Since we *already* have genuses in the database, when we try
to add this new column... which should be unique... every genus is given the same,
blank string. If we had already deployed this app to production, we would need to
do a bit more work, like make the slug field *not* unique at first, write a migration
to generate all of the slugs, and *then* make it unique.

Fortunately we haven't deployed this yet, so let's take the easy road. Drop the
database:

```bash
./bin/console doctrine:database:drop --force
```

Then recreate it, and run all of the migrations from the beginning:

```bash
./bin/console doctrine:database:create
./bin/console doctrine:migrations:migrate
```

Much better. So.... how do we actually set the `slug` field for each `Genus`?
