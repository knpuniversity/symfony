# Query across a JOIN (and Love it)

What about a JOIN query with Doctrine? Well, they're really cool.

Here's our *last* challenge. Go to `/genus`. Right now, this list is ordered by the
`speciesCount` property. Instead, I want to order by which genus has the most recent
note - a column that lives on an entirely different table.

In `GenusRepository`, the list page uses the query in `findAllPublishedOrderedBySize()`.
Rename that to `findAllPublishedOrderedByRecentlyActive()`:

[[[ code('9902da22ec') ]]]

Go change it in `GenusController` too:

[[[ code('08846c3911') ]]]

***TIP
PhpStorm has a great refactoring tool to rename everything automatically. Check out
the [Refactoring in PhpStorm][1] tutorial.
***

## Adding the Join

Let's go to work! Remove the `orderBy` line. We need to order by the `createdAt`
field in the `genus_note` table. And we know from SQL that we can't do that unless
we *join* over to that table. Do that with, `->leftJoin('genus')` - because that's
the alias we set on line 15 - `genus.notes`:

[[[ code('c066649201') ]]]

Why `notes`? This is the *property* name on `Genus` that references the relationship.
And just by mentioning it, Doctrine has all the info it needs to generate the full JOIN SQL.

## Joins and the Inverse Relation

Remember, this is the optional, *inverse* side of the relationship: we added this
for the convenience of being able to say `$genus->getNotes()`:

[[[ code('3e7a65447d') ]]]

And this is the *second* reason you might decide to map the inverse side of the relation:
it's required if you're doing a JOIN in this direction.

***TIP
Actually, not true! As Stof suggested in the comments on this page, it *is* possible
to query over this join *without* mapping this side of the relationship, it just
takes a little bit more work:

```php
$this->createQueryBuilder('genus')
    // ...
    ->leftJoin(
        'AppBundle:GenusNote',
        'genus_note',
        \Doctrine\ORM\Query\Expr\Join::WITH,
        'genus = genus_note.genus'
    )
    // ...
```
***

Back in `GenusRepository`, give `leftJoin()` a second argument: `genus_note` - this
is the alias we can use during the rest of the query to reference fields on the joined
`genus_note` table. This allows us to say `->orderBy('genus_note.createdAt', 'DESC')`:

[[[ code('b7609bb4d7') ]]]

That's it! Same philosophy of SQL joining... but it takes less work.

Head back and refresh! Ok, the order *did* change. Look at the first one - the top
note is from February 15th, the second genus has a note from February 11 and at the bottom,
the most recent note is December 21st. I think we got it!

Question: when we added the join, did it change what the query returned? Before,
it returned an array of `Genus` objects... but now, does it also return the joined
`GenusNote` objects? No: a join does *not* affect *what* is returned from the query:
we're still *only* selecting from the `genus` table. There's a lot more about that
in our [Doctrine Queries][2] tutorial.

Ok, that's it! That's everything - you are truly *dangerous* with Doctrine now.
Sure, there *are* some more advanced topics - like Doctrine events, inheritance
and `ManyToMany` relations - but we'll save those for another day. Get to work on
that project... or keep going with me to learn more Symfony! I promise, more bad
jokes - like worse than ever.

See you next time!


[1]: http://knpuniversity.com/screencast/phpstorm/refactoring
[2]: http://knpuniversity.com/screencast/doctrine-queries
