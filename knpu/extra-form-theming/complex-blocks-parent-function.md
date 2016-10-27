# Complex Blocks & the parent() Function

We've just added an X glyphicon to *every* field that has an error...

[[[ code('1240299936') ]]]

And then found out that we *really* only want to add this to input fields.

How can we do that? I know that this is a *text* type. So maybe, instead of adding
the icon to `form_row`, we could override the `text_widget` block and add it there.
That would *only* affect text fields.

Go into `form_div_layout.html.twig` and look for `text_widget`. Woh! It's not here!
That means Symfony must be using `form_widget`. That block *does* exist:

[[[ code('177f085fc6') ]]]

Remember that `compound` variable I refused to explain before. Well, here it is again!
We normally think of a field as just, well, a field: like a text box, or a select
element. But sometimes, a field is actually a collection of *sub-fields*. An easy
example is Symfony's `DateType`, which by default renders as 3 select elements for
year, month and day. In that case, the `DateType` is said to be *compound*: it's
just a wrapper for its three child fields.

In our form, all of our fields right now are simple: so, *not* compound. The `block()`
function says:

> Hey! Go render this other block called `form_widget_simple`.

After following all of this, it turns out that if we want to override the text widget,
we need to override `form_widget_simple`:

[[[ code('da2aabb15f') ]]]

In fact, *all* input fields - like the number field, search field or URL field - use
this same block.

Ok, let's override it! But wait - check to see if it's in the Bootstrap template first:

[[[ code('e7947dad04') ]]]

It is! Copy that version, and paste it into `_formTheme.html.twig`.

## The Craziness of Twig in Form Themes

Now, check out this logic: form theme templates will have some of the *craziest*
Twig code you'll ever see! In normal words, this says:

> If type is not defined or file does not equal type, add a new `form-control` class.

To make this happen, it uses the `attr` variable that we were playing with before
and *merges* in the new class, adding a space in case there was already a class.

## Stealing Parent Blocks with use

Before *we* make any changes, go back and refresh. Woh! It doesn't work - that's
surprising. The problem is this `parent()` call:

[[[ code('71b3075b19') ]]]

We understand that in normal Twig templates, you can override parent blocks and use
the `parent()` function. But check this out: our template does *not* extend any Twig
template... and we don't want it to! For reasons that honestly aren't very important,
a form theme template should never extend anything.

But wait, then, how did this code work in the Bootstrap template? Go look: at the
top, it has a `use` for `form_div_layout.html.twig`:

[[[ code('770933a507') ]]]

The `use` says:

> I don't *actually* want to extend this other template. But, please allow me
> to call the parent() function as *if* I were extending it.

The `use` statement is an awesome Twig feature that allows you to just, grab and
use random blocks from a different template. It's advanced, but now it's in your
toolkit! Go you!

At the top of our template, `use 'bootstrap_3_layout.html.twig'`:

[[[ code('95913f133e') ]]]

And as soon as we do that, life is good.

And actually, we don't need this logic anymore: that's done in the parent() block:

[[[ code('e4fc79298e') ]]]

If you refresh, everything still looks great.

## The Error Icon in the Widget

Finally, we can move the icon to this block. First, keep that `showErrorIcon` variable:
we need that to add the `has-feedback` class. But copy it and move it down into
`form_widget_simple`, inside the `if` statement... because, it turns out, we probably
also don't want to show the error icon if this is a file upload field:

[[[ code('3be7dc97d0') ]]]

Above, set `showErrorIcon` to `false` by default:

[[[ code('f2af17f51b') ]]]

Finally, copy the span icon code, remove it, and paste it right *after* the parent
call, to put this *after* the widget.

That should do it! Resubmit the form! Got it! One fancy error icon on the name text
field, and zero fancy error icons on the select field.

In a nutshell, form theming means:
* (A) finding the right block to override and then;
* (B) leveraging your variables to do cool stuff.

Next, we'll add a missing feature to Symfony: field help text.
