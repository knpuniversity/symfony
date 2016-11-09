# Refactoring Carefully

Time to refactor our code to use the *slug* in the URLs. I'll close up a
few files and then open `GenusController`. The "show" page we just saw in our browser
comes from `showAction()`. And yep, it has `{genusName}` in the URL. Gross:

[[[ code('425bf89233') ]]]

Change that to `{slug}`:

[[[ code('5790b90f23') ]]]

And now, because `slug` is a property on the `Genus` entity, we *don't* need to manually
query for it anymore. Instead, type-hint `Genus` as an argument:

[[[ code('6ca21a2c38') ]]]

Now, Symfony will do our job for us: I mean, query for the `Genus` automatically.

That means we can clean up a lot of this code. Just update the `$genusName` variable
below to `$genus->getName()`:

[[[ code('e177434347') ]]]

## We just Broke our App!

Cool! Except, we just broke our app! By changing the wildcard from `{genusName}`
to `{slug}`, we broke any code that generates a URL to this route. How can we figure
out where those spots are?

My favorite way - because it's really safe - is to search the entire code base. In
this case, we can search for the route name: `genus_show`. To do that, find your
terminal and run:

```bash
git grep genus_show
```

Ok! We have 1 link in `list.html.twig` and we also generate a URL inside `GenusController`.

Search for the route in the controller. Ah, `newAction()` - which just holds
some fake code we use for testing. Change the array key to `slug` set to `$genus->getSlug()`:

[[[ code('3d0844a568') ]]]

Next, open `app/Resources/views/genus/list.html.twig`. Same change here: set `slug`
to `genus.slug`:

[[[ code('e8beb1484f') ]]]

Project, un-broken!

There's *one* other page whose URL still uses `name`. In `GenusController`, find
`getNotesAction()`. This is the AJAX endpoint that returns all of the notes for a specific
`Genus` as JSON.

Change the URL to use `{slug}`:

[[[ code('5883702ef3') ]]]

The automatic query will still work just like before. Now, repeat the careful searching
we did before: copy the route name, find your terminal, and run:

```bash
git grep genus_show_notes
```

This is used in just *one* place. Open the `genus/show.html.twig` template. Change
the `path()` argument to `slug` set to `genus.slug`:

[[[ code('4f2dad00f0') ]]]

That's it! That's everything. Go back to `/genus` in your browser and refresh. Now,
click on `Octopus`. Check out that lowercase `o` on `octopus` in the URL. And since
the notes are still displaying, it looks like the AJAX endpoint is working too.

So slugs are the *proper* way to do clean URLs, and they're really easy if you set
them up from the beginning. You can also use `{id}` in your URLs - it just depends
if you need them to look fancy or not.

Ok, let's get back to the point of this course: time to tackle - queue dramatic music -
ManyToMany relations.
