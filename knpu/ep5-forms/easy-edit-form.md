# Easy Edit Form

When you get to the form, it's completely blank. How could we add *default* data
to the form?

Well, it turns out answering that question is exactly the same as answering the question

> How do we create an edit form?

Let's tackle that.

In `GenusAdminController`, I'm going to be lazy: copy the entire `newAction()` and
update the URL to `/genus/{id}/edit`. Give it a different route name: `admin_genus_edit`
and call it `editAction()`:

[[[ code('0ad2ca15c6') ]]]

Our first job should be to query for a `Genus` object. I'll be lazy again and just
type-hint an argument with `Genus`:

[[[ code('3e635927bf') ]]]

Thanks to the param converter from `SensioFrameworkExtraBundle`, this will automatically
query for `Genus` by using the `{id}` value.

## Passing in Default Data

This form needs to be pre-filled with all of the data from the database. So again,
how can I pass default data to a form? It's as simple as this: the second argument
to `createForm` is the default data. Pass it the entire `$genus` object:

[[[ code('a415f7cd59') ]]]

Why the entire object? Because remember: our form is bound to the `Genus` class:

[[[ code('4bbd0fc063') ]]]

That means that its output will be a `Genus` object, but its input should *also*
be a `Genus` object.

Behind the scenes, it will use the getter functions on `Genus` to pre-fill the form:
like `getName()`. And everything else is exactly the same. Well, I'll tweak the flash
message but you get the idea:

[[[ code('dc095682a3') ]]]

## Rendering the Edit Form

Update the template to `edit.html.twig`:

[[[ code('f7a7ae06ea') ]]]

I'm still feeling lazy, so I'll completely duplicate the new template and update the `h1`
to say "Edit Genus":

[[[ code('d97450d6e5') ]]]

Don't worry, this duplication is temporary.

Finally, in the admin list template, I already have a spot ready for the edit link.
Fill that in with `path('admin_genus_edit')` and pass it the single wildcard value:
`id: genus.id`:

[[[ code('7c7293da6a') ]]]

LOVE it. Open up `/admin/genus` in your browser.

Ah good, an explosion - I felt like things were going too well today:

> Method `id` for object `Genus` does not exist in list.html.twig at line 25.

So apparently I do *not* have a `getId()` function on `Genus`. Let's check it out.
And indeed, when I created this class, I did not add a getter for ID. I'll use `command`+`N`,
or the "Code"->"Generate" menu to add it:

[[[ code('3b059cef2c') ]]]

Alright. Let's try it again. Refresh. No errors!

Edit the first genus. Check that out: it completely pre-filled the form for us.
In fact, check out this weird "TEST" text inside of `funFact`. That is left over from
an earlier tutorial. I hacked in this TEST string temporarily in `getFunFact()` so
we could play with markdown. This *proves* that the form is using the getter functions
to pre-fill things.

So, that's really interesting but let's take it out:

[[[ code('6e7eefb908') ]]]

Refresh. Change the "Fun fact" to be even more exciting, hit enter, and there it is:

> Genus updated - you are amazing!

Edit that Genus again: there's the new fun fact. This is a *really* cool thing
about the form framework: the new and edit endpoints are *identical*. The only difference
is that one is passed default data. 

So this is great! Except for the template duplication. That's not great still.
