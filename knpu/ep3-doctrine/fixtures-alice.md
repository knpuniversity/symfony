# Delightful Dummy Data with Alice

Now things are about to get fun. A few minutes ago, we installed a library called
[nelmio/alice][1] - search for that and find their GitHub page.

In a nutshell, this library lets us add fixtures data via YAML files. It has an expressive
syntax *and* it ships with a bunch of built-in functions for generating random data.
Actually, *it* uses yet *another* library behind the scenes called [Faker][2] to do that.
It's the PHP circle of life!

## Creating the Fixture YAML File

Find the ORM directory and create a new file called - how about `fixtures.yml`. That
filename lacks excitement, but at least it's clear.

Start with the class name you want to create - `AppBundle\Entity\Genus`. Next, each
genus needs an internal, unique name - it could be anything. But wait! Finish the
name with `1..10`:

[[[ code('381b3f0ad2') ]]]

With this syntax, Alice will loop over and create *10* Genus objects for free. Boom!

To finish things, set values on each of the Genus properties: `name: <name()>`. You
could just put any value here, but when use `<>`, you're calling a built-in *Faker*
function. Next, use `subFamily: <text(20)>` to generate 20 characters of random text,
`speciesCount: <numberBetween(100, 100000)>` and `funFact: <sentence()>`:

[[[ code('dc58bfad9e') ]]]

That's it team! To *load* this file, open up `LoadFixtures` and remove all of that
boring garbage. Replace it with `Fixtures` - autocomplete that to get the `use` statement -
then `::load()`. Pass this `__DIR__.'/fixtures.yml'` and then the entity manager:

[[[ code('f2da83379b') ]]]

Now, run the *exact* command as before:

```bash
./bin/console doctrine:fixtures:load
```

I *love* when there are no errors. Refresh the list page. Voila: 10 completely random
genuses. I *love* Alice.

## All The Faker Functions

Well.... the genus name is actually the name of a person... which is pretty ridiculous.
Let's fix that in a second.

But first, Nelmio's documentation has a *ton* of cool examples of things you can
do with this library. But the *biggest* things you'll want to check out is the *Faker*
library that this integrates.  This shows you *all* of the built-in functions we
were just using - like `numberBetween`, `word`, `sentence` and a ton more. There
is some *great* stuff in here.

Now if we can *just* make the genus name a little more realistic.


[1]: https://github.com/nelmio/alice
[2]: https://github.com/fzaninotto/Faker
