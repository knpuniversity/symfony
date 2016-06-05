# Custom Query in EntityType

As cool as it is that it's guessing my field type, I am actually going to add
`EntityType::class` to use this type *explicitly*:

[[[ code('580bdb0b92') ]]]

I don't *have* to do this: I just want to show you guys what a traditional setup
looks like.

Now, do *nothing* else and refresh. It'll still work, right? Right? Nope!

The required `class` option is missing! As I just finished saying, we *must* pass
a `class` option to the `EntityType`. We got away with this before, because when
it's `null`, Symfony guesses the form "type" *and* the `class` option.

Set the option to `SubFamily::class` - and alternate syntax to the normal `AppBundle:SubFamily`:

[[[ code('675bc4692a') ]]]

## The query_builder Option

Now that our form is put back together, I have a second challenge: make the select
order alphabetically. In other words, I want to customize the query that's made for
the SubFamily's and add an ORDER BY.

Head back to the `EntityType` docs. One option jumps out at me: `query_builder`.
Click to check it out. OK, it says:

> If specified, this is used to query the subset of options that should be used
  for the field.

And actually, I need to search for `query_builder`: I know there's a better example
on this page. Here it is!

So, if you pass a `query_builder` option and set it to an anonymous function, Doctrine
will pass that the *entity repository* for this specific entity. All we need to do
is create whatever query builder we want and return it.

In the form, add `query_builder` and enjoy that auto-completion. Set this to a
function with a `$repo` argument:

[[[ code('67725a5926') ]]]

Now, I like to keep all of my queries inside of repository classes because I don't
want queries laying around in random places, like in a form class. But, if you look, I don't
have a `SubFamilyRepository` yet.

No worries - copy the `GenusRepository`, paste it as `SubFamilyRepository`. Rename
that class and clear it out:

[[[ code('fdea2457f5') ]]]

Open the `SubFamily` entity and hook it up with `@ORM\Entity(repositoryClass="")`
and fill in `SubFamilyRepository`:

[[[ code('54da756385') ]]]

Great! Back in our form, we know this repo will be an instance of `SubFamilyRepository`:

[[[ code('d4941ee936') ]]]

Return `$repo->` and a new method that we're about to create called `createAlphabeticalQueryBuilder()`:

[[[ code('e2ef121c0e') ]]]

Copy that name and head into the repository to create that function. Inside, return
`$this->createQueryBuilder('sub_family'`) and then order by `sub_family.name`, `ASC`:

[[[ code('6d476262fa') ]]]

Done! The `query_builder` method points here, and we handle the query.

Alright, try it out! Nailed it! As far as form options go, we probably just conquered
one of the most complex.
