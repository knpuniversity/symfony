# Adding to a Collection: Cascade Persist

After adding a new `GenusScientist` sub-form and submitting, we're greeted with
this wonderful error!

> Expected argument of type `User`, `GenusScientist` given

## Updating the Adder Method

But, like always, look closely. Because if you scroll down a little, you can see
that the form is calling the `addGenusScientist()` method on our `Genus` object:

[[[ code('5899a07c27') ]]]

Oh yea, we expected that! But, the code in this method is still outdated.

Change the argument to accept a `GenusScientist` object. Then, I'll refactor the variable
name to `$genusScientist`:

[[[ code('1e7ac712e7') ]]]

As you guys know, we always need to set the *owning* side of the relationship in
these methods. But, don't do that... yet. For now, *only* make sure that the new
`GenusScientist` object is added to our array.

With that fixed, go back, and refresh to resubmit the form. Yay! New error! Ooh,
this is an interesting one:

> A new entity was found through the relationship `Genus.genusScientists` that
> was not configured to cascade persist operations for `GenusScientist`.

Umm, what? Here's what's going on: when we persist the `Genus`, Doctrine sees the
new `GenusScientist` on the `genusScientists` array... and notices that we have
not called persist on *it*. This error basically says:

> Yo! You told me that you want to save this `Genus`, but it's related to a
> `GenusScientist` that you have *not* told me to save. You never called `persist()`
> on this `GenusScientist`! This doesn't make any sense!

## Cascade Persist

So what's the fix? It's simple! We just need to call `persist()` on any new `GenusScientist`
objects. We *could* add some code to our controller to do that after the form is
submitted:

[[[ code('652e2e1059') ]]]

Or... we could do something fancier. In `Genus`, add a new option to the `OneToMany`:
`cascade={"persist"}`:

[[[ code('88ea61d1a7') ]]]

This says: 

> When we persist a `Genus`, automatically call persist on each of the `GenusScientist`
> objects in this array. In other words, *cascade* the persist onto these children.

Alright, refresh now. This is the *last* error, I promise! And this makes perfect
sense: it *is* trying to insert into `genus_scientist` - yay! But with `genus_id`
set to `null`.

The `GenusScientistEmbeddedForm` creates a new `GenusScientist` object and sets
the `user` and `yearsStudied` fields:

[[[ code('1e5927d6e4') ]]]

But, nobody is ever setting the `genus` property on this `GenusScientist`.

This is because I forced you - against your will - to temporarily *not* set the
owning side of the relationship in `addGenusScientist`. I'll copy the same comment
from the remover, and then add `$genusScientist->setGenus($this)`:

[[[ code('c002e32bfe') ]]]

Owning side handled!

Ok, refresh *one* last time. Boom! We now have *four* genuses: this new one
was just inserted.

And yea, that's about as complicated as you can get with this stuff.

## Don't Purposefully Make your Life Difficult

Oh, but before we move on, go back to `/genus`, click a genus, go to one of the user
show pages, and then click the pencil icon. *This* form is still *totally* broken:
it's still built as if we have a `ManyToMany` relationship to `Genus`. But with our
new-found knowledge, we could easily fix this in the exact same way that we just
rebuilt the `GenusForm`. But, since that's not too interesting, instead, open
`UserEditForm` and remove the `studiedGenuses` field:

[[[ code('dde3a638cd') ]]]

Then, open the `user/edit.html.twig` template and kill the render:

[[[ code('11033e93eb') ]]]

Finally, find the `User` class and scroll down to the adder and remover methods.
Get these outta here:

[[[ code('6f2aa0b1d8') ]]]

Go back to refresh the form. Ok, better! This last task was more than just some cleanup:
it illustrates an important point. If you don't need to edit the `genusesStudied`
from this form, then you don't need all the extra code, especially the adder and
remover methods. Don't make yourself do extra work. At first, whenever I map the
*inverse* side of a relationship, I *only* add a "getter" method. It's only later,
*if* I need to update things from this side, that I get fancy.

Oh, and also, remember that this entire *side* of the relationship is *optional*. The
*owning* side of the relationship is in `GenusScientist`. So unless you need to be
able to easily fetch the `GenusScientist` instances for a `User` - in other words,
`$user->getStudiedGenuses()` -  don't even bother mapping this side. *We* are using
that functionality on the user show page, so I'll leave it.
