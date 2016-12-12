# EntityType Checkboxes with ManyToMany

Guys, we are *really* good at adding items to our `ManyToMany` relationship in PHP
and via the fixtures. But what about via Symfony's form system? Yea, that's where
things get interesting.

Go to `/admin/genus` and login with a user from the fixtures: `weaverryan+1@gmail.com`
and password `iliketurtles`. Click to edit one of the genuses.

## Planning Out the Form

Right now, we don't have the ability to change which users are studying this genus
from the form.

If we wanted that, how would it look? It would probably be a list of checkboxes:
one checkbox for every user in the system. When the form loads, the already-related
users would start checked.

This will be *perfect*... as long as you don't have a *ton* of users in your system.
In that case, creating 10,000 checkboxes won't scale and we'll need a different
solution. But, I'll save that for another day, and it's not really that different.

## EntityType Field Configuration

The controller behind this page is called `GenusAdminController` and the form is
called `GenusFormType`. Go find it! Step one: add a new field. Since we ultimately
want to change the `genusScientists` property, that's what we should call the field.
The type will be `EntityType`:

[[[ code('b04ea918bd') ]]]

This is your go-to field type whenever you're working on a field that is mapped as *any*
of the Doctrine relations. We used it earlier with `subfamily`. In that case, each `Genus`
has only *one* `SubFamily`, so we configured the field as a select *drop-down*:

[[[ code('8d4cafe16a') ]]]

Back on `genusScientists`, start with the same setup: set class to `User::class`.
Then, because this field holds an *array* of `User` objects, set `multiple` to `true`.
Oh, and set `expanded` also to `true`: that changes this to render as checkboxes:

[[[ code('a847f7a5e0') ]]]

That's everything! Head to the template: `app/Resources/views/admin/genus/_form.html.twig`.
Head to the bottom and simply add the normal `form_row(genusForm.genusScientists)`:

[[[ code('87ef1809ea') ]]]

Guys, let's go check it out.

## Choosing the Choice Label

Refresh! And... explosion!

> Catchable Fatal Error: Object of class User could not be converted to string

Wah, wah. Our form is *trying* to build a checkbox for each `User` in the system...
but it doesn't know what field in `User` it should use as the display value. So, it
tries - and fails *epicly* - to cast the object to a string.

There's two ways to fix this, but I like to add a `choice_label` option. Set
it to `email` to use that property as the visible text:

[[[ code('845be65156') ]]]

Try it again. Nice!

As expected, three of the users are pre-selected. So, does it save? Uncheck Aquanaut3,
check Aquanaut2 and hit save. It does! Behind the scenes, Doctrine just deleted
one row from the join table and inserted another.

## EntityType: Customizing the Query

Our system really has *two* types of users: plain users and *scientists*:

[[[ code('5a404cac13') ]]]

Well, they're really not any different, except that some have `isScientist` set to true.
Now technically, I really want these checkboxes to *only* list users that are scientists:
normal users shouldn't be allowed to study Genuses.

How can we filter this list? Simple! Start by opening `UserRepository`: create
a new public function called `createIsScientistQueryBuilder()`:

[[[ code('6fa48e9aad') ]]]

Very simple: return `$this->createQueryBuilder('user')`, `andWhere('user.isScientist = :isScientist')`
and finally, `setParameter('isScientist', true)`:

[[[ code('bfd3d62dc5') ]]]

This doesn't make the query: it just returns the query builder.

Over in `GenusFormType`, hook this up: add a `query_builder` option set to an anonymous
function. The field will pass us the `UserRepository` object. That's so thoughtful!
That means we can celebrate with `return $repo->createIsScientistQueryBuilder()`:

[[[ code('3b90bc360b') ]]]

Refresh that bad boy! Bam! User list filtered.

Thanks to our `ManyToMany` relationship, hooking up this field was easy: it just *works*.
But now, let's go the *other* direction: find a user form, and add a list of genus
checkboxes. That's where things are going to go a bit crazy.
