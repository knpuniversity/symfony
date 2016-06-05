# Creating a Date Picker Field

What's the ugliest part of the form? Yeah, we all know. It's this crazy 3 drop-downs
used for the date field.

In modern times, if we need a date field, we're going to render it as a text field
and use a fancy JavaScript widget to help the user fill it in.

Head back to the list of fields. It doesn't take long to find the one that's being
guessed for the "First Discovered At" field: it's `DateType`.

Let's see if there's a way to render this as a text field instead.

## Setting widget to single_text

Check out the `widget` option:

> The basic way in which this field should be rendered.

It can be either choice - the three select fields, which is lame - 3 text fields,
or a *single* text field with `single_text`. Ah hah!

Back in the form, let's pass in `DateType::class` *even* though we could be lazy
and pass `null`. Create the array for the third argument and add `widget` set
to `single_text`:

[[[ code('f93f0eb515') ]]]

Check it out.

## HTML5 Date Types are Cool(ish)

Boom! It looks great. In fact, check this out: it *already* has some widget coolness:
with a drop-down and a nice calendar.

This is *not* coming from Symfony: it's coming from my browser. Because as soon as
we made this a `single_text` widget, Symfony rendered it as an `<input type="date">`
HTML5 field. Most browsers see this and add their own little date widget functionality.

Ready for the lame news? Not all browsers do this. And that means that users *without*
this feature will have a pretty tough time trying to figure out what date format
to pass.

## Adding a JavaScript Date Picker

Instead, let's add a proper JavaScript widget. Google for "Bootstrap Date Picker".
Ok, this first result looks pretty awesome - let's go for it!

First, we need to import new CSS and JS files. In `new.html.twig`, override the
block `stylesheets` from the base layout. Add `{% endblock %}` and print `{{ parent() }}`:

[[[ code('39fd9c03b4') ]]]

Because I'm lazy, I'll paste the URL to a CDN that hosts this CSS file:

[[[ code('a35af4c555') ]]]

But, you can download it if you want.

Do the same thing for `block javascripts`. Add `{% endblock %}` and call `parent()`:

[[[ code('269070f156') ]]]

I've got a CDN URL ready for the JavaScript file too. Go me!

[[[ code('8ddb4ab830') ]]]

## Adding a class Attribute

Next, how do we activate the plugin? According to their docs: it's pretty simple:
select the input and call `.datepicker()` on it.

Personally, whenever I want to target an element in JavaScript, I give that element
a class that starts with `js-` and use that with jQuery.

So the question is, how do we give this text field a class? You can't!

I mean you can! In 2 different ways! The first is by passing another option to the
field in the form class. Add an `attr` option to an array. And give that array
a `class` key set to `js-datepicker`:

[[[ code('045ef175dc') ]]]

## Setting up the JavaScript

Next, in our template, add the `jQuery(document.ready)` block. Hook it up with
`$('.js-datepicker').datepicker()`:

[[[ code('9e05fe1381') ]]]

Easy. Give it a try.

Scroll down and... hey! There it is! I can see the cool widget. And if I click...
um... if I click... then - why is nothing happening?

## HTML5 versus DatePicker: Fight!

It turns out, the HTML5 date functionality from my browser is *fighting* with the
date picker. Silly kids. This doesn't happen in *all* browsers, it's actually something
special to Chrome.

To fix this, we need to turn *off* the HTML5 date functionality. In other words,
we want render this as a true `<input type="text">` field, *not* a `date` field.

To do that, open the form type. There's one last option that will help us: set
`html5` to `false`:

[[[ code('d532cf8d2c') ]]]

Try it one last time. HTML5 is out of the way and the date picker is in charge.

Pretty awesome.
