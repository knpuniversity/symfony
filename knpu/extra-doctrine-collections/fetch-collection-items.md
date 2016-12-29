# Fetching Items from a ManyToMany Collection

New mission! On the genus show page, I want to list all of the users that are studying
this `Genus`. If you think about the database - which I told you *NOT* to do, but
ignore me for a second - then we want to query for all users that appear in the
`genus_scientist` join table for this `Genus`.

Well, it turns out this query happens automagically, and the matching users are
set into the `$genusScientists` property. Yea, Doctrine just does it! All *we* need
to do is expose this private property with a getter: `public function, getGenusScientists()`,
then `return $this->genusScientists`:

[[[ code('7c61421240') ]]]

Now, open up the `show.html.twig` genus template and go straight to the bottom
of the list. Let's add a header called `Lead Scientists`. Next, add a `list-group`,
then start looping over the related users. What I mean is:
`for genusScientist in genus.genusScientists`, then `endfor`:

[[[ code('d65adc9a0e') ]]]

The `genusScientist` variable will be a `User` object, because `genusScientists`
is an *array* of users. In fact, let's advertise that above the `getGenusScientists()`
method by adding `@return ArrayCollection|User[]`:

[[[ code('aee31a0947') ]]]

We know this *technically* returns an `ArrayCollection`, but we *also* know that
if we loop over this, each item will be a `User` object. By adding the `|User[]`,
our editor will give us auto-completion when looping. And that, is pretty awesome.

Inside the loop, add an `li` with some styling:

[[[ code('ae1ab3368e') ]]]

Then add a link. Why a link? Because before this course, I created a handy-dandy
user *show* page:

[[[ code('b2403f79c2') ]]]

Copy the `user_show` route name, then use `path()`, paste the route, and pass it
an `id` set to `genusScientist.id`, which *we* know is a `User` object.
Then, `genusScientist.fullName`:

[[[ code('3ecdc4f726') ]]]

Why `fullName`? If you look in the `User` class, I added a method called `getFullName()`,
which puts the `firstName` and `lastName` together:

[[[ code('6c5df24cb6') ]]]

It's really not that fancy.

Time for a test drive! When we refresh, we get the header, but this `Genus` doesn't
have any scientists. Go back to `/genus/new` to create a more interesting `Genus`.
Click the link to view it. Boom! How many queries did *we* need to write to make
this work? None! That's right - we are keeping lazy.

But now, click to go check out the *user* show page. What if we want to do the *same*
thing here? How can we list all of the *genuses* that are studied by this `User`?
Time to setup the *inverse* side of this relationship!
