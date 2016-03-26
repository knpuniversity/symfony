# Order By with a OneToMany

Let's finish this! Ultimately, we need to create the same `$notes` structure, but
with the *real* data. Above the `foreach` add a new `$notes` variable. Inside, add
a new entry to that and start populating it with `id => $note->getId()`:

[[[ code('e4fff8d718') ]]]

Hey! Where's my autocompletion on that method!? Check out the `getNotes()` method in
`Genus`. Ah, there's no `@return` - so PhpStorm has no idea what that returns. Sorry
PhpStorm - my bad. Add some PhpDoc with `@return ArrayCollection|GenusNote[]`:

[[[ code('cdeb3602ff') ]]]

This will autocomplete any methods from `ArrayCollection` *and* auto-complete
from `GenusNote` if we loop over these results.

*Now* we get autocompletion for `getId()`. Next, add `username => $note->getUsername()`
and I'll paste in the other fields: `avatarUri`, `note` and `createdAt`. Ok, delete
that hardcoded stuff!

[[[ code('e4fb324f79') ]]]

Deep breath: moment of truth. Refresh! Ha! There are the 15 beautiful, random notes,
courtesy of the AJAX request, Alice and Faker.

## Ordering the OneToMany

But wait - the order of the notes is weird: these should really be ordered from newest
to oldest. That's the *downside* of using the `$genus->getNotes()` shortcut: you
can't customize the query - it just happens magically in the background.

Well ok, I'm lying a *little* bit: you *can* control the order. Open up `Genus`
and find the `$notes` property. Add another annotation: `@ORM\OrderBy` with
`{"createdAt"="DESC"}`:

[[[ code('4c34a9eb92') ]]]

I know, the curly-braces and quotes look a little crazy here: just Google this
if you can't remember the syntax. I do!

Ok, refresh! Hey! Newest ones on top, oldest ones on the bottom. So we do have *some*
control. But if you need to go further - like only returning the GenusNotes that
are less than 30 days old - you'll need to do a little bit more work.
