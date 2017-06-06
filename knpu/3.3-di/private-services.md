# Making all Services Private

There is *one* more key that lives under `_defaults` in a new Symfony 3.3 project:
`public: false`:

[[[ code('ce051e5dfb') ]]]

The idea of public versus private services is *not* new in Symfony 3.3... but defaulting
all services to private *is* new, and it's a *critical* change. Thanks to this, *every*
service in this file is now *private*. What does that mean? One simple thing: when
a service is private, you *cannot* fetch it directly from the container via
`$container->get()`. So, for example, `$container->get('AppBundle\Service\MarkdownTransformer')`
will *not* work.

***TIP
In Symfony 3.3, *sometimes* you can fetch a private service directly from the
container. But doing this has been deprecated and will be removed in Symfony 4.
***

But, *everything* else works the same: I can pass this service as an argument and
it can be autowired into an argument. *Only* the `$container->get()` usage changed.

In our app, making this change is safe! We *just* created all of these service ids
a minute ago and they're not being used anywhere yet, definitely not with `$container->get()`.
The exception is the last two services: we *might* be fetching these services directly
from the container. And in fact, I know we are: in `src/AppBundle/Controller/Admin/GenusAdminController.php`.
Down in `editAction()`, we're fetching both services via `$this->get()`, which is a
shortcut for `$this->container->get()`:

[[[ code('e1e39ca3e2') ]]]

That means, for now, to keep our app working, add `public: true` under each service:

[[[ code('304dbb36c6') ]]]

Aliases can *also* be private... but in `legacy_aliases.yml`, there is no `_defaults`
key with `public: false`. So, these are all *public* aliases... which is exactly
what we want, ya know, because we're trying *not* to break our app!

Like with *every* step so far, our app should still work fine. Woohoo! But... you
may be wondering *why* we made the services private. Doesn't this just make our
services harder to use? As we'll learn soon, when you use private services, it becomes
*impossible* to make a mistake and accidentally reference a non-existent service.
Private services are going to make our app *even* more dependable than before. And
also, a little bit faster.

Next, let's talk about the *biggest* change to this file: auto-registration of all
classes in `src/AppBundle` as services. Woh.
