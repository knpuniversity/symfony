# Adding to a Collection: Cascade Persist

After adding a new `GenusScientist` sub-form and submitting, we're greeted with
this wonderful error!

## Updating the Adder Method

But, like always, look closely. Because if you scroll down a little, you can see
that the form is calling the `addGenusScientist()` method on our `Genus` object.
Oh yea, we expected that! But, the code in this method is still outdated.

Change the argument to accept a `GenusScientist` object. Then, I'll refactor the variable
to `$genusScientist`

As you guys know, we always set the *owning* side of the relationship in these methods.
But, don't do that... yet. For now, *only* make sure that the new `GenusScientist`
is added to our array.

With that fixed, go back, and refresh to resubmit the form. Yay! New error! Ooh,
this is an interesting one:

> A new entity was found through the relationships `Genus.genusScientists` that
> was not configured to cascade persist operations for `GenusScientist`.

Umm, what? Here's what's going on: when we persist the `Genus`, Doctrine sees the
new `GenusScientist` on the `genusScientists` array... and sees that we haven't called
persist on *it*. This is an error that says:

> Hey! You told me that you want to save this `Genus`, but it's related to a
> `GenusScientist` that you have *not* told me to save. You never called persist
> on this `GenusScientist`! This doesn't make any sense!

## Cascade Persist

What's the fix? It's simple! We just need to call `persist()` on any new `GenusScientist`
objects. We *could* add some code to our controller to do that. Or... we could do
something fancier. In `Genus`, add a new option to `OneToMany`: `cascade={"persist"}`.

This says: when we persist a `Genus`, automatically call persist on each of the
`GenusScientist` objects in this array. In other words, *cascade* the persist onto
these children.

Ok, refresh now. This is the *last* error, I promise! And this makes perfect sense:
it *is* trying to insert into `genus_scientist` - yay! - but with `genus_id` set
to null.

The `GenusScientistEmbeddedForm` creates a new `GenusScientist` object and sets
the `user` and `yearsStudied` fields. But, nobody is ever setting the `genus` property
on this `GenusScientist`.

This is because I forced you - against your will - to temporarily *not* set the
owning side of the relationship in `addGenusScientist`. I'll copy the same comment
from the remover, and then add `$genusScientist->setGenus($this)`. Owning side set!

Ok, refresh *one* last time... I swear! Boom! We have *four* genuses: this new one
was just inserted.

And yea, that's about as complicated as you can get with this stuff.

## Don't Purposefully Make your Life Difficult

Oh, but before we move on, go back to `/genus`, click a genus, go to one of the user
show pages, and then click the pencil icon. *This* form is still *totally* broken:
it's still built as if we have a `ManyToMany` relationship to `Genus`. But with our
new-found knowledge, we could easily fix this in the exact same way that we just
rebuilt the `GenusForm`. But, since that's not too interesting, instead, open
`UserEditForm` and remove the `studiedGenuses` field. Then, open the `user/edit.html.twig`
template and kill the render. Finally, find the `User` class and scroll down to the
adder and remover methods. Get these outta here.

Go back to refresh the form. Ok, better! This last task was more than just some cleanup:
it illustrates an important point. If you don't need to edit the `genusesStudied`
from this form, then you don't need all the extra code - the adder and remover methods.
Don't make yourself do work that you don't need!

And also, remember that this entire *side* of the relationship is *optional*. The
*owning* side of the relationship is in `GenusScientist`. So unless we want to be
able to easily fetch the `GenusScientist` instances easily for a `User`, don't even
bother mapping this side. We *are* using it on the user show page, so we'll leave
it.
