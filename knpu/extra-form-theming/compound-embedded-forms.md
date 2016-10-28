# Compound & Embedded Forms

Right now, this is a pretty simple form. We have our top level form, and then
each field below it is its own `Form` object. And we now know that when you pass
this into the template, all of those `Form` objects become `FormView` objects.

But this will still just be *2* levels: the `FormView` object on top, and the children
`FormView` object for each field. But, it can get a lot more complicated than that.

To show you, go into `GenusFormType`. For now, change the `firstDiscoveredAt` options:
comment out `widget` and `attr`:

[[[ code('a02a230eb6') ]]]

Refresh this immediately. Ok, the `widget` option defaults to `choice`, which means
that this renders as three select fields. I know, it's horribly ugly, hard to look
at... but it's a perfect example! Click into the profiler for this form to see
something *really* interesting. The `firstDiscoveredAt` has a "+" next to it...
and three fields below it!

## Compound Fields!

You see, `firstDiscoveredAt` is no longer a "simple" field: it's now a field that
consists of 3 sub-fields: `year`, `month`, and `day`. Each of these is their own
`ChoiceType` field. Oh, and if you select `firstDiscoveredAt`, under "View Variables",
for the first time, the `compound` variable is set to `true`.

We saw this `compound` variable in a few places earlier. And now we know what it
means! A field is `compound` if it's not really its own field, but is instead just
a container for sub-fields.

In the `_form.html.twig` template, when we call `form_row()` on
`genusForm.firstDiscoveredAt`, Symfony tries to render the parent field, notices
that it's `compound` and so, calls `form_row()` on each of its three sub-fields:

[[[ code('2fe6391e3a') ]]]

The result is the nice output we're already seeing.

## Rendering Sub-Fields

To get more control, you could instead call `form_row` on each individual field:
for `year`, `month` and `day`:

[[[ code('40cb4083f3') ]]]

But notice that if this field fails validation, the error is attached to the *parent*
field. So you might want to keep rendering `form_label(genusForm.firstDiscoveredAt)`
and you definitely want to keep rendering `form_errors(genusForm.firstDiscoveredAt)`,
so that the error shows up.

If you go back and refresh, you basically see the same thing as before. It's
ugly, but you just learned how to take control of *any* level of a complex form tree.
