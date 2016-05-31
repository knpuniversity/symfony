# The Form Type Class

Hey guys! You're back! Awesome! Because this tutorial is all about *forms*: the
good, the bad, and the ugly.

## Quit Hatin' on the Forms

The truth is: the form component is super controversial: some people love it, some
people hate it - and a lot of people have trouble learning it. In fact, its documentation
on [symfony.com][1] is read far more than any other section.

Why? Because honestly, it *is* complex - too complex sometimes. But you know what?
The form component is going to allow you to get a *lot* of work done really quickly.
And when I *do* see someone suffering with forms, most of the time, it's their fault.
They create situations that are far more complicated than they need to be.

So let's *not* do that - let's *enjoy* forms, and turn them into a weapon.

## ~~Sing Along~~ Code along!

Ok, you guys know the drill: download the course code and unzip it to code along
with me. Inside, you'll find the answers to life's questions and a `start/` directory
that has the same code I have here. Make sure to check out the README for all the
setup details.

Once you're ready, start the built-in web server with:

```bash
./bin/console server:run
```

I made a *few* changes to the site since last time. For example, go to `localhost:8000/genus`.
It looks the same, but see the "Sub Family"? Before, that was a string field
on `Genus`. But now, I've added a `SubFamily` entity:

[[[ code('d7d4af4d29') ]]]

And created a `ManyToOne` relation from `Genus` to `SubFamily`:

[[[ code('36f9015ab4') ]]]

So every `Genus` belongs to one `SubFamily`.

I also started a new admin section - see it at `/admin/genus`. But, it needs some
work - like the ability to add a *new* genus. That'll be our job. And the code will
live in the new `GenusAdminController`.

## Creating a new Form

To create a form, you'll add a class where you'll *describe* what the form
looks like.

***TIP
Actually, you can build a form directly in the controller if you want to.
***

In PhpStorm, select anywhere in your bundle and press `command`+`N`, or right click
and select "New". Find "Form" and call it `GenusFormType`:

[[[ code('293d653c0b') ]]]

Cool! This just gave us a basic skeleton and put the class in a `Form` directory. Sensible!
These classes are called "form types"... which is the worst name that we could come
up with when the system was created. Sorry. Really, these classes are "form recipes".

Here's how it works: in `buildForm()`: start adding fields: `$builder->add()` and
then `name` to create a "name" field:

[[[ code('aac004dc25') ]]]

Keep going: `add('speciesCount')` and `add('funFact')`:

[[[ code('146764de98') ]]]

Right now, those field names can be anything - you'll see why in a second.

And that's it! The form is built after writing about 4 lines of code! Let's go
render it!


[1]: https://symfony.com
