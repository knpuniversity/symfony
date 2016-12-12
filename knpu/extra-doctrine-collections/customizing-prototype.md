# Customizing the Collection Form Prototype

There's still one *ugly* problem with our form, and I promised we would fix: when we
click "Add Another Scientist"... well, it don't look right!. The new form should
have the exact same styling as the existing ones.

## Customizing the Prototype!

Why does it look different, anyways? Remember the `data-prototype` attribute?

[[[ code('508e4af67f') ]]]

By calling `form_widget`, this renders a blank `GenusScientist` form... by using the
*default* Symfony styling. But when we render the *existing* embedded forms, we
wrap them in all kinds of cool markup:

[[[ code('f2dbfc62cd') ]]]

What we *really* want is to somehow make the `data-prototype` attribute use the markup
that we wrote inside the `for` statement.

How? Well, there are at least two ways of doing it, and I'm going to show you the
less-official and - in my opinion - easier way!

Head to the top of the file and add a *macro* called `printGenusScientistRow()` that
accepts a `genusScientistForm` argument:

[[[ code('76cd82c308') ]]]

If you haven't seen a macro before in Twig, it's basically a function that you create
right inside Twig. It's really handy when you have some markup that you don't want to repeat
over and over again.

Next, scroll down to the scientists area and copy everything inside the `for` statement.
Delete it, and then paste it up in the macro:

[[[ code('ddcd20f7eb') ]]]

## Use that Macro!

To call that macro, you actually need to import it... even though it already
lives inside this template. Whatever: you can do that with `{% import _self as formMacros %}`:

[[[ code('244169cad4') ]]]

The `_self` part would normally be the name of a *different* template whose macros
you want to call, but `_self` is a magic way of saying, no, *this* template. 

The `formMacros` is an alias I just invented, and it's how we will *call* the macro.
For example, inside the `for` loop, render `formMacros.printGenusScientistRow()` and
pass it `genusScientistForm`:

[[[ code('2bdb577994') ]]]

And *now* we can do the same thing on the `data-prototype` attribute:
`formMacros.printGenusScientistRow()` and pass that `genusForm.genusScientists.vars.prototype`.
Continue to escape that that into HTML entities:

[[[ code('ce09b081d0') ]]]

I love when things are this simple! Go back, refresh, and click to add another scientist.
Much, much better! Obviously, we need a little styling help here with our rows but
you guys get the idea.

## Centralizing our JavaScript

The *last* problem with our form deals with JavaScript. Go to `/admin/genus` and
click "Add". Well... our fancy JavaScript doesn't work here. Wah wah.

But that makes sense: we put all the JavaScript into the edit template. The fix for
this is super old-fashioned... and yet perfect: we need to move all that JavaScript
into its own file. Since this isn't a JavaScript tutorial, let's keep things simple:
in `web/js`, create a new file: `GenusAdminForm.js`.

Ok, let's be a *little* fancy: add a self-executing block: a little function that
calls itself and passes jQuery inside:

[[[ code('f4d10b2047') ]]]

Then, steal the code from `edit.html.twig` and paste it here. It doesn't *really* matter,
but I'll use `$` everywhere instead of `jQuery` to be consistent:

[[[ code('bff5ba7134') ]]]

Back in the edit template, include a proper script tag: `src=""` and pass in the
`GenusAdminForm.js` path:

[[[ code('6235397cc9') ]]]

Copy the *entire* `javascripts` block and then go into `new.html.twig`. Paste!

[[[ code('ab7f5dab31') ]]]

And now, we should be happy: refresh the new form. Way better!

## Avoiding the Weird New Label

But... what's with that random label - "Genus scientists" - after the submit button!
What the crazy!?

Ok, so the reason this is happening is a little subtle. Effectively, because there
are no genus scientists on this form, Symfony sort of thinks that this `genusForm.genusScientists`
field was never rendered. So, like all unrendered fields, it tries to render it in
`form_end()`. And this causes an extra label to pop out.

It's silly, but easy to fix: after we print everything, add `form_widget(genusForm.genusScientists)`.
And ya know what? Let's add a note above to explain this - otherwise it looks a little
crazy.

[[[ code('85a8e30f81') ]]]

And don't worry, this will never actually print anything. Since all of the children
fields are rendered above, Symfony knows not to *re-render* those fields. This just
prevents that weird label.

Refresh! Extra label gone. And if you go back and edit one of the genuses, things
look cool here too.

Now, I have *one* last challenge for us with our embedded forms.
