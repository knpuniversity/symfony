# Synchronizing Owning & Inverse Sides

Ultimately, when we submit... we're still *only* updating the `studiedGenuses` property
in `User`, which is the *inverse* side of this relationship:

[[[ code('5dcfa5f1c0') ]]]

So, nothing actually saves.

How can we set the *owning* side? Why not just do it inside the adder and remover
methods? At the bottom of `addStudiedGenus()`, add `$genus->addGenusScientist($this)`:

[[[ code('8ee4c33d7f') ]]]

Booya, we just set the owning side of the relationship!

In `removeStudiedGenus()`, do the same thing: `$genus->removeGenusScientist($this)`:

[[[ code('ec3ebeefdd') ]]]

So.... yea, that's all we need to do. Go back to the form, uncheck a genus, check
a genus and hit update. It's alive!!!

We didn't need to add a lot of code to get this to work... but this situation has
caused *many* developers to lose countless hours trying to get their relationship
to save. To summarize: if you're modifying the inverse side of a relationship, set
the `by_reference` form option to `false,` create an adder and remover function,
and make sure you set the *owning* side of the relationship in each. That is it.

## Synchronizing Both Sides

So, we're done! Well, technically we *are* done, but there is one last, tiny, teeny
detail that I'd like to *perfect*. In `Genus`, when we call `addGenusScientist()`,
it would be nice if we also updated this `User` to know that this `Genus` is now
being studied by it. In other words, it would be nice if we called `$user->addStudiedGenus($this)`:

[[[ code('ae861866ac') ]]]

I'm also going to add a note: this is *not* needed for persistence, but it might
save you from an edge-case bug. Suppose we called `$genus->addGenusScientist()`
to link a `User` to the `Genus`. Then later, during the *same* request - that's
important - we have that same `User` object, and we call `getStudiedGenuses()`. We
would want the `Genus` that was just linked to be in that collection. This does that!
We're guaranteeing that both sides of the relationship stay synchronized.

Do the same thing down in the remover: `$user->removeStudiedGenus($this)`:

[[[ code('c5121fcc81') ]]]

## Have Fun and Avoid Infinite Recursion!

That's great! Oh, except for one thing I just introduced: **infinite recursion**!
When we call `removeStudiedGenus()`, that calls `removeGenusScientist()`, which
calls `removeStudiedGenus()`, and so on... forever. And we are too busy to let our
scripts run forever!

The fix is easy - I was being lazy. Add an `if` statement in the remove functions,
like if `!$this->studiedGenuses->contains($genus)`, then just return:

[[[ code('506832daff') ]]]

In other words, if the `$genus` is not in the `studiedGenuses` array, there's no reason
to try to remove it.

Inside `Genus`, do the exact same thing: if `!$this->genusScientists->contains($user)`,
then return:

[[[ code('018f103b19') ]]]

Bye bye recursion.

Head back: uncheck a few genuses, check a few more and.... save! It works perfectly.
We don't really notice this last perfection... but it may help us out in the future.
