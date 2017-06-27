# RAD with Symfony 3.3

We've done a *lot* of work, and I showed you the *ugliest* parts of the new system
so that you can solve them in your project. That's cool... but so far, coding hasn't
been much fun!

And that's a shame! Once you're done upgrading, using the new configuration system
is a *blast*. Let's take it for a legit test drive.

## Creating an Event Subscriber

Here's the goal: create an event listener that adds a header to every response.
Step 1: create an `EventSubscriber` directory - though this could live anywhere -
and a file inside called `AddNiceHeaderEventSubscriber`:

[[[ code('966ad97377') ]]]

Event subscribers always look the same: they must implement `EventSubscriberInterface`:

[[[ code('723001e566') ]]]

I'll go to the Code-Generate menu, or `Command`+`N` on a Mac - and select "Implement Methods"
to add the one required function: `public static getSubscribedEvents()`:

[[[ code('8e359c95f6') ]]]

To listen to the `kernel.response` event, return `KernelEvents::RESPONSE` set to
`onKernelResponse`:

[[[ code('45455ea41e') ]]]

On top, create that method: `onKernelResponse()` with a `FilterResponseEvent` object:
that's the argument passed to listeners of *this* event:

[[[ code('0240db0ce1') ]]]

Inside, add a header: `$event->getResponse()->headers->set()` with `X-NICE-MESSAGE`
set to `That was a great request`:

[[[ code('a191e88792') ]]]

Ok, we've touched only *one* file and written 23 lines of code. And... we're done!
Yep, this will *already* work. I'll open up my network tools, then refresh one more
time. For the top request, click "Headers", scroll down and... there it is! We just
added an event subscriber to Symfony... by *just* creating the event subscriber.
Yea... it kinda makes sense.

The new class was automatically registered as a service and automatically tagged
thanks to autoconfigure. 

## Grab some Dependencies

But what if we want to log something from inside the subscriber? What type-hint
should we use for the logger? Let's find out! Find your terminal and run:

```terminal
php bin/console debug:container --types
```

And search for "logger". Woh, nothing!? So, there is no way to type-hint the logger
for autowiring!?

Actually... since the autowiring stuff is new, some bundles are still catching up
and adding aliases for their interfaces. An alias *has* been added to MonologBundle...
but only in version 3.1. In `composer.json`, I'll change its version to `^3.1`:

[[[ code('86260a2eec') ]]]

Then, run:

```terminal
composer update
```

to pull down the latest changes.

If you have problems with other bundles that don't have aliases yet... don't panic!
You can always add the alias yourself. In this case, the type-hint should be
`Psr\Log\LoggerInterface`, which you could alias to `@logger`:

```yaml
services:
    # ...
    Psr\Log\LoggerInterface: '@logger'
```

You always have full control over how things are autowired.

Ok, done! Let's look at the types list again:

```terminal
php bin/console debug:container --types
```

There it is! `Psr\Log\LoggerInterface`.

Back in the code, add `public function __construct()` with a `LoggerInterface $logger`
argument:

[[[ code('9591bbbb8c') ]]]

I'll hit `Option`+`Enter` and initialize my field:

[[[ code('9d1a525be4') ]]]

That's just a shortcut to add the property and set it.

In the main method, use the logger: `$this->logger->info('Adding a nice header')`:

[[[ code('cbb1b52127') ]]]

Other than the one-time composer issue, we've *still* only touched *one* file. Find
your browser and refresh. I'll click one of the web debug toolbar links at the
bottom and then go to "Logs". There it is! Autowiring passes us the logger without
any configuration.

## Adding more Arguments

Let's keep going! Instead of hard-coding the message, let's use our `MessageManager`.
Add it as a second argument, then create the property and set it like normal:

[[[ code('c2b72ea55c') ]]]

In the method, add `$message = $this->messageManager->getEncouragingMessage()`.
Use that below:

[[[ code('36ad09e185') ]]]

Once again, autowiring will work with zero configuration. The `MessageManager`
service id is equal to its class name... so autowiring works immediately:

[[[ code('d746e40369') ]]]

Refresh to try it! Click the logs icon, go to "Request / Response", then the "Response"
tab. Yea! This is another way to see our response header.

Say hello to the new workflow: focus on your business logic and ignore configuration.
*If* you *do* need to configure something, let Symfony tell you.

## Manually Wiring when Necessary

Let's see an example of that: add a third argument: `$showDiscouragingMessage`. I'll
use `Alt`+`Enter` again to set this on a new property:

[[[ code('8919e91c88') ]]]

This argument is *not* an object: it's a boolean. And that means that autowiring
*cannot* guess what to put here.

But... ignore that! In `onKernelResponse()`, add some logic: if
`$this->showDiscouragingMessage`, then call `getDiscouragingMessage()`. Else,
call `getEncouragingMessage()`:

[[[ code('8ab5786b0d') ]]]

Just like before, we're focusing *only* on this class, not configuration. And this
class is done! So, let's try it! Error!

> Cannot autowire service `AddNiceHeaderEventSubscriber`: argument `$showDiscouragingMessage`
> of method `__construct()` must have a type-hint or be given a value explicitly.

Yes! Symfony can automate *most* configuration. And as soon as it *can't*, it will
tell you *what* you need to do.

Copy the class name, then open `services.yml`. To explicitly configure this service,
paste the class name and add `arguments`. We *only* need to specify `$showDiscouragingMessage`.
So, add `$showDiscouragingMessage: true`:

[[[ code('e4b9288e2c') ]]]

Refresh now! The error is gone! And in the profiler... yep! The message is much
more discouraging. Boooo.

Ok guys that is it! Behind the scenes, the way that you configure services is still
the same: Symfony *still* needs to know the class name and arguments of every service.
But before Symfony 3.3, all of this *had* to be done explicitly: you needed to register
every single service and specify every argument and tag. But if you use the new
features, *a lot* of this is automated. Instead of filling in *everything*, only
configure what you need.

And there's *another* benefit to the new stuff. Now that our services are *private* -
meaning, we no longer use `$container->get()` - Symfony will give us more immediate
errors *and* will automatically optimize itself. Cool!

Your turn to go play! I hope you love this new stuff: faster development without
a ton of WTF moments! And let me know what you think!

All right guys, see you next time.
