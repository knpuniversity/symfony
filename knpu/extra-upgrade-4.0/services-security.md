## Migrating Services & Security

Ok, remember our goal: to move our code - which mostly lives in `config/` - into
the *new* directory structure.

## Migrating the doctrine Config

The next section is `doctrine`... and there's nothing special here: this is the
default config from Symfony 3. Compare this with `config/packages/doctrine.yaml`.
If you look closely, they're almost the same - but with a few improvements!

Instead of having multiple config entries for the database host, username and
password, it's all combined into one `url`. The `DATABASE_URL` environment variable
is waiting to be configured in the `.env` file.

But there is *one* important difference: `mappings`. In a Flex project, we expect
your entities to live in `src/Entity`. But currently, *our* classes live in `src/AppBundle/Entity`.

And yes yes, we *are* going to move them... eventually. But let's pretend like moving
them is too big of a change right now: I want to make my files work where they are.
How can we do that? Add a second mapping! This one will look in the `src/AppBundle/Entity`
directory for classes that start with ``AppBundle\Entity``. Update the alias to
`AppBundle` - that's what lets you say `AppBundle:Genus`.

[[[ code('7df5d38981') ]]]

Simple & explicit. I *love* it! Go delete the old `doctrine` config!

## Migrating doctrine_cache and stof_doctrine_extensions

The last two sections are for `doctrine_cache` and `stof_doctrine_extensions`. Both
bundles are installed, so we just need to move the config. Huh, but the DoctrineCacheBundle
did *not* create a config file. That's normal: some bundles don't *need* configuration,
so their recipes don't add a file. Create it manually: `doctrine_cache.yaml`. And
move all the config into it.

[[[ code('80b44e341d') ]]]

All of the files in this directory are automatically loaded, so we don't need to
do anything else.

Then, for `stof_doctrine_extensions`, it *does* have a config file, but we need
to paste our custom config at the bottom.

[[[ code('12f6ce20ea') ]]]

And... that's it! Delete `config.yml`. Victory!

## Migrating Services

Close a few files, but keep the new `services.yaml` open... because this is our
next target! Open the *old* `services.yml` file. This has the normal autowiring
and auto-registration stuff, as well as some aliases and custom service wiring.

Because we're *not* going to move our classes out of AppBundle yet, we need to
*continue* to register those classes as services. But in the new file, to get things
working, we *explicitly* excluded the `AppBundle` directory, because those classes
do not have the `App\` namespace.

No problem! Copy the 2 auto-registration sections from `services.yml`  and paste
them into the new file. And I'll add a comment: when we eventually move everything
*out* of AppBundle, we can delete this. Change the paths: we're now one level *less*
deep.

[[[ code('8393190e7e') ]]]

Next, copy the existing aliases and services and paste them into the new file.

[[[ code('b0913e450c') ]]]

And... ready? Delete `services.yml`! That was a *big* step! Suddenly, almost *all*
of our existing code is being used: we just hooked our old code into the new app.

But, does it work! Maybe....? Try it!

```terminal
./bin/console
```

## Migrating Security

Ah! Not *quite*: a class not found error from Symfony's Guard security component.
Why? Because we haven't installed security yet! Let's do it:

```terminal
composer require security
```

It downloads and then... another error! Interesting:

> LoginFormAuthenticator contains 1 abstract method

Ah! I think we *missed* a deprecation warning, and now we're seeing a fatal error.
Open `AppBundle/Security/LoginFormAuthenticator.php`.

PhpStorm agrees: class must implement method `onAuthenticationSuccess`. Let's walk
through this change together. First, remove `getDefaultSuccessRedirectUrl()`: that's
not used anymore. Then, go to the Code->Generate menu - or Command+N on a Mac -
select "Implement methods" and choose `onAuthenticationSuccess`.

Previously, this method was handled by the base class for you. But now, it's your
responsibility. No worries: it's pretty simple. To help, at the top, use a trait
called `TargetPathTrait`.

[[[ code('07785489e1') ]]]

Back down in `onAuthenticationSuccess`, this allows us to say if
`$targetPath = $this->getTargetPath()` with `$request->getSession()` and `main`.

[[[ code('760d0d3ec0') ]]]

Let's break this down. First, the `main` string is just the name of our firewall.
In both the old *and* new security config, that's its key.

Second, what does `getTargetPath()` do? Well, suppose the user originally tried
to go to `/admin`, and then they were redirected to the login page. After they login,
we should probably send them back to `/admin`, right? The `getTargetPath()` method
returns the URL that the user *originally* tried to access, if any.

So if there *is* a target path, return new `RedirectResponse($targetPath)`. Else,
return new `RedirectResponse` and generate a URL to the homepage.

[[[ code('bab033b6df') ]]]

PhpStorm thinks this isn't a real route, but it is!

Problem solved! Is that enough to make our app happy? Find out!

```terminal-silent
./bin/console
```

It *is*! But before we move on, we need to migrate the security config. Copy *all*
of the old `security.yml`, and *completely* replace the new `security.yaml`. To
celebrate, delete the old file!

[[[ code('ca0aaa178b') ]]]

And... ah! We're *super* close. Only a *few* more files to deal with! By the end
of the next chapter, our `app/config/` directory will be gone!
