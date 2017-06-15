# Understanding Autowiring Logic

All this auto-registration stuff works smoothly: unused services are removed, you
can override a service to configure it further, and if there are any problems
autowiring a service, you get a clear exception when you try to load *any* page.

But, there's one place where it's not as clean: when you have multiple services
that point to the same class:

[[[ code('d0e887ce6d') ]]]

In other words, when you have services where the id *can't* be the class name.
Right now, there are *two* services for the `MessageGenerator` class, right?
Actually, there are *three*.

Find your terminal and run:

```terminal
php bin/console debug:container --show-private | grep Message
```

Surprise! This lists our two services *plus* a third service that was automatically
registered. Now technically, that's not a problem. Nobody is referencing the new
auto-registered service, so it's removed. But, it *may* cause an issue with autowiring
in the future.

## How Autowiring Works

First, we need to talk about how autowiring works. It's *super* simple... or at least,
it *will* be simple in Symfony 4.

Let's look at `HashPasswordListener`. As you can see, this is type-hinted with
`UserPasswordEncoder`:

[[[ code('c2bfcce746') ]]]

In `services.yml`, this argument is *not* specified:

[[[ code('42a5b98f74') ]]]

It works because the container is autowiring it.

But how does it know *which* service to pass here? First, autowiring looks for a
service whose id *exactly* matches the type-hint. In other words, it looks for a
service whose id is `Symfony\Component\Security\Core\Encoder\UserPasswordEncoder`:

[[[ code('9eefd4aea8') ]]]

If that exists, it's used... always. This is the *main* way that autowiring works.
It's not magic: you explicitly configure a service or alias for each type-hint.

That's also why we started using class names as our service ids: this allows all
of our services to be autowired into other classes.

Before we keep going: I want to repeat this *one* more time: autowiring works by
looking for a service - or alias - whose id exactly matches the type-hint. It's
that simple.

I wanted to repeat that, because - if there is *not* a service whose id matches the
type-hint, autowiring tries two other things. But, but but! One of these things
will be removed in Symfony 4 and the other thing will never happen in practice.

## The Deprecated way Autowiring Works

But, we need to talk about these two things so that your 3.3 app makes sense. If
there is *not* a service whose id matches the type-hint, autowiring will look at
*every* service in the container and see which services have the class or interface.
If two or more services have it, Symfony will throw a clear exception. We'll see
that later. But if exactly *one* service is found, that service is used. However,
*this* is deprecated and will *not* work in Symfony 4.

If autowiring finds *zero* services that have the class, it will auto-register that
class as a new autowired service. But, this will *never* happen for us... because
we've auto-registered *all* of our classes as services. And this magic auto-registration
is not done for vendor classes.

So basically, autowiring looks for a service whose id exactly matches the type-hint.
And in Symfony 4, if that service doesn't exist, it will throw a clear exception.
Until then, some of your type-hints *may* still be autowired via the old deprecated
logic. We'll see and fix this in a few minutes.

Next, let's see how this relates to our `MessageGenerator` services, and how we can
fix them.
