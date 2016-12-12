# CollectionType: Adding New with the Prototype

So, how can we add a *new* scientist to a `Genus`?

Here's the plan: I want to add a button called "Add New Scientist", and when the
user clicks it, it will render a new blank, embedded `GenusScientist` form. After
the user fills in those fields and saves, we will insert a new record into the `genus_scientist`
table.

## The allow_add Option

Let's start with the front end first. Open `GenusFormType`. After the `allow_delete`
option, put a new one: `allow_add` set to `true`:

[[[ code('31687855f8') ]]]

Remember: `allow_delete` says:

> It's ok if one of the genus scientists' fields are missing from the submitted data.

And when one *is* missing, the form should remove it from the `genusScientists` array.

The `allow_add` option does the opposite:

> If there is suddenly an *extra* set of `GenusScientist` form data that's submitted,
> that's great!

In this case, it will create a *new* `GenusScientist` object and set it on the `genusScientists`
array.

## JavaScript Setup!

So, cool! Now open the `_form.html.twig` template. Add a link and give it a class:
`js-genus-scientist-add`. Inside, give it a little icon - `fa-plus-circle` and say
"Add Another Scientist":

[[[ code('a703948ca4') ]]]

Love it! Time to hook up the JavaScript: open `edit.html.twig`. Attach another listener
to `$wrapper`: on `click` of the `.js-genus-scientist-add` link. Add the amazing
`e.preventDefault()`:

[[[ code('b8a0f3d771') ]]]

So... what exactly are we going to do in here? We somehow need to *clone* one of
the embedded `GenusScientist` forms and insert a new, blank version onto the page.

## Using... the prototype!

No worries! Symfony's `CollectionType` has a crazy thing to help us: the `prototype`.

Google for "Symfony form collection" and open the [How to Embed a Collection of Forms][form_collections]
document on Symfony.com. This page has some code that's ripe for stealing!

First, under the "Allowing New" section, find the template and copy the `data-prototype`
attribute code. Open our form template, and add this to the wrapper `div`.
Update the variable to `genusForm.genusScientists.vars.prototype`:

[[[ code('ba192447f3') ]]]

Oh, add one other thing while we're here: I promise I'll explain all of this in
a minute: `data-index` set to `genusForm.genusScientists|length`:

[[[ code('46564b0e64') ]]]

That will count the number of embedded forms that the form has right now.

Don't touch anything else: let's refresh the page to see what this looks like...
because it's kind of crazy.

Wait, oh damn, I have three "Add New Scientist" links. Make sure your link is
*outside* of the `for` loop. This link is great... but not so great that I want
it three times. Oh, and fix the icon class too - get it together Ryan!

[[[ code('d9e936d618') ]]]

Refresh again. Much better!

## Checking out the prototype: \_\_name\_\_

View the HTML source and search for wrapper to find our `js-genus-scientist-wrapper`
element. That big mess of characters is the *prototype*. Yep, it looks *crazy*.
This is a blank version of one of these embedded forms... after being escaped with
HTML entities so that it can safely live in an attribute. This is *great*, because
we can read this in JavaScript when the user clicks "Add New Scientist".

Oh, but check out this `__name__` string: it shows up in a bunch of places inside
the prototype. Scroll down a little to the embedded `GenusScientist` forms. If
you look closely, you'll see that the fields in each of these forms have a different
index *number*. The first is index zero, and it appears in a few places, like the
`name` and `id` attributes. The next set of fields use one and then two.

When Symfony renders the `prototype`, instead of hard coding a number there - like
zero, one or two - it uses `__name__`. It then expects *us* - in JavaScript - to
change that to a unique index number, like three.

## The Prototype JavaScript

Let's do it! Back on the Symfony documentation page: a lot of the JavaScript we
need lives here. Find the `addTagForm()` function and copy the *inside* of it. Back
in `edit.html.twig`, paste this inside our click function.

And let's make some changes. First, update `$collectionHolder` to `$wrapper`: that's
the element that has the `data-prototype` attribute. We also read the `data-index`
attribute... which is important because it tells us what number to use for the
index. This is used to *replace* `__name__` with that number. And then, each time
we add another form, this index goes up by one.

Finally, at the very bottom: put this new sub-form onto the page: `$(this)` -
which is the "Add another Scientist" link, `$(this).before(newForm)`:

[[[ code('d9acc4aac0') ]]]

I think we are ready! Find your browser and refresh! Hold your breath: click
"Add Another Scientist". It works! Well, the styling isn't quite right... but hey,
this is a victory! And yea, we'll fix the styling later.

Add one new scientist, and hit save. Ah! It blows up! Obviously, we have a *little*
bit more work to do.


[form_collections]: https://symfony.com/doc/current/form/form_collections.html
