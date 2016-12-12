# Embedded Form: CollectionType

Now that we've added the `yearsStudied` field to each `GenusScientist`, I'm not too
sure that checkboxes make sense anymore. I mean, if I want to show that a `User`
studies a `Genus`, I need to select a `User`, but I also need to tell the
system how many *years* they have studied. How *should* this form look now?

Here's an idea, and one that works really well the form system: embed a collection
of `GenusScientist` *subforms* at the bottom, one for each user that studies this
`Genus`. Each subform will have a `User` drop-down and a "Years Studied" text box.
We'll even add the ability to add or delete subforms via JavaScript, so that we can
add or delete `GenusScientist` rows.

## Creating the Embedded Sub-Form

Step one: we need to build a form class that represents *just* that little embedded
`GenusScientist` form. Inside your `Form` directory, I'll press `Command+N` - but
you can also right-click and go to "New" - and select "Form". Call it `GenusScientistEmbeddedForm`.
Bah, remove that `getName()` method - that's not needed in modern versions of Symfony:

[[[ code('440298d4a7') ]]]

Yay!

In `configureOptions()`, add `$resolver->setDefaults()` with the classic `data_class`
set to `GenusScientist::class`:

[[[ code('841907eb11') ]]]

We *will* ultimately embed this form into our main genus form... but at this point...
you can't tell: this form looks exactly like any other. And it will ultimately give
us a `GenusScientist` object.

For the fields, we need two: `user` and `yearsStudied`:

[[[ code('d0e4acd0e3') ]]]

We do *not* need a `genus` dropdown field: instead, we'll automatically set that property
to whatever `Genus` we're editing right now.

The `user` field should be an `EntityType` dropdown. In fact, let's go to `GenusFormType`
and steal the options from the `genusScientists` field - it'll be *almost* identical.
Set this to `EntityType::class` and then paste the options:

[[[ code('562522b26a') ]]]

And make sure you re-type the last r in `User` and auto-complete it to get the `use`
statement on top. Do the same for `UserRepository`. The only thing that's different
is that this will be a drop-down for just *one* `User`, so remove the `multiple` and
`expanded` options.

## Embedding Using CollectionType

*This* form is now perfect. Time to embed! Remember, our goal is *still* to modify
the `genusScientists` property on `Genus`, so our form field will *still* be called
`genusScientists`. But clear out all of the options and set the type to
`CollectionType::class`. Set its `entry_type` option to `GenusScientistEmbeddedForm::class`:

[[[ code('81364a84ab') ]]]

Before we talk about this, let's see what it looks like! Refresh!

Woh! This `Genus` is related to *four* GenusScientists... which you can see because
it built an embedded form for each one! Awesome! Well, it's mostly ugly right now,
but it works, and it's free!

Try updating one, like 26 to 27 and hit Save. It even saves!

## Rendering the Collection... Better

But let's clean this up - because the form looks *awful*... even by my standards.

Open the template: `app/Resources/views/admin/genus/_form.html.twig`:

[[[ code('380ed21c68') ]]]

This `genusScientists` field is *not* and actual field anymore: it's an *array* of
fields. In fact, each of *those* field is *itself* composed of more sub-fields.
What we have is a fairly complex form tree, which is something we talked about
in our [Form Theming Tutorial][compound_embedded_forms].

To render this in a more controlled way, delete the `form_row`. Then, add an `h3`
called "Scientists", a Bootstrap row, and then loop over the fields with
`for genusScientistForm in genusForm.genusScientists`:

[[[ code('246263e249') ]]]

Yep, we're *looping* over each of those four embedded forms.

Add a column, and then call `form_row(genusScientistForm)` to print both the `user`
and `yearsStudied` fields at once:

[[[ code('5845ec1631') ]]]

So this should render the same thing as before, but with a bit more styling. Refresh!
Ok, it's better... but what's up with those zero, one, two, three labels?

This `genusScientistForm` is actually an entire form full of several fields. So,
it prints out a label for the entire form... which is zero, one, two, three, and
four. That's not helpful!

Instead, print each field by hand. Start with `form_errors(genusScientistForm)`, just
in case there are any validation errors that are attached at this form level:

[[[ code('29ba33321d') ]]]

It's not common, but possible. Then, simply print `form_row(genusScientistForm.user)` and
`form_row(genusScientistForm.yearsStudied)`:

[[[ code('3ae8af5884') ]]]

Try it! Much better!

But you know what we *can't* do yet? We can't actually *remove* - or *add* - new scientists.
all *we* can do is edit the existing ones. That's silly! So let's fix it!


[compound_embedded_forms]: https://knpuniversity.com/screencast/symfony-form-theming/compound-embedded-forms
