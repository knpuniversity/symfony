# Autowiring & Service Deprecations

Woo! There are only *two* deprecations left on the homepage... but they're weird!
And actually, they're *not* real! These are *false* deprecation warnings!

## Upgrade to the Symfony 3.3 services.yml Config!

In our [Symfony 3.3 Tutorial](https://knpuniversity.com/screencast/symfony-3.3),
we talked a lot about all the new service autowiring & auto-registration stuff. We
also upgraded our *old* `services.yml` file to use the new fancy config. It turns
out that doing this is one of the *biggest* steps in upgrading to Symfony 4 and Flex.
If you have *not* already upgraded your `services.yml` file to use autowiring & service
auto-registration, stop and go through the Symfony 3.3 tutorial *now*.

## Strict Autowiring Mode

The way that autowiring *works* changed in Symfony 4. In Symfony 3, when Symfony
saw a type-hint - like `EntityManager` - it would *first* look to see if there was
a service or alias in the container with that *exact* id: so `Doctrine\ORM\EntityManager`.
If there was *not*, it would then scan *every* service looking to see if any were
an instance of this class. That magic is gone.

In Symfony 4, it's simpler: autowiring *only* does the first part: if there is not
a service whose id is `Doctrine\ORM\EntityManager`,  it throws an exception. This
is a *great* change: the system is simpler and more predictable.

So, of course, if any of your autowiring depends on the old, deprecated logic,
you'll see a deprecation message. And yea, that's where *these* messages are coming
from!

But, there's a *better* way to find this deprecated logic. Open `app/config/config.yml`.
Under `parameters`, add `container.autowiring.strict_mode: true`.

This tells Symfony to use the simpler, Symfony 4-style autowiring logic right *now*.
Instead of deprecations, you'll see great big, beautiful errors when you try to refresh.

So... try it! Refresh the homepage. Woh! No errors! That's because we already fixed
all our old autowiring logic in the Symfony 3.3 tutorial. *And*... the 2 deprecation
messages are gone! Those were *not* real issues: it's a rare situation where the
deprecation system is misreporting.

## Services are now Private

So yes! This means that... drumroll... our homepage is ready for Symfony 4.0! But
the rest of the site might not be. Surf around to see what other deprecations we
can find. The login page looks ok: login with `weaverryan+1@gmail.com`, password
`iliketurtles`. Go to `/genus`... still no issues and then... ah! Finally, 1 deprecation
on the genus show page.

Check it out. Interesting:

> The "logger" service is private, getting it from the container is deprecated
> since Symfony 3.2. You should either make this service public or stop using
> the container directly.

Wow! This is coming from `GenusController` line 84. Go find it! Close a few files,
then open this one. Scroll down to 84. Ah! 

This is *really* important. Open `services.yml`. These days, all of our services
are *private* by default: `public: false`. This allows Symfony to optimize the
container and all it *really* means is that we *cannot* fetch these services directly
from the container. So `$container->get()` will *not* work.

In Symfony 4, this is even *more* important because a lot of *previously* public
services, like `logger`, are now *private*. Here's the point: you need to stop fetching
services directly form the container... everywhere. It's just *not* needed anymore.

## Fixing $container->get()

What's the solution? Since we're in a controller, add a `LoggerInterface $logger`
argument. Then, just `$logger->info()`.

Isn't that better anyways? As *soon* as we refresh the page... deprecation gone!

Where *else* are we using `$container->get()`? Let's find out! In your terminal,
run:

```terminal
git grep '\->get('
```

Ah, just two more! We may *not* need to change all of these... some services *are*
still public. But let's clean it all up!

Start in `SecurityController`. Ah, here it is. So: what type-hint should we use
to replace this? Well, you *could* just guess! Honestly, that works a lot. Or try
the brand new console command:

```terminal-silent
./bin/console debug:autowiring
```

Sweet! This is a *full* list of *all* type-hints you can use for autowiring. Search
for "authentication" and... there it is! This type-hint is an alias to the service
we want.

That means, back in `SecurityController`, delete this line and add a new
`AuthenticationUtils $authenticationUtils` argument. Done.

The last spot is in `UserController`: we're using `security.authentication.guard_handler`.
This time, let's guess the type-hint! Add a new argument: Guard... `GuardAuthenticationHandler`.
That's probably it! And if we're *wrong*, Symfony will tell us. Use that value below.

And yep, you *can* see the `GuardAuthenticationHandler` class in the `debug:autowiring`
list. But... what if it *weren't* there? What if we were trying to autowire a service
that was *not* in this list?

Well... you would get a *huge* error. And *maybe* you should ask yourself: is this
*not* a service I'm supposed to be using?

But anyways, if it's not in the list, there's a simple solution: go to `services.yml`
and add your *own* alias. At the bottom, paste the class you want to use as the
type-hint, then copy the service id, and say `@` and paste.

Yep, that is *all* you need to do in order to define your *own* autowiring rules.
Since we don't need it in this case, comment it out.

Ok, refresh! At this point, our goal is to hunt for deprecations until we're *pretty*
confident they're gone: it's not an exact science. If you have a test suite, you
can use the [symfony/phpunit-bridge](https://symfony.com/doc/current/components/phpunit_bridge.html)
to get a report of deprecated code paths that are hit in your tests.

## Adding $form->isSubmitted()

There is one more deprecation on the registration page. Look at the details:

> Call Form::isValid() on an unsubmitted form is deprecated. Use Form::isSubmitted()
> before Form::isValid().

This comes from `UserController`. Open that class and search for `isValid()`. Before
`$form->isValid()`, add `$form->isSubmitted()`. Find again and fix the other spot.
This isn't very important... you just need both in Symfony 4.

And now... I think we're done! All the deprecations I could find are *gone*.

It's time to upgrade to Symfony 4. Which, by the way, is the fastest Symfony version
ever! Zoom!
