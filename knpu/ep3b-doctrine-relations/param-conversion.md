# Controller Magic: Param Conversion

Time to *finally* make these genus notes dynamic! Woo! 

Remember, those are loaded by a ReactJS app, and *that* makes an AJAX call to an API
endpoint in `GenusController`. Here it is: `getNotesAction()`:

[[[ code('303f8d583d') ]]]

Step 1: use the `genusName` argument to query for a `Genus` object. But you guys
already know how to do that: get the entity manager, get the Genus repository,
and then call a method on it - like `findOneBy()`:

[[[ code('95a9ad433c') ]]]

Old news.

Let's do something *much* cooler. First, change `{genusName}` in the route to `{name}`,
but don't ask why yet. Just trust me:

[[[ code('d7959ab04a') ]]]

This doesn't change the URL to this page... but it *does* break all the links
we have to this route.

To fix those, go to the terminal and search for the route name:

```bash
git grep genus_show_notes
```

Oh cool! It's only used in *one* spot. Open `show.html.twig` and find it at the bottom.
Just change the key from `genusName` to `name`:

[[[ code('d4098a63b0') ]]]

## Using Param Conversion

So... doing all of this didn't change *anything*. So why did I make us do all that?
Let me show you. You might *expect* me to add a `$name` argument. But don't! Instead,
type-hint the argument with the `Genus` class and then add `$genus`:

[[[ code('c6601dcefd') ]]]

What? I just violated one of the *cardinal* rules of routing: that every argument
must match the *name* of a routing wildcard. The truth is, if you type-hint an argument
with an entity class - like `Genus` - Symfony will automatically query for it. This
works as long as the wildcard has the same name as a property on `Genus`. *That's*
why we changed `{genusName}` to `{name}`. Btw, this is called "param conversion".

***TIP
Param Conversion comes from the [SensioFrameworkExtraBundle][1].
***

Dump the `$genus` to prove it's working:

[[[ code('8d8fa5f6cd') ]]]

Go back and refresh! We don't see the dump because it's actually an AJAX call - one
that happens automatically each second.

## Seeing the Profiler for an AJAX Request

But don't worry! Go to `/_profiler` to see a list of the most recent requests, including
AJAX requests. Select one of these: this is the profiler for that AJAX call, and in
the `Debug` panel... *there's* the dump. It's alive!

So be lazy: setup your routes with a wildcard that matches a property name and use
a type-hint to activate param conversion. If a genus can't be found for this page,
it'll automatically 404. And if you *can't* use param conversion because you need
to run a custom query: cool - just get the entity manager and query like normal.
Use the shortcut when it helps!


[1]: http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
