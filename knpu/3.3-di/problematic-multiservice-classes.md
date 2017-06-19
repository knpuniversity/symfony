# Problematic Multi-Class Services

Since autowiring works by finding a service whose id exactly matches the type-hint,
it means that in the future, if someone type-hints `MessageGenerator` as an argument,
this *first*, auto-registered service will be used! And actually, in this case, that's
not a *huge* problem: `MessageGenerator` has a required constructor argument:

[[[ code('ddd7ecf093') ]]]

So our app would explode with an exception. But still, that's a little unexpected...
we really *don't* want this third service.

## Fix 1) Don't auto-register the Service

There are three ways to fix this, depending on your app. First, you can explicitly
exclude it. At the end of `exclude`, add `Service/MessageGenerator.php`:

[[[ code('5b24b8a7d0') ]]]

Now, go back to your terminal:

```terminal
php bin/console debug:container --show-private
```

Boom! Back to just the two services. And because neither id is set to the class name,
if someone tries to autowire using the `MessageGenerator` type-hint, they'll see
a clear exception asking them to explicitly wire the value they want for that argument.
In other words, `MessageGenerator` cannot be used for autowiring... but that's ok!

## Fix 2) Choose one Service for Autowiring

Another solution is to choose one of your services to be the one that's used for
autowiring. For example, suppose the `app.encouraging_message_generator` is used
*much* more often, so you want that to be autowired for the `MessageGenerator` type-hint:

[[[ code('ed1bb0fc67') ]]]

Cool! Copy the old service id. Then, open `legacy_aliases.yml` and do the same thing
we did before. I'll use the class as the service id, then setup an alias:

[[[ code('54445b1a55') ]]]

[[[ code('d20085d718') ]]]

We *still* have two services in the container for the same class. But the first will
be used for autowiring. If you need to pass the second instance as an argument, you'll
need to explicitly configure that. We'll see how in a few minutes.

## Fix 3) Refactor to a Single Class

The final option - which is really practical, but a bit more controversial - is to
refactor your application to avoid this situation. For example, if you downloaded
the start code, you should have a `tutorial/` directory with a `MessageManager.php`
file inside. Copy that and paste it into the `Service/` directory:

[[[ code('a37c1d1b60') ]]]

This class has two arguments - `$encouragingMessages` and `$discouragingMessages` - and
a method to fetch a message from each. It's basically a combination of our two `MessageGenerator`
services.

Technically, this class is already registered as a service. But of course, these
two arguments can't be autowired. So, configure the service explicitly:
`AppBundle\Service\MessageManager:` and under `arguments`, pass the encouraging
messages and the discouraging messages:

[[[ code('f1850af135') ]]]

Now that we have `MessageManager`, let's *remove* all the `MessageGenerator` stuff
completely! Copy the old discouraging service id. Then, search for it:

```terminal
git grep app.discouraging_message_generator
```

Ah, this is *only* used in `GenusAdminController`. In fact, both `MessageGenerator`
services are *only* used there. Let's use the new `MessageManager` service - which
I've *purposely* made public for now:

[[[ code('53aaa02b2a') ]]]

In `GenusAdminController`, use that: `$this->get(MessageGenerator::class)->getEncouragingMessage()`:

[[[ code('43ce871c5a') ]]]

Then the same below: `$this->get(MessageGenerator::class)->getDiscouragingMessage()`:

[[[ code('923573d6f0') ]]]

Time to celebrate! Delete the discouraging service, and go remove the legacy alias
too: neither is being used. This refactoring was optional, but it makes life a little
bit easier: I can now safely type-hint any argument with `MessageManager` and let
autowiring do its magic.

*And*, our app isn't broken, which is always nice. Oh, and I'll delete the unused
`MessageGenerator` class. 

Next, we'll try out a special new type of dependency injection for controllers and
clean up the rest of our service config.
