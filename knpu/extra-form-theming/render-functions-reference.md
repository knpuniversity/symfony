# Form Parts & Functions Reference

Yo peeps! It's time to jump into a topic that's actually, super fun! Yep, we're
going to learn to *bend* Symfony forms to our will: controlling *exactly* how they
render... and believe me, by the end of this course, you'll be able to render a field
in whatever *weird* way you want to.

## Grab the Course Code!

To make forms great again, let's code together! Download the code from this page
and unzip it. Inside, you'll find a trusty `start/` directory, which will hold the
exact code that I already have here.

To get the project running, open the `README.md` file and follow all the amazing
details there. The last step will be open a terminal, move into the project directory -
mine is called `aqua_note` - and then start the built-in PHP web server with:

```bash
bin/console server:run
```

Find a browser and pull up the address - `http://localhost:8000` - to find our awesome
project: Aquanote!

For this tutorial, there's just *one* thing you need to know: our database has a
*genus* table, which is a type of animal classification. That table holds a bunch
of different types of sea animals. To manage this, we have an admin section: login
with `weaverryan+1@gmail.com` and password `iliketurtles`.

The admin section lives at `/admin/genus`. Click edit and... here's our starting
form!

## Form Type Basics

And so far, our form has all the parts you'd expect: a form class: `GenusFormType`:

[[[ code('59e84c0f6d') ]]]

And a controller that builds the form and passes it into the template:

[[[ code('0636f11419') ]]]

This gives us a `genusForm` variable inside of `new.html.twig`:

[[[ code('bd0137bb0e') ]]]

But the real work is done via an included template: `_form.html.twig`:

[[[ code('86744e6ab7') ]]]

Let's start there.

## The Form Rendering Functions

The `genusForm` variable is an *object*, but you can't just print it. Instead, Symfony
gives us a bunch of form *functions*: each renders a different part of the form.

To get all the deets, head to Symfony.com. Click into the Documentation and then
find the Reference section. This holds a *wonderful* page called [Twig Template
Function and Variable Reference][twig_reference]. This lists all the functions
we'll be using *and* their arguments. Let's dive into these... and then, extend
the heck out of them.


[twig_reference]: http://symfony.com/doc/current/reference/forms/twig_reference.html
