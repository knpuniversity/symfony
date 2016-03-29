# Querying on a Relationship

We need to create a query that returns the GenusNotes that belong to a specific
`Genus` *and* are less than 3 months old. To keep things organize, custom queries
to the `GenusNote` table should live in a `GenusNoteRepository`. Ah, but we don't
have one yet! No problem: copy `GenusRepository.php` to `GenusNoteRepository.php`,
rename the class and clear it out:

[[[ code('e9a657dccc') ]]]

Add a new `public function findAllRecentNotesForGenus()` and give this a `Genus`
argument:

[[[ code('d8bc537af0') ]]]

Excellent! And just like before - start with `return $this->createQueryBuilder()`
with `genus_note` as a query alias. For now, don't add anything else: finish with
the standard `->getQuery()` and `->execute()`:

[[[ code('3cbffbc30e') ]]]

Doctrine doesn't know about this new repository class yet, so go tell it! In
`GenusNote`, find `@ORM\Entity` and add `repositoryClass="AppBundle\Repository\GenusNoteRepository"`:

[[[ code('3b336175eb') ]]]

Finally, use the new method in `GenusController` -
`$recentNotes = $em->getRepository('AppBundle:Genus')->findAllRecentNotesForGenus()`
and pass it the `$genus` object from above:

[[[ code('52aa8cd4be') ]]]

Obviously, we're not done yet - but it should at least *not* break. Refresh. Ok,
100 recent comments - that's perfect: it's returning *everything*. Oh, you know
what isn't perfect? My lame typo - change that to the word `Recent`. Embarrassing
for me:

[[[ code('bf36a79af4') ]]]

## Using the Relationship in the Query

Head back to the repository. This query is pretty simple actually: add
an `->andWhere('genus_note.genus = :genus')`. Then, fill in `:genus` with
`->setParameter('genus', $genus)`:

[[[ code('71c71ad0fb') ]]]

This a simple query - equivalent to `SELECT * FROM genus_note WHERE genus_id = `
some number. The only tricky part is that the `andWhere()` is done on
the `genus` property - not the `genus_id` column: you *always* reference
property names with Doctrine.

Finish this with another `andWhere('genus_note.createdAt > :recentDate')` and
`->setParameter('recentDate', new \DateTime('-3 months'))`:

[[[ code('a142925c30') ]]]

Perfect! Go back and try it - the count *should* go back to 6. There we go! But now,
instead of fetching *all* the notes just to count some of them, we're only querying
for the ones we need. *And*, Doctrine *loves* returning objects, but you could make
this even *faster* by returning *only* the count from the query, instead of the
objects. Don't optimize too early - but when you're ready, we cover that in our
[Going Pro with Doctrine Queries][1].


[1]: http://knpuniversity.com/screencast/doctrine-queries
