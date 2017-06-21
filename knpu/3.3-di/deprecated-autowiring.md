# Autowiring Deprecations

On the web debug toolbar, I've got a little yellow icon that says 10 deprecation
warnings. Rude! Let's click that!

These are all the ways that my code is using old, deprecated, uncool functionality. It's
basically a list of stuff we need to update before upgrading to Symfony 4. And there
are a few deprecations related to autowiring:

> Autowiring services based on the types they implement is deprecated since
> Symfony 3.3 and won't be supported in version 4.0. You should rename or
> alias `security.user_password_encoder.generic` to ... long class name...
> `UserPasswordEncoder` instead.

***TIP
The text in the deprecation may look slightly different for you: we updated it
to be a bit more clear in Symfony 3.3.1.
***

Um... what?????

This is saying that *somewhere*, we are type-hinting an argument with
`Symfony\Component\Security\Core\Encoder\UserPasswordEncoder`... but there is *no*
service in the container with that exact *id*. So, autowiring got busy: it looked
at *every* service and found exactly *one* - `security.user_password_encoder.generic` -
that has this class. It passed *this* service to that argument.

And *that* is the part of autowiring that is deprecated. Looking across every service
for a matching class or interface was a little more magic than we wanted in Symfony.

How do we fix this? Actually, there are *two* solutions!

## Solution 1) Fixing the Type-Hint

Here's the first question: is there a different type-hint that we should be using
instead for this service? Let's find out!

Head to your terminal. We already know about the `debug:container` command:

```terminal
php bin/console debug:container
```

This gives us a big list of every *public* service in the container. The blue text
is the *id* of each service. But guess what? Service id's are *much* less important
in Symfony 3.3... because we almost always rely on type-hints and autowiring.

Re-run the command again with a new `--types` option:

```terminal
php bin/console debug:container --types
```

Voilà! This is a list of all valid type-hints that you can use for autowiring. This
is *awesome*. If you search for "encoder", you'll find one called `UserPasswordEncoderInterface`.
*This* is the type-hint we should use! Symfony ships with this alias to enable autowiring.

Cool! Let's find out where we're using this:

```terminal
git grep UserPasswordEncoder
```

Two places: `HashPasswordListener` and `LoginFormAuthenticator`. Open up `HashPasswordListener`.
Then, add `Interface` to the end of the `use` statement, and also the type-hint:

[[[ code('2a210cdc27') ]]]

That's it.

Open up `LoginFormAuthenticator` and do the exact same thing: update the `use`...
and the argument:

[[[ code('5f0a89ed27') ]]]

Ok, go back to the browser! Refresh, and watch those 10 deprecations. Bam! 8 deprecations!

If you check the list now, we still have *one* more autowiring deprecation. This
time, apparently, it's unhappy about an `EntityManager` type-hint.

Same question as before: is there a better type-hint to use? Let's find out:

```terminal
php bin/console debug:container --types
```

Search for EntityManager and... boom! There is an `EntityManagerInterface` alias.
*This* is the officially supported type-hint.

## Solution 2: Adding an Alias

Ok, we know the fix: update our `EntityManager` type hints to `EntityManagerInterface`!
But... there's another solution! If you want, it is *totally* ok to type-hint `EntityManager`.
To make this work with autowiring, we can create an *alias*.

Copy the `Doctrine\ORM\EntityManager` class name. Then, find your editor and open
up `services.yml`. Add the alias: `Doctrine\ORM\EntityManager` aliased to `@`,
and then copy the target service id: `@doctrine.orm.default_entity_manager`:

[[[ code('f444c2c274') ]]]

We have *full* control over autowiring. With aliases, we can configure *exactly*
which service we want to use for each type-hint. No magic.

Ok, refresh the page one more time! Got it! 8 deprecations now down to 7. The rest
of the deprecations are related to other parts of our code. I'll leave those as 
homework.
