# Saving the Inverse Side of a ManyToMany

Back on the main part of the site, click one of the genuses, and then click one
of the users that studies it. This page has a little edit button: click that.
Welcome to a very simple `User` form.

## Building the Field

Ok, same plan: add checkboxes so that I can choose which genuses are being studied
by this `User`. Open the controller: `UserController` and find `editAction()`:

[[[ code('3e90bc106f') ]]]

This uses `UserEditForm`, so go open that as well.

In `buildForm()`, we'll do the *exact* same thing we did on the genus form: add
a new field called `studiedGenuses` - that's the property name on `User` that we
want to modify:

[[[ code('884516d9af') ]]]

Keep going: use `EntityType::class` and then set the options: `class` set now to
`Genus::class` to make `Genus` checkboxes. Then, `multiple` set to `true`, `expanded`
set to `true`, and `choice_label` set to `name` to display that field from `Genus`:

[[[ code('6b9efdf47c') ]]]

Next! Open the template: `user/edit.html.twig`. At the bottom, use
`form_row(userForm.studiedGenuses)`:

[[[ code('d49deff9ef') ]]]

That's it.

Try it! Refresh! Cool! This `User` is studying five genuses: good for them!
Let's uncheck one genus, check a new one and hit Update.

## It didn't Work!!! Inverse Relationships are Read-Only

Wait! It didn't work! The checkboxes just reverted back! What's going on!?

*This* is the moment where someone who doesn't know what we're about to learn,
starts to *hate* Doctrine relations.

Earlier, we talked about how every relationship has two sides. You can start with
a `Genus` and talk about the genus scientist users related to it:

[[[ code('b95e4ae530') ]]]

Or, you can start with a `User` and talk about its studied genuses:

[[[ code('019ceffe5e') ]]]

Only one of these side - in this case the `Genus` - is the *owning* side. So far,
that hasn't meant anything: we can easily *read* data from either direction. BUT!
The owning side has one special power: it is the *only* side that you're allowed
to change.

What I mean is, if you have a `User` object and you add or remove genuses from its
`studiedGenuses` property and save... Doctrine will do *nothing*. Those changes
are completely ignored.

And it's not a bug! Doctrine is built this way on purpose. The data about which
Genuses are linked to which Users is stored in *two* places. So Doctrine needs
to choose *one* of them as the official source when it saves. It uses the *owning*
side.

For a `ManyToMany` relationship, we chose the owning side when we set the `mappedBy`
and `inversedBy` options. The owning side is also the only side that's allowed to
have the `@ORM\JoinTable` annotation.

This is a *long* way of saying that if we want to update this relationship, we *must*
add and remove users from the `$genusScientists` property on `Genus`:

[[[ code('9ce4a0eb27') ]]]

Adding and removing genuses from the `User` object will do nothing. And that's
exactly what our form just did.

No worries! We can fix this, with just a *little* bit of really smart code.
