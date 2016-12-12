# Collection Delete & allow_delete

Right now, this `Genus` is related to four GenusScientists. Cool... but what if one
of those users *stopped* studying the `Genus` - how could we *remove* that one?

## The Delete UI & JavaScript

Let's plan out the UI first: I want to be able click a little x icon next to each
embedded form to make it disappear from the page. Then, when we submit, it should
fully delete that `GenusScientist` record from the database. Cool?

Inside the embedded form, add a new class to the column: `js-genus-scientist-item`:

[[[ code('bd88691ca1') ]]]

We'll use that in JavaScript in a second. Below that, add a little link with its
own `js-remove-scientist` class... and put the cute little "x" icon inside:

[[[ code('045a29e41b') ]]]

Brilliant!

Time to hook up some JavaScript! Since this template is included by `edit.html.twig`
and `new.html.twig`, I can't override the `javascripts` block from here. Instead,
open `edit.html.twig` and override the block `javascripts` there:

[[[ code('3e57548df8') ]]]

We'll worry about adding JS to the new template later.

Start with the always-exciting `document.ready` function:

[[[ code('b006ed8de1') ]]]

Oh, but back in `_form.html.twig`, add one more class to the row that's around the
entire section called `js-genus-scientist-wrapper`:

[[[ code('e3a9b7c92c') ]]]

Ok, back to the JavaScript! Add `var $wrapper = ` then use `jQuery` to select that
wrapper element. Register a listener on `click` for any `.js-remove-scientist`
element - that's the delete link. Start that function with my favorite `e.preventDefault()`:

[[[ code('01ba512661') ]]]

Then... what next? Well, forget about Symfony and the database: just find the
`.js-genus-scientist-item` element that's around this link and... remove it!

[[[ code('bc3b8dc949') ]]]

Simple! Refresh the page, click that "x", and be amazed.

## Missing Fields: The allow_delete Option

But this is superficial: it didn't delete anything from the database nor can we submit
the form and expect something to magically delete this `GenusScientist`, *just* because
we removed it from the page. Or can we?

Submit! Well, I guess not. Huge error from the database!

> UPDATE genus_scientist SET years_studied and user_id to null.

Hmm. So our form is *not* expecting this embedded form to simply disappear. Instead,
because the fields are missing from the submitted data, it thinks that we want
to set that Genus Scientist's `yearsStudied` and `user` fields to null! No! I want
to *delete* that entire object from the database!

How can we do that? First, in `GenusFormType`, we need to tell the `genusScientists`
field that it's *ok* if one of the embedded form's fields is missing from the submit.
Set a new `allow_delete` option to `true`:

[[[ code('bbc07c21f5') ]]]

This tells the `CollectionType` that it's *ok* if one of the `GenusScientist` forms
is missing when we submit. *And*, if a `GenusScientist` form is missing, it should
remove that `GenusScientist` from the `genusScientists` array property. In other
words, when we remove a `GenusScientist` form and submit, the final array will have
*three* `GenusScientist` objects in it, instead of four.

Ready? Submit!

Hmm, no error... but it still doesn't work. Why not? Hint: we already know the
answer... and it relates to Doctrine's inverse relationships. Let's fix it.
