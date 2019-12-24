# Flex Extras

Now that we're on Symfony 4 with Flex, I have *three* cool things to show you.

## Repositories as a Service

Start by opening `GenusController`: find `listAction`. Ah yes: this is a very
classic setup: get the entity manager, get the repository, then call a method on it.

One of the annoying things is that - unless you add a bunch of extra config - repositories
are *not* services and can *not* be autowired. Boo!

Well... that's not true anymore! Want your repository to be a service? Just make
two changes. First, extend a new base class: `ServiceEntityRepository`.

[[[ code('57b4a51eb4') ]]]

And second, override the `__construct()` function. But remove the `$entityClass`
argument.

***TIP
Make sure the type-hint for the first argument is RegistryInterface not ManagerRegistry.
***

In the parent call, use `Genus::class`.

[[[ code('2da79bf613') ]]]

That might look weird at first... but with those *two* small changes, your repository
is *already* being auto-registered as a service! Yep, back in `listAction`, add
a new argument: `GenusRepository $genusRepository`. Use that below *instead* of
fetching the `EntityManager`.

[[[ code('26b9f5edbc') ]]]

And that's it! Go to that page in your browser: `/genus`. Beautiful! Make that same
change to your other repository classes when you want to.

## Fixtures as Services

Ok, cool thing #2: our fixtures are broken. Well... that's not the cool part. They're
broken because we removed Alice, so everything explodes:

But, there's even *more* going on. Find your `composer.json` file and make sure
the version constraint is `^3.0`. 

[[[ code('4d22be56ac') ]]]

Then, run:

```terminal
composer update doctrine/doctrine-fixtures-bundle
```

Version 3 of this bundle is *all* new... but not in a "broke everything" kind of
way. Before, fixture classes were loaded because they lived in an *exact* directory:
usually `DataFixtures\ORM` in your bundle. And if you needed to access services,
you extended `ContainerAwareFixture` and fetched them directly from the container.

Well, no more! In the new version, your fixtures are *services*, and so they act
like *everything* else. You can even put them *anywhere*.

When Composer finishes, download one more package:

```terminal
composer require fzaninotto/faker
```

***TIP
Even better would be `composer require fzaninotto/faker --dev`!
***

This isn't needed by DoctrineFixturesBundle, but we *are* going to use it. In fact,
if you downloaded the course code, you should have a `tutorial/` directory with
an `AllFixtures.php` file inside. Copy that and put it directly into `DataFixtures`.

[[[ code('d28f1ae701') ]]]

Then, delete the old ORM directory. This is our new fixture class: all we need to
do is extend `Fixture` from the bundle, and the command instantly recognizes it.
If you need services, just add a constructor and use autowiring!

Let's go check on Faker. Ah, it's done! Inside the class, Faker allows me to generate
really nice, random values. Does it work? Reload the fixtures:

```terminal-silent
./bin/console doctrine:fixtures:load
```

It sees our class immediately and... it works! Fixtures are services... and they
work great.

## MakerBundle

Ready for one last cool thing? Run:

```terminal
composer require maker --dev
```

This installs the MakerBundle: Symfony's new code generator. Code generation is
of course optional. But with this bundle, you'll be able to develop new features
faster than ever. Need a console command, an event subscriber or a Twig extension?
Yep, there's a command for that.

What's everything it can do? Run:

```terminal
./bin/console list make
```

Right now, it has about 10 commands - but there are a lot more planned: this bundle
is only about 1 month old!

Let's try one of these commands!

```terminal
./bin/console make:voter
```

Call it `RandomAccessVoter`: we'll create a voter that randomly gives us access.
Fun! Open the new class in `src/Security/Voter`. This comes pre-generated with
real-world example code. In `supports()`, return `$attribute === 'RANDOM_ACCESS'`.
Our voter will vote when someone calls `isGranted()` with `RANDOM_ACCESS`.

[[[ code('0f048474d7') ]]]

Then, for `voteOnAttribute()`, return `random_int(0, 10) > 5`.

[[[ code('dca5ba5a9b') ]]]

Now we need to go and update some configuration, right? No! This class is *already*
being used! Open `GenusController` and... above `newAction()`, add `@IsGranted("RANDOM_ACCESS")`.

[[[ code('d4abf8b6e3') ]]]

Done! Try it: go to `/genus/new`. Ha! It sent us to the login page - that proves
its working. Login with `iliketurtles` and... access granted! Refresh - granted!
Refresh - denied!

All that by running 1 command and changing about 3 lines. Welcome to Symfony 4.

## Let's go Symfony 4!

Hey, we're done! Upgrading to the Flex structure *is* work, but I hope you're
as happy as I am about the result! To go further with Flex and Symfony 4, check
out our [Symfony Track](https://knpuniversity.com/tracks/symfony): we're going to
*start* a project with Flex and *really* do things right.

All right guys. Seeya next time!
