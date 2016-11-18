# Joining Across a ManyToMany + EXTRA_LAZY Fetch

On the genus list page, I want to add a new column that prints the *number* of scientists
each `Genus` has. That should be simple!

Open the `genus/list.html.twig` template. Add the new `th` for number of scientists:

[[[ code('af6b9a6195') ]]]

Then down below, add the `td`, then say `{{ genus.genusScientists|length }}`:

[[[ code('cfb27739a6') ]]]

In other words: 

> Go out and get my array of genus scientists and count them!

And, it even works! Each genus has three scientists. Until we delete one, then
only *two* scientists! Yes!

## The Lazy Collection Queries

But now click the Doctrine icon down in the web debug toolbar to see how the queries
look on this page. This is really interesting: we have one query that's repeated
many times: it selects *all* of the fields from `user` and then INNER JOINs over to
`genus_scientist` WHERE `genus_id` equals 29, then, 25, 26 and 27.

When we query for the `Genus`, it does *not* automatically *also* go fetch all the
related Users. Instead, at the moment that we access the `genusScientists` property,
Doctrine queries all of the `User` data for that `Genus`. We're seeing that query
for each row in the table.

## Fetching EXTRA_LAZY

Technically, that's a lot of extra queries... which *could* impact performance.
But please, don't hunt down *potential* performance problems too early - there are
far too many good tools - like NewRelic and Blackfire - that are far better at identifying
*real* performance issues later.

But, for the sake of learning... I want to do better, and there are a few possibilities!
First, instead of querying for *all* the user data *just* so we can count the users,
wouldn't it be better to make a super-fast COUNT query?

Yep! And there's an awesome way to do this. Open `Genus` and find the `$genusScientists`
property. At the end of the `ManyToMany`, add `fetch="EXTRA_LAZY"`:

[[[ code('3f88104321') ]]]

That's it. Now go back, refresh, and click to check out the queries. We still have
the same *number* of queries, but each row's query is now just a simple count.

That's freaking awesome! Doctrine knows to do this because it realizes that all we're
doing is *counting* the scientists. But, if we were to actually loop over the scientists
and start accessing data on each `User` - like we do on the genus show page - then
it would make a full query for all the `User` data. Doctrine is really smart.

## Joining for Less Queries

Another way to optimize this would be to try to *minimize* the number of queries.
Instead of running a query for every row, couldn't we grab *all* of this data at
once? When we originally query for the genuses, what if we joined over to the `user`
table *then*, and fetched all of the users immediately?

That's totally possible, and while it might actually be *slower* in this case, let's
find out how to do join across a `ManyToMany` relationship. Open `GenusController`
and find `listAction()`. Right now, this controller calls a
`findAllPublishOrderedByRecentlyActive()` method on `GenusRepository` to make the
query:

[[[ code('ff410eb8f5') ]]]

Go find that method! Here's the goal: modify this query to join to the middle
`genus_scientist` table and then join again to the `user` table so we can select
all of the user data. But wait! What's the number one rule about `ManyToMany` relationships?
That's right: you need to pretend like the middle join table doesn't exist.

Instead, `leftJoin()` directly to `genus.genusScientists`. Alias that to `genusScientist`:

[[[ code('ee55dd414d') ]]]

When you JOIN in Doctrine, you always join on a relation property, like `$genusScientists`.
Doctrine will automatically take care of joining across the middle table and then
over to the `user` table.

To select the user data: `addSelect('genusScientist')`:

[[[ code('5b22ff9f7a') ]]]

Ok, go back and refresh again! Woh, *one* query! And that query contains a `LEFT JOIN`
to `genus_scientist` and another to `user`. Because we're fetching *all* the user
data in this query, Doctrine avoids making the COUNT queries later.

If Doctrine JOINS are still a bit new to you, give yourself a head start with our
[Doctrine Queries Tutorial][doctrine_queries].


[doctrine_queries]: https://knpuniversity.com/screencast/doctrine-queries
