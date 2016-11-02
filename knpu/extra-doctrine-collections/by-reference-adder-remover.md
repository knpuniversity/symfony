# Form by_reference + Adder and Remover

Head back to our form. We have a field called `studiedGenuses`. Because *all* of
our properties are private, the form component works by calling the setter method
for each field. I mean, when we submit, it takes the submitted email and calls
`setEmail()` on `User`.

But wait... we *do* have a field called `studiedGenuses`... but we do *not* have
a `setStudiedGenuses` method! Shouldn't the form component be throwing a huge error
about that?

## The by_reference Form Option

In theory... yes! But, the form is being *really* sneaky. Remember, the `studiedGenuses`
property is an `ArrayCollection` object. When the form is building, it calls `getStudiedGenuses()`
so that it knows which checkboxes to check. Then on submit, *instead* of trying to
call a setter, it simply *modifies* that `ArrayCollection`. Basically, since `ArrayCollection`
is an object, the form realizes it can be lazy: it adds and removes genuses directly
from the object, but never sets it back on `User`. It doesn't need to, because the
object is linked to the `User` by reference.

This *ultimately* means that our `studiedGenuses` property *is* being updated like
we expected... just in a fancy way.

So... why should we care? We don't really... except that by *disabling* this fancy
functionality, we will uncover a way to fix *all* of our problems.

How? Add a new option to the field: `by_reference` set to `false`. It says:

> Stop being fancy! Just call the setter method like normal!

Go refresh the form, and submit!

## The Adder and Remover Methods

Ah! It's yelling at us! This is the error we expected all along:

> Neither the property `studiedGenuses` nor one of the methods - and then it
> lists a bunch of potential methods, including `setStudiedGenuses` - exist
> and have public access in the `User` class.

In less boring terms, the form system is trying to say:

> Hey! I can't set the `studiedGenuses` back onto the `User` object unless you
> create one of these public methods!

So, should we create a `setStudiedGenuses()` method like it suggested? Actually,
no. Another option is to create adder & remover methods.

Create a `public function addStudiedGenus()` with a `Genus` argument. Here, we'll
do the same type of thing we did back in our `Genus` class: if `$this->studiedGenuses->contains($genus)`,
then do nothing. Otherwise `$this->studiedGenuses[] = $genus`.

After that, add the remover: `public function removeStudiedGenus()` also with a
`Genus` argument. In here, say `$this->studiedGenuses->removeElement($genus)`.
Perfect!

Go back to the form. Uncheck one of the genuses and check a new one. When we submit,
it *should* call `addStudiedGenus()` once for the new checkbox and `removeStudiedGenus()`
once for the box we unchecked.

Ok, hit update! Hmm, it *looked* successful... but it still didn't actually work.
And that's expected! We just setup a cool little system where the form component calls
our adder and remover methods to update the `studiedGenuses` property. But... this hasn't
really changed anything: we're still not setting the *owning* side of the relationship.

But, we're just *one* small step from doing that.
