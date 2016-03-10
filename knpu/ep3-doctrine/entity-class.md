# Creating an Entity Class

Yo guys! Time to level-up our project in a *big* way. I mean, *big*. This series
is *all* about an incredible library called Dog-trine. Wait, that's not right - it's
*Doctrine*. But anyways, Doctrine is *kinda* like a dog: a dog fetches a bone, Doctrine
fetches data from the database. But Doctrine does *not* pee in the house. That's
part of what makes it awesome.

But back up: is Doctrine part of Symfony? Nope. Symfony doesn't care *how* or *if*
you talk to a database at all. You could use a direct PDO connection, use Doctrine,
or do something else entirely. As usual, you're in control.

If you want to code along - which you *should* - then download the code from the
screencast page and move into the directory called `start`. I already have the `start`
code downloaded, so I'll go straight to opening up a new terminal and starting the
built-in sever with:

```bash
./bin/console server:run
```

Perfect!

## Doctrine is an ORM

Doctrine is an ORM: object relational mapper. In short, that means that every table -
like `genus` - will have a corresponding PHP class that we will create. When you query
the `genus` table, Doctrine will give you a `Genus` object. Every property in the
class maps to a column in the table. Keep this simple idea in mind as we go along:
this mapping between a table and a PHP class is Doctrine's main goal.

Oh, and before we hop in, I want you to remember something very important: all the tools
in Symfony are *optional*, including Doctrine. If Doctrine - or any tool - does more
harm than good while solving a problem, skip it and do something simpler. Tools are
meant to serve *you*, not the other way around.

## Your First Entity Class

Our sweet app displays information about different ocean-living genuses... but so
far, all that info is hardcoded. That's so sad.

Instead, let's create a `genus` table in the database and load all of this dynamically
from there. How do you create a database table with Doctrine? You don't! Your job
is to create a class, then Doctrine will create the table *based* on that class.
It's pretty sweet. Oh, and the *whole* setup is going to take about 2 minutes and
25 lines of code. Watch.

Create an `Entity` directory in `AppBundle` and then create a normal class inside
called `Genus`:

[[[ code('615448c4a0') ]]]

You're going to hear this word - *entity* - a lot with Doctrine. Entity - it sounds
like an alien parasite. Fortunately, it's less scary than that: an entity is just
a class that Doctrine will map to a database table.

## Configuration with... Annotations!

To do that - Doctrine needs to know two things: what the table should be called and
what columns it needs. To help it out, we're going to use... drumroll... annotations!
Remember, whenever you use an annotation, you need a `use` statement for it. This
will look weird, but add a `use` for a `Column` class and let it auto-complete from
`Doctrine\ORM\Mapping`. Remove the `Column` part and add `as ORM`:

[[[ code('e0bcac15b4') ]]]

***TIP
You can also configure Doctrine with YAML, XML or PHP, instead of annotations. Check
[Add Mapping Information][1] to see how to configure it.
***

Every entity class will have that *same* `use` statement. Next, put your cursor inside
the class and open up the "Code"->"Generate" menu - `cmd`+`N` on a Mac. Ooh, one of the options
is `ORM Class`. Click that... and boom! It adds two annotations - `@ORM\Entity` and
`@ORM\Table` above the class:

[[[ code('5298ae9b7d') ]]]

Doctrine now knows this class should map to a table called `genus`.

## Configuring the Columns

But that table won't have *any* columns yet. Lame. Add two properties to get us rolling:
`id` and `name`. To tell Doctrine that these should map to columns, open up the
"Code"->"Generate" menu again - or `cmd`+`N`. This time, select `ORM Annotation` and
highlight both properties. And, boom again!

[[[ code('e4bb6964fb') ]]]

Now we have annotations above each property. The `id` columns is special - it will
almost always look exactly like this: it basically says that `id` is the primary
key.

After that, you'll have whatever other columns you need. Hey, look at the `type`
option that's set to `string`. That's a Doctrine "type", and it will map to a `varchar`
in MySQL. There are other Doctrine types for strings, floats and text - we'll talk
about those soon! 

And with just 25 lines of code, we're done! In a second, we'll ask Doctrine to create
the `genus `table for us and we'll be ready to start saving stuff. Well, let's get
to it!


[1]: http://symfony.com/doc/current/book/doctrine.html#add-mapping-information
