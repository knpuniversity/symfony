# Final config/ Migration

We are in the Flex home stretch! These last `config/` files are the easiest. Start
with `config_dev.yml`.

## Dev Environment Parameters

Ok, we have a `cache_type` parameter. This is meant to override the value that
lives in `services.yaml` whenever we're in the `dev` environment.

How can we have dev-specific parameters or services in Flex? By creating a new
`services_dev.yaml` file. Copy the parameter, remove it and paste it here.

Symfony will automatically load this file in the `dev` environment only.

## Migrating config_dev.yml

For the rest of the file... we haven't really changed anything: these are the original
default values. So there's a good chance that we can just use the *new* files without
doing anything.

And yea! If you investigated, you would find that the `framework` config is already
represented in the new files. And the `profiler`... well actually... that's not
even installed yet. Let's fix that:

```terminal
composer require profiler
```

Go back and remove the `framework` and `web_profiler` sections. When Composer finishes...
yes! This installed a recipe. The new `web_profiler.yaml` file contains exactly
what we just removed. It even added config for the `test` environment *and* loaded
the routes it needs. Thanks profiler!

The last key in `config_dev.yml` is `monolog`. Monolog *is* installed... and its
recipe added config for the `dev` and `prod` environments.

I haven't made any changes to my `monlog` config that I really care about - just
this `firephp` section, which I could re-add if I want. So I'll use the new default
config and just... delete `config_dev.yml`! We can also delete `config_prod.yml`.

## doctrine Config in config_prod.yml

Oh, by the way, if you have some `doctrine` caching config in `config_prod.yml`,
I would recommend *not* migrating it. The DoctrineBundle recipe gives you `prod`
configuration that is *great* for production out-of-the-box. Booya!

## Migrating config_test.yml

Next: `config_test.yml`. And yea... this is *still* just default config. But there
*is* one gotcha: in `config/packages/test/framework.yaml`, uncomment the `session`
config.

I mentioned earlier that the session config is not perfect smooth: if you need sessions,
you need to uncomment some config in the main `framework.yaml` and here too.

Ok, delete `config_test.yml`!

## Migrating paramters.yml?

What about `parameters.yml`? In Flex, this file does *not* exist. Instead of
referencing parameters, we reference *environment variables*. And in the `dev`
environment, we set these in the `.env` file.

We also had a `parameters.yml.dist` file, which kept track of all the parameters
we need. In Flex, yea, we've got the same: `.env.dist`.

The `parameters.yml` file in this project only holds database config and `secret`...
and both of these are already inside `.env` and `.env.dist`.

The only difference between the files is how you *reference* the config. In `doctrine.yaml`,
instead of using `%DATABASE_URL%` to reference a paramter, you reference environment
variables with a strange config: `%env(DATABASE_URL)%`.

But other than that, it's the same idea. Oh, the `resolve:` part is optional: it
allows you to put parameters *inside* of your environment variable values.

So... we're good! Delete `parameters.yml` and `parameters.yml.dist`. If *you* have
other keys in `parameters.yml`, add them to `.env` and `.env.dist` and then go
update where they're referenced to use the new syntax. Easy peasy.

While we're on the topic, in `.env`, update your database config: I'll use `root`
with no password and call the database `symfony4_tutorial`.

Copy that and repeat it in `.env.dist`: I want this to be my default value.

## Migrating routing Files

Back to the mission! What about `routing.yml`? Copy its contents. I'll close a few
directories... then open `config/routes.yaml`. Paste here!

We *already* have a `config/routes/dev/annotations.yaml` file that loads annotation
routes from `src/Controller`. But for now, we still need *our* import because it
loads routes from AppBundle.

But we *do* need to make two small changes. *Even* though we'll keep the `AppBundle`
directory for now, we are *not* going to actually *register* it as a bundle anymore.
Yep, `AppBundle.php` can be deleted: we just *don't* need bundles anymore.

But to make this work, we need to replace `@AppBundle` with a normal path:
`../src/AppBundle/Controller`.

And for the homepage route, remove the weird three-part colon syntax and just use
the full class name: `App\Controller\MainController::homepageAction`.

I am *so* happy to be done with those two Symfony-specific syntaxes! Delete
`routing.yml`. And... `routing_dev.yml`? Yep, delete it too! The Flex recipes handle
this stuff too.

In fact, delete the `config/` directory!

Does our app work? Try to list the routes:

```terminal
./bin/console debug:router
```

Ha! Yes! We have our routes back!

Next, let's *delete* some files - that's always fun - and then welcome our new Flex
app!
