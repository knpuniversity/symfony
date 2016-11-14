# ManyToMany & Fixtures

Head back to `/genus`. These genuses are coming from our fixtures, but, sadly, the
fixtures don't relate any scientists to them... yet. Let's fix that!

The `fixtures.yml` creates some `Genus` objects and some `User` objects, but nothing
links them together:

[[[ code('48c016a31e') ]]]

How can we do that? Well, remember, the fixtures system is very simple: it sets
each value on the given property. It also has a super power where you can use
the `@` syntax to reference another object:

[[[ code('07f7da379d') ]]]

In that case, that other *object* is set on the property.

Setting data on our `ManyToMany` is no different: we need to take a `Genus` object
and set an *array* of `User` objects on the `genusScientists` property. In other words,
add a key called `genusScientists` set to `[]` - the array syntax in YAML. Inside,
use `@user.aquanaut_1`. That refers to one of our `User` objects below. And whoops,
make sure that's `@user.aquanaut_1`. Let's add another: `@user.aquanaut_5`:

[[[ code('1d470793a2') ]]]

It's not very random... but let's try it! Find your terminal and run:

```bash
./bin/console doctrine:fixtures:load
```

Ok, check out the `/genus` page. Now *every* genus is related to the same two users.

## Smart Fixtures: Using the Adder!

But wait... that should *not* have worked. The `$genusScientists` property - like
*all* of these properties is *private*. To set them, the fixtures library uses
the setter methods. But, um, we don't have a `setGenusScientists()` method, we only
have `addGenusScientist()`:

[[[ code('9994d3fdeb') ]]]

So that's just another reason why the Alice fixtures library *rocks*. Because it
says:

> Hey! I see an `addGenusScientist()` method! I'll just call that twice instead of
> looking for a setter.

## Randomizing the Users

The only way this could be more hipster is if we could make these users random. Ah,
but Alice has a trick for that too! Clear out the array syntax and instead, in quotes,
say `3x @user.aquanaut_*`:

[[[ code('ab037f2c96') ]]]

Check out that wonderful Alice syntax! It says: I want you to go find *three* random
users, put them into an array, and *then* try to set them.

Reload those fixtures!

```bash
./bin/console doctrine:fixtures:load
```

Then head over to your browser and refresh. Cool, three random scientists for each
Genus. Pretty classy Alice, pretty classy.
