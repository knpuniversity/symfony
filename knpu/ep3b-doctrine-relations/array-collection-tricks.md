# Tricks with ArrayCollection

Oh man, the project manager just came to me with a new challenge. Showing all the
notes below is great, but they want a new section on top to easily see how many notes
have been posted during the past 3 months.

Hmm. In `showAction()`, we need to somehow count all the recent notes for this `Genus`.
We *could* start with `$recentNotes = $genus->getNotes()`... but that's *everything*. Do
we need to finally stop being lazy and make a custom query? Not necessarily.

Remember: `getNotes()` returns an `ArrayCollection` object and it has some tricks
on it - like a method for filtering! Chain a call to the `filter()` method and pass
this an anonymous function with a `GenusNote` argument. The `ArrayCollection` will
call this function for *each* item. If we return true, it stays. If we return false,
it disappears.

Easy enough! Return `$note->getCreatedAt() > new \DateTime('-3 months');`:

[[[ code('6fbb440225') ]]]

Next, pass a new `recentNoteCount` variable into twig that's set to `count($recentNotes)`:

[[[ code('de8236b8bd') ]]]

In the template, add a new `dt` for `Recent Notes` and a `dd` with `{{ recentNoteCount }}`:

[[[ code('e6b4560097') ]]]

All right - give it a try! Refresh. Six notes - perfect: we clearly have a lot more
than six in total.

The `ArrayCollection` has lots of fun methods on it like this, including `contains()`,
`containsKey()`, `forAll()`, `map()` and other goodies.

## Don't Abuse ArrayCollection

Do you see any downsides to this? There's one big one: this queries for *all* of
the notes, even though we don't need them all. If you know you'll only ever have
a few notes, no big deal. But if you may have *many* notes: don't do this - you
*will* feel the performance impact of loading up hundreds of extra objects.

So what's the *right* way? Finally making a custom query that only returns the
`GenusNote` objects we need. Let's do that next.
