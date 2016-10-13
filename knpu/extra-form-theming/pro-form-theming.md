# Pro Form Theming

Remove that dump. Then refresh to look at our nice, normal form. In the template,
all we do is call `form_row()` and then - magically - a whole lot of markup is
printed onto the page. So here's the million dollar question: where the heck is
that markup coming from? I mean, *somewhere* deep in the core of Symfony, there must
be a file that decides what the HTML for an `input` field is, or what markup to use
when printing errors? So, where is that?

## The King of Form Markup: form_div_layout.html.twig

The answer: a *single* file that - indeed - lives in the deepest, darkest corners
of Symfony. I'll use the Navigate->File shortcut to look for `form_div_layout.html.twig`:

[[[ code('1dca7bd406') ]]]

This is probably the *weirdest* Twig template you'll ever see. It defines a bunch
of blocks that, together, contain *every* little bit or markup that's used for
*any* part of a form.

And here's how it works: when you render a piece of your form, Symfony opens this
template looks for a specific block, which varies depending on *what* you're rendering,
and then renders *just* that block to get that *one* little part of your form.

For example, when you render the *widget* for a `TextareaType` field, it looks for
a block called `textarea_widget` and executes *just* its code:

[[[ code('cf4c54e75f') ]]]

Symfony never renders this *whole* template at once, just each block, as it needs them.
It's almost like a list of small functions, where each function, or block, renders
just a small part of the form.

## The Bootstramp Theme

But in reality, not all of *our* markup is coming from this one file. In an
[earlier tutorial][symfony_forms], we started using the Bootstrap form *theme*.
Open `app/config/config.yml` and find the `twig.form_themes` key:

[[[ code('4e82d0c21c') ]]]

By adding `bootstrap_3_layout.html.twig`, we told Symfony to *also* look at this
template, which again, lives deep dark in the core, black heart of Symfony.
I'm kidding - the core is cool.

[[[ code('ce1fb3d574') ]]]

This template overrides some blocks from `form_div_layout.html.twig`. For example,
`form_widget_simple` in the bootstrap templates *overrides* the other one. It
adds an extra `form-control` class.

## Decrypting the Block Names

You see, there's a trick to these block names. There are three parts to every field:
the label, the widget and the error. Well, *four* parts if you also count the "row".

And, every field has a type, like the entity type, the choice type or - for the name
field - the text type:

[[[ code('7c2fe4bd2e') ]]]

To render the *widget* for a *text* type, Symfony looks for a block called `text_widget`.
Or, to render the widget for a textarea type, Symfony uses `textarea_widget`, which
looks exactly like we'd expect!

[[[ code('f6dc5b1894') ]]]

What about rendering the *label* for a *textarea*? We'd expect this to be `textarea_label`.
Find that. Ooh, it's not here! This is because the field types follow a *hierarchy*.
First, Symfony looks for `textarea_label`. But if that's not there, it'll fallback
to its parent type: text. So, `text_label`. And if *that* doesn't exist, it'll finally
look for - and find - `form_label`:

[[[ code('3c05fde198') ]]]

Form is the parent type for all fields.

And this system makes sense! The label for a textarea is no different from a label
for any other field. So, *all* labels are rendered via this block.

Another way to see this fallback mechanism is back in the web profiler. Click the
`name` field and then find "View Variables". Every field will have a variable
called `block_prefixes`. *This* shows us the options: after trying `text_label`,
`text_widget` or `text_errors` - depending on which part of the field we're rendering,
it'll fallback to `form_label`, `form_widget` or `form_errors`.

And actually, there's *also* a way to override the block for just *one* field in
your *one* form, by giving it a very specific name. In this case, if you had an
`_genus_form_name_label` block, that would override the label for *only* the name
field in this form. Pretty cool.

With *all* this new fun stuff in mind, let's extend this by creating our *own* form
theme. The goal: when a field has a validation error, add a cute "X" icon inside the
text field. Let's do it!


[symfony_forms]: http://knpuniversity.com/screencast/symfony-forms/render-form-bootstrap
