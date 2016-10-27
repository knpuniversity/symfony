# Adding to a ManyToMany

The question now is: how do we add things to this join table? How do we actually
join a `Genus` and a user together? The complicated thing about doctrine
in this type of a relationship is, you need to basically forget that there's a
join table. Your only job is to set the user objects onto this genus
scientist's property, and save. If we do that, then doctrine will handle adding
and deleting rows from that join table automatically without us worrying about
it.

Let's see how. Open up your genus controller. You guys remember this new action
here? This isn't a real page. This is just a page where we're messing around
adding some entities and saving them, just so we can see what happens when we
do that. Right now we have a genus. This genus is not related to any users, so
let's relate it to a user. We'll do it by saying, by first querying for a user
object, with user=emgetrepsitory@bundleuser then find one by e-mail set to
aquanaut1@example.org. This is just dummy code and that works because in our
fixtures file, you'll notice at the bottom all these scientists are aquanauts
then 1-10 @example.org.

That should find a user and then the question is: how do we set that user on
that genus? Right now the genus scientist, we didn't add a get or a setter for
it, so there's not way to set this externally, so let's add a way. I'm going to
add a public function: add genus scientist. This is going to accept a user
argument and very simply, we're going to use that genus scientist property like
an array and add the user to it and that's it. Then in our controller, we can
say: genus arrow add genus scientist [in pass 00:02:06] at user and we are
done. We don't need to persist anything else because we are already persisting
the genus down here.

Let's try it. You were on this page as /genus/new. Hit that. It says genus
created, octopus15. I'll head over to my terminal. Run [inaudible 00:02:41]
console doctrine query.sql just so I can run some queries against my database.
You can do this however you want using phpMyAdmin or MySQL directly. Say select
star from genus scientist, that join table. Just like that, we have a genus
joined to a user. The genus of ID 11, which is the octopus15 that was just
added and the user ID by pure chance, is also ID 11. If we search of that, it
is in fact, aquanaut1@example.org. That's it guys. If you want to add something
to that middle table, you don't need to worry about creating or inserting
anything. You just need to make sure you set the user on that genus.

Check this out. What if I did this? What if I duplicated this so I tried to
have one genus, one new genus, but I tried to add the same user to it twice? In
theory that shouldn't be allowed because a genus and a user should only be able
to be related once. That joined table should be unique. Refresh this now. You
actually see this does get kicked out from the database. Insert into genus
scientist, duplicate entry 12-11. What it's saying is, Hey, you can't insert
two rows into this table at the same genus and the same user. To avoid that in
case we make mistakes like this, in our add genus scientist method, we'll just
prevent this. It's really easy, you can say: if this arrow genus arrow
scientist arrow contains ... Remember, the genus scientist is actually an array
collection object so it has really cool methods on it like contains. We can
pass at user. If it already has user, just return.

Now when we go back and refresh, no problems. It just created that one joined
table entry. If you go back and query genus scientist now, you'll see the first
one we created and the second one that we just created. Inserting is done, so
next let's look into how we can actually set up, how we can read this
information, and also how we can set up the very, sometimes confusing, inverse
side of this relationship.
