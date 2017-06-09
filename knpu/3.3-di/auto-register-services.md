# Auto-Registering All Services

Go back to the Symfony Standard Edition's [services.yml file for Symfony 3.3][services_yml].
These two sections are the most *fundamental* change to the Symfony 3.3 service
configuration. Copy the first section, then find our `services.yml` and, after `_defaults`,
paste:

[[[ code('08cc1bbaab') ]]]

Woh.

This auto-registers *each* class in `src/AppBundle` as a service. There are a few
important things to know. First, the id for each service is the full *class name*,
just like we've been doing with *our* services. And second, thanks to `_defaults`,
these new services are autowired and autoconfigured. And that means... in a lot
of cases, you won't need to manually register your services at all anymore. Nope,
as soon as you put a class in `src/AppBundle`, Symfony will autowire and autoconfigure
it. That means you can start using it with *zero* config. And as we'll see soon,
if the service *can't* be autowired, you'll get a clear error with details on what
to do.

## Auto-registering ALL Classes as Services? Are you Insane?

Now... I *bet* I know what you're thinking:

> Ryan, are you completely insane!? You can't auto-register everything in `src/AppBundle`
> as a service!? Some classes - like DataFixtures! - are simply *not* meant to be
> services! You've gone mad sir!

Ok, this *seems* like a fair argument... but actually, it's not. What if I told you
that the total number of services in the container before *and after* adding this
section is the same. Yep! To prove it, comment out this auto-registration code. Then,
go to your terminal, open a new tab, and run:

```terminal
php bin/console debug:container | wc -l
```

This will basically count the number of services returned. Ok - 262! *Uncomment*
that code. Now, I'm registering *all* classes from `src/AppBundle` as services. Try
the command again:

```terminal
php bin/console debug:container | wc -l
```

It's the same! How is that possible?

Remember, all of these new services are *private*. And that's *very* important. It
means that none of the services can be referenced via `$container->get()`. And Symfony's
container is *so* incredible that - right before it dumps the cached container,
it finds all private services that have not been referenced, and *removes* them
from the container. This means that even though it *looks* like we're registering
*every* class inside of `src/AppBundle` as a service, that's actually not true!

A better way to think of it is this: each class in `src/AppBundle` is *available*
to be used as a service. This means we can reference it as argument in `services.yml`
or type-hint its class in a constructor so that it's autowired. But if you do *not*
reference one of these classes, that service is automatically removed.

## Excluding some Paths

You've probably also noticed this `exclude` key:

[[[ code('d8c3009574') ]]]

Actually, for the reasons we just discussed... this isn't that important. You *can*
exclude certain files or directories if you want. But most of the time, that's
not needed: if you don't reference a class, it's removed from the container for you.

However, if you *do* have entire directories that should *not* be auto-registered,
adding it here is nice. It'll give you a slight performance boost in the `dev`
environment because Symfony won't need to watch those files for changes. And for
a subtle technical reason, the `Entity` directory *must* be excluded. We also excluded
the `Respository` directory. You actually *can* register these as services... but you
need to configure them manually to use a factory. Basically, auto-registering and
autowiring doesn't work, so we might as well ignore them.

## Overriding Auto-Registered Services

Phew! So the idea is that we *start* by auto-registering each class as a service
with these 3 lines. Then, if you *do* need to add some more configuration - like
a tag, or an argument that can't be autowired, you can do that! Just override the
auto-registered service below: use the class name as the key, then do whatever you
need. Symfony automates as much configuration as possible so that you only need to
fill in the rest.


[services_yml]: https://github.com/symfony/symfony-standard/blob/3.3/app/config/services.yml
