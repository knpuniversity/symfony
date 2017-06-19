# Controllers as Services

There is one other piece of auto-registration code in the
[new services.yml file for Symfony 3.3][services_yml] involving the `Controller/`
directory. Copy that!

Then, paste it in our file:

[[[ code('35d4339eb0') ]]]

This auto-registers each class in `src/AppBundle/Controller` as a service... which
was already done above:

[[[ code('70ab80b347') ]]]

This overrides those services to make sure that anything in `Controller/` is public
and has this very special tag. In Symfony 3.3 - controllers are the *one* service
that *must* be public. And the tag gives us a special controller argument autowiring
super power that we'll see soon.

## Controllers are Services!?

But wait, our controllers are services!? Yes! In Symfony 3.3, we recommend that all
of your controllers be registered as a service. And it's so awesome! You can still
use all of your existing tricks. You can still extend Symfony's base `Controller`
class and use its shortcuts. You can even still fetch public services directly from
the container. But now, you can *also* use proper dependency injection if you want
to. *And*, as long as your service's id is the class name, all of the existing routing
config formats will automatically know to use your service. In other words, this
just works.

## Removing Unnecessary Services

Now that we're auto-registering each class as a service, we can *remove* these two
services:

[[[ code('bae65e273f') ]]]

They're *still* being registered, but since we don't need to add any further configuration,
they're redundant!

Woohoo! And when we refresh our app, everything still works! Controllers as services
with *four* lines of code!


[services_yml]: https://github.com/symfony/symfony-standard/blob/3.3/app/config/services.yml
