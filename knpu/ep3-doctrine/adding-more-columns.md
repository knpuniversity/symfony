# Adding More Columns

We're *close* to making the genus page dynamic - but it has a few fields that we don't
have yet - like sub family, number of known species, and fun fact.

Let's add these... and be as lazy as possible when we do it! In `Genus`, create the
properties first: `private $subFamily`, `private $speciesCount` and `private $funFact`:

[[[ code('5b32a32f16') ]]]

Now, just do the same thing we did before: bring up the "Code"->"Generate" menu - or
`command`+`N` on a Mac - select "ORM Annotation" and choose all the fields to generate
the `Column` annotations above each:

[[[ code('c11cef2b5c') ]]]

These tries to *guess* the right field type - but it's not always right. `speciesCount`
should clearly be an integer - set it to that. For a full-list of *all* the built-in
Doctrine types, check their docs. The most important are `string`, `integer`, `text`,
`datetime` and `float`.

Next, head to the bottom of the class to create the getter and setter methods. But
wait! Realize: you might *not* need getters and setters for *every* field, so only
add them if you need them. We *will* need them, so open "Code"->"Generate" again and
select "Getters and Setters":

[[[ code('3151be6a5a') ]]]

And that's it! Create the properties, generate the annotations and generate the getters
and setters if you need them.

## Updating the Table Schema

Now, can we tell Doctrine to somehow *alter* the `genus` table and add these columns?
Absolutely. In fact, it's one of the most *incredible* features of Doctrine.

In the terminal, run:

```bash
./bin/console doctrine:schema:update --dump-sql
```

Look familiar? That's the *same* command we ran before. But look: it actually
says, "ALTER TABLE genus" add `sub_family`, `species_count`, and `fun_fact`.
This is *amazing*. It's able to look at the database, look at the entity, and
calculating the *difference* between them.

So if we were to run this with `--force`, it would run that query and life would
be good. Should we do it? No! Wait, hold on!

It *would* work. But imagine our app was *already* deployed and working
on production with the first version of the `genus` table. When you deploy the new
code, you'll need to run this command on production to update your table.

And that'll work 99% of the time. But sometimes, the query might not be perfect.
For example, what if I rename a property? Well, this command might *drop* the existing
column and add a new one. All the data from the old column would be gone! The point
is: running `doctrine:schema:update` is just *too* dangerous on production.

But, we're going to replace it with something *just* as good.
