# Rendering Fields Manually

Finally, let's look at the Swiss Army knife of form rendering: instead of using the
form-rendering functions, we'll build the field entirely by hand.

For example, suppose we need to do something *crazy* with the "year" drop-down
field. That's fine! We'll still render the label and errors normally, but let's
handle the widget ourselves. Yep, I literally mean: create a `select` tag and
start filling in the details.

The first detail is the `id` attribute. Every field has a unique id, which ties
that field to its label. And this is where form variables help us out *big*.

## Referencing Field Variables Directly

Go back into the Form tab of the web profiler and click the `year` field. There
are a lot of variables, but there are a few that are *especially* important, like
`id` and `full_name`, which normally becomes the `name` attribute.

In your template, reference the `id` variable with: `genusForm.firstDiscoveredAt.year.vars.id`.
Repeat that for the `name` attribute set to `genusForm.firstDiscoveredAt.year.vars.full_name`:

[[[ code('98f5a5e0a8') ]]]

Now that we understand the `FormView` tree and how variables are stored, this actually
makes sense.

## Printing the Options

Next, what about the options that should go inside the `select` tag? Head back to
the web profiler to see which variable might help us. Ah, here's one called
`choices`, and each item is a `ChoiceView` object. Use the `Shift`+`Shift` shortcut
to open *that* file from Symfony:

[[[ code('908ecaa2d4') ]]]

Cool! Each `ChoiceView` is a simple object, with a public `label` property and a
public `value` property:

[[[ code('f9c5690272') ]]]

That's exactly what we need.

Add a loop: `for choice in genusForm.firstDiscoveredAt.year.vars.choices`:

[[[ code('50b851426c') ]]]
    
Inside, add `<option value="">` then print `choice.value`.

We also need to know if this option should be currently selected. We can do that
by comparing the value to the `data` variable that's attached to the `year` field.
Why not do this in one big giant line: `choice.value == genusForm.firstDiscoveredAt.year.vars.data`.
Wow. Then, `? ' selected'` or empty quotes. Finally, for the option text, use `choice.label`:

[[[ code('88e0e92204') ]]]

That's it! Go back to your browser, then refresh. Ah, error!

That's me being careless: the sub-field is called `year`, not `years`:

[[[ code('f13b2b9c23') ]]]

Refresh again.

It works! It's not styled because we've taken complete control of rendering it. But
you *can* see the errors, and the options look correct. Cool!

## Marking Fields as Rendered

So, we're done! Wait... except for this random field at the bottom of my form. What
the heck!? That's my year field! What's going on?

See that `form_end()` at the bottom of our form?

[[[ code('89085ab8f3') ]]]

Remember how it renders *any* field that we forgot to render? Well, now it thinks
that *we* forgot to render the `year` field. The nerve!

So, could we just *tell* it that the field *was* actually rendered? Yep, and the
code is both simple and strange. Use a rare *do* tag from Twig and say
`genusForm.firstDiscoveredAt.year.setRendered()`:

[[[ code('4ad85d769f') ]]]

Whaaaat? Well, every field is a `FormView` object. And if you open that class,
it has a `setRendered()` method!

[[[ code('d919d625af') ]]]

And by calling it, we're saying:

> Yo, we rendered this already. So, you know, don't try to render it again.

Refresh now! Whoops! Another Ryan mistake - make sure your variable is `genusForm`,
not `genus`:

[[[ code('8c486d12dc') ]]]

*Now* that extra field is gone.

## Wrap it Up!

Congrats team: you have the power to render your forms in whatever crazy, insane,
creative way you want! But with power, comes great responsibility. I'll delete all
the code we just added and go back to simply rendering `genusForm.firstDiscoveredAt`:

[[[ code('e257821ef6') ]]]

[[[ code('4b7109b916') ]]]

Don't use your new skills unless you actually need to.

Ok guys, that's it! If you still have some questions, or want to tell me about
something really cool you did, or share vacation photos, whatever, you can do it
in the comments - it's always great to hear from you.

All right guys, see you next time.
