# Embedded Form Validation with @Valid

We've got more work to do! So head back to `/admin/genus`. Leave the "Years Studied"
field empty for one of the `GenusScientist` forms and submit.

Explosion!

> UPDATE genus_scientist SET years_studied = NULL

This field is not allowed to be null in the database. That's on purpose... but we're
missing validation! Lame!

But no problem, right? We'll just go into the `Genus` class, copy the `as Assert`
use statement, paste it into `GenusScientist` and then - above `yearsStudied` - add
`@Assert\NotBlank`:

[[[ code('28bb2c1493') ]]]

Cool! Now, the `yearsStudied` field will be required.

Go try it out: refresh the page, empty out the field again, submit and... What!?
It still doesn't work!?

## @Valid for a Good Time

It's as if Symfony doesn't see the new validation constraint! Why? Here's the deal:
our form is bound to a `Genus` object:

[[[ code('b59517f0e6') ]]]

That's the top-level object that we're modifying. And by default, Symfony reads all
of the validation annotations from the top-level class... only. When it sees an
embedded object, or an array of embedded objects, like the `genusScientists` property,
it does *not* go deeper and read the annotations from the `GenusScientist` class.
In other words, Symfony *only* validates the top-level object.

Double-lame! What the heck Symfony?

No no, it's cool, it's on purpose. You can easily *activate* embedded validation
by adding a unique annotation above that property: `@Assert\Valid`:

[[[ code('7b15a302e2') ]]]

That's it! Now refresh. Validation achieved!

## Preventing Duplicate GenusScientist

But there's *one* other problem. I know, I always have bad news. Set one of the
users to aquanaut3. Well, that's actually a duplicate of this one... and it doesn't
really make sense to have the same user listed as two different scientists. Whatever!
Save right now: it's all good: aquanaut3 and aquanaut3. I want validation to prevent
this!

No problem! In `GenusScientist` add a new annotation above the *class*: yep, a rare
constraint that goes above the class instead of a property: `@UniqueEntity`. Make
sure to auto-complete that to get a special `use` statement for this:

[[[ code('a156fc50bd') ]]]

This takes a few options, like `fields={"genus", "user"}`:

[[[ code('31b270a30a') ]]]

This says:

> Don't allow there to be two records in the database that have the same genus
> and user.

Add a nice message, like:

> This user is already studying this genus.

[[[ code('10eb5362bf') ]]]

Great!

Ok, try this bad boy! We already have duplicates, so just hit save. Validation error
achieved! But... huh... there are *two* errors and they're listed at the *top* of
the form, instead of next to the offending fields.

First, ignore the *two* messages - that's simply because we allowed our app to get
into an invalid state and *then* added validation. That confused Symfony. Sorry!
You'll normally only see one message.

But, having the error message way up on top... that sucks! The reason why this happens
is honestly a little bit complex: it has to do with the `CollectionType` and
something called `error_bubbling`. The more important thing is the fix: after the
`message` option, add another called `errorPath` set to `user`:

[[[ code('8899761dbc') ]]]

In a *non* embedded form, the validation error message from `UniqueEntity` normally
shows at the top of the form... which makes a lot of sense in that situation. But
when you add this option, it says:

> Yo! When this error occurs, I want you to attach it to the user field.

So refresh! Error is in place! And actually, let me get us *out* of the
invalid state: I want to reset my database to *not* have any duplicates to start.
*Now* if we change one back to a duplicate, it looks great... and we don't have
*two* errors anymore.

## Fixing CollectionType Validation Bug

There is one small bug left with our validation! And it's tricky! To see it:
add 2 new scientists, immediately remove the first, leave the `yearsStudied`
field blank, and then submit. We *should* see a validation error appearing below
the `yearsStudied` field. Instead, it appears no the top of the form! This is
actually caused by a bug in Symfony, but we can fix it easily! The following
code block shows the fix and has more details:

[[[ code('7d7da810eb') ]]]
