# Deleting an Item from a Collection: orphanRemoval

When we delete one of the `GenusScientist` forms and submit, the `CollectionType`
is now smart enough to *remove* that `GenusScientist` from the `genusScientists`
array on `Genus`. So, why doesn't that make any difference to the database?

The problem is that the `genusScientists` property is now the *inverse* side of
this relationship:

[[[ code('d2e7be441c') ]]]

In other words, if we remove or add a `GenusScientist` from this array, it doesn't
make any difference! Doctrine ignores changes to the inverse side.

## Setting the Owning Side: by_reference

How to fix it? We already know how! We did it back with our `ManyToMany` relationship!
It's a two step process.

First, in `GenusFormType`, set the `by_reference` option to `false`:

[[[ code('0b8596fa18') ]]]

Remember this?

Without this, the form component never calls `setGenusScientists()`. In fact, there
*is* no `setGenusScientists` method in `Genus`. Instead, the form calls `getGenusScientists()`
and then modifies that `ArrayCollection` object by reference:

[[[ code('fef83f705f') ]]]

But by setting it to false, it's going to give us the flexibility we need to
set the owning side of the relationship.

## Setting the Owning Side: Adder & Remover

With *just* that change, submit the form. Error! But look at it closely: the error
happens when the form system calls `removeGenusScientist()`. That's perfect! Well,
not the error, but when we set `by_reference` to false, the form started using our
adder and remover methods. *Now*, when we delete a `GenusScientist` form, it calls
`removeGenusScientist()`:

[[[ code('cdb3aaf26f') ]]]

The only problem is that those methods are *totally* outdated: they're still written
for our old `ManyToMany` setup.

In `removeGenusScientist()`, change the argument to accept a `GenusScientist` object.
Then update `$user` to `$genusScientist` in one spot, and then the other:

[[[ code('16c5b9c7a1') ]]]

For the last line, use `$genusScientist->setGenus(null)`. Let's update the note to say
the *opposite*:

> Needed to update the owning side of the relationship!

[[[ code('c0dd522482') ]]]

Now, when we remove one of the embedded `GenusScientist` forms and submit, it will
call `removeGenusScientist()` and that will set the owning side:
`$genusScientist->setGenus(null)`.

If you're a bit confused how this will ultimately *delete* that `GenusScientist`,
hold on! Because you're right! But, submit the form again.

## The Missing Link: orphanRemoval

Yay! Another error!

> UPDATE genus_scientist SET genus_id = NULL

Huh... that makes *perfect* sense. Our code is not *deleting* that `GenusEntity`.
Nope, it's simply setting its `genus` property to `null`. This update query makes
sense!

But... it's *not* what we want! We want to say:

> No no no. If the `GenusScientist` is no longer set to this `Genus`,
> it should be deleted entirely from the database.

And Doctrine has an option for *exactly* that. In `Genus`, find your `genusScientists`
property. Let's reorganize the `OneToMany` annotation onto multiple lines: it's getting
a bit long. Then, add one magical option: `orphanRemoval = true`:

[[[ code('1c816438b6') ]]]

That's the key. It says:

> If one of these `GenusScientist` objects suddenly has their `genus` set to `null`,
> just delete it entirely.

***TIP
If the `GenusScientist.genus` property is set to a *different* `Genus`,
instead of `null`, it will *still* be deleted. Use `orphanRemoval` only
when that's not going to happen.
***

Give it a try! Refresh the form to start over. We have four genus scientists.
Remove one and hit save. 

Woohoo! That *fourth* `GenusScientist` was just deleted from the database.

I know this was a bit tricky, but we didn't write a lot of code to get here. There are
just two things to remember.

First, if you're ever modifying the *inverse* side of a relationship in a form, set
`by_reference` to false, create adder and remover methods, and set the *owning*
side in each. And second, for a `OneToMany` relationship like this, use `orphanRemoval`
to delete that related entity for you.

This was a *big* success! Next: we need to be able to add *new* genus scientists
in the form.
