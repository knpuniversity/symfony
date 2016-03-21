## Entities, Twig and the Magic dot Syntax

Let's *finally* make this page real with a template. Return
`$this->render('genus/list.html.twig')` and pass it a `genuses` variable:

[[[ code('bfedf54fd7') ]]]

You know what to do from here: in `app/Resources/views/genus`, create the new
`list.html.twig` template. Don't forget to extend `base.html.twig` and then override
the `body` block. I'll paste a table below to get us started:

[[[ code('e8fcb4b825') ]]]

Since `genuses` is an array, loop over it with `{% for genus in genuses %}` and add
the `{% endfor %}`. Next, just dump out `genus` inside:

[[[ code('da9364ec48') ]]]

Looks like a good start - try it out!. Ok cool - this dumps out 4 Genus objects.
Open up the `tr`. Bring this to life with a `td` that prints `{{ genus.name }}`
and another that prints `{{ genus.speciesCount }}`. And hey, we're getting autocompletion,
that's kind of nice:

[[[ code('4de8fd9fe1') ]]]

## The Magic Twig "." Notation

Refresh! Easy - it looks *exactly* how we want it. But wait a second... something
cool just happened in the background. We printed `genus.name`... but `name` is a
*private* property - so we should *not* be able to access it directly. How is this
working?

[[[ code('0bf308ee9f') ]]]

This is Twig to the rescue! Behind the scenes, Twig noticed that `name` was private
and called `getName()` instead. And it does the same thing with `genus.speciesCount`:

[[[ code('10448b3fcc') ]]]

Twig is smart enough to figure out *how* to access the data - and this lets us keep
the template simple.

With that in mind, I have a challenge! Add a third column to the table called
"Last Updated":

[[[ code('78ffddc52f') ]]]

This won't work yet, but what I I *want* to be able to say is `{{ genus.updatedAt }}`.
If this existed and returned a DateTime object, we could pipe it through the built-in
Twig `date` filter to format it:

[[[ code('104d12c198') ]]]

But this *won't* work - there is *not* an `updatedAt` property. We'll add one later,
but we're stuck right now.

Wait! We can fake it! Add a `public function getUpdatedAt()` and return a random
`DateTime` object:

[[[ code('9e0f9873fd') ]]]

Try that out. It works! Twig doesn't care that there is no `updatedAt` property - it happily
calls the getter function. Twig, you're awesome.
