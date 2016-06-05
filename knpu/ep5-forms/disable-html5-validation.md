# Disable HTML5 Validation

Leave everything blank and hit save.

Oh, it doesn't submit. Instead we get this validation error. So where's that coming
from?

## The Famous required Attribute

Hint: it's not Symfony!. It's our friend HTML5. When Symfony renders the field, it's
adding a `required="required"` attribute, and this activates HTML5 validation.

But, there are a few problems with this. First, Symfony always adds the `required`
attribute... even if it's not actually required in the database. It'a a borderline
bug in Symfony.

And actually, that's not totally fair. If you use field-type-guessing, Symfony *will*
guess whether or not it should render this by looking at your database and validation
config. But as soon as you set your field type, it stops doing that. Boo!

Here's the second problem: even if we like this HTML5 client-side validation, we
still need to add true server-side validation. Otherwise, nasty users can go crazy
on our site.

## Disable HTML5 Validation

So here's what I do: I disable HTML5 validation and rely purely on server-side validation.

If you *do* want some fancy client-side validation, I recommend adding it with a
JavaScript library. These give you more features and control than HTML5 validation.

There's even a bundle - [JsFormValidatorBundle][1] - that can dump your server-side
rules into JavaScript.

So how do we disable HTML5 validation? Very simple: find the submit button and add
`formnovalidate`:

[[[ code('f773dd7355') ]]]

That's it. Refresh the page now and submit. No more HTML5 validation. But of course
now, we need server-side validation!


[1]: https://github.com/formapro/JsFormValidatorBundle
