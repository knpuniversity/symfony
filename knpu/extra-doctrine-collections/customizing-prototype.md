# Customizing the Collection Form Prototype

There's one *glaring* problem with our form that I promised we would fix: when we
click "Add Another Scientist"... well, it doesn't look right!. The new form should
have the exact same styling as the existing ones.

## Customizing the Prototype!

Why does it look different, anyways? Remember the `data-prototype` attribute? By
calling `form_widget`, this renders a blank `genusScientist` form... by using the
*default* Symfony styling. But when we render the *existing* embedded forms, we
wrap them in all kinds of cool markup. What we *really* want is to somehow make the
`data-prototype` attribute use the markup that's inside the `for` statement.

How? Well, there are at least two ways of doing it. I'm going to show you the less-official
and - in my opinion - easier way!

Head to the top of the file and add a *macro* called `printGenusScientistRow` that
accepts a `genusScientistForm` argument. If you haven't seen a macro before in Twig,
it's basically a function that you can create right inside Twig. It's really handy
when you have some markup that you don't want to repeat over and over again.

Next, scroll down to the scientists area and copy everything inside the `for` statement.
Delete it, and then paste it up in the macro.

## Use that Macro!

In order to call that macro, you actually need to import it... even though it already
lives inside this template. Whatever: you can do that with `{% import _self as formMacros %}`.
The `_self` part would normally be a *different* template name whose macros you want
to use, but `_self` is a magic way of saying, no, *this* template. 

The `formMacros` is an alias I just invented, and it is how we will *call* the macro.
For example, inside the `for` loop, render `formMacros.printGenusScientistRow()` and
pass it `genusScientistRow`.

But *now* we can do the same thing on the `data-prototype` attribute:
`formMacros.printGenusScientistRow()` and pass that `genusForm.genusScientist.vars.prototype`.
Continue to escape that that into HTML entities.

Oh man, that was pretty simple! Go back, refresh, and click to add another scientist.
Much, much better! Obviously, we need a little styling help here with our rows but
you guys get the idea.

## Centralizing our JavaScript

The *last* problem deals with our JavaScript. Go to `/admin/genus` and click "Add".
Well... our fancy JavaScript doesn't work here. Wah wah.

But that makes sense: we put all the JavaScript into our edit template. The fix for
this is super old-fashioned... and yet perfect: we need to move all that JavaScript
into its own file. Let's keep things simple since this isn't a JavaScript tutorial:
in `web/js`, create a new file: `GenusAdminForm.js`.

Ok, let's be a *little* fancy: add a self-executing block: a little function that
calls itself and passes jQuery inside. Then, steal the code from `edit.html.twig`
and paste it here. It doesn't *really* matter, but I'll use `$` everywhere instead
of `jQuery` to be consistent.

Back in the edit template, include a proper script tag: `src=""` and pass it the
`GenusAdminForm.js` path.

Copy the *entire* `javascripts` block and then go into `new.html.twig`. Paste!
And now, we should be happy: refresh the new form. Way better!

## Avoiding the Weird New Label

But what's this random label down here: "Genus scientists" after the submit button!
What the crazy!?

Ok, so the reason this is happening is a little subtle. Effectively, because there
are no genus scientists on this form, Symfony sort of thinks that this `genusForm.genusScientists`
field was never rendered. So, like all unrendered fields, it tries to render it in
`form_end()`. And this causes an extra label to pop out.

It's silly, but easy to fix: after we print everything, add `form_widget(genusForm.genusScientists)`.
And ya know what? Let's add a note above to explain this - otherwise it looks a little
crazy.

And don't worry, this will never actually print anything. Since all of the children
fields are rendered above, Symfony knows not to *re-render* those fields. This just
prevents that weird label.

Refresh! Extra label gone. And if you go back and edit one of the genuses, things
look cool there too.

Now, I have *one* last challenge for us with our embedded forms.
