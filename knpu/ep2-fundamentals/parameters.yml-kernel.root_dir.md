# parameters.yml & %kernel.root_dir%

There are some really *special* parameters I need to tell you about. In this big
list that `debug:container` gave us, find the group that starts with `kernel.`. You
won't find these defined anywhere: they're baked right into Symfony and are some
of the *most* useful parameters.

Notice `kernel.debug` - whether or not we're in debug mode - and `kernel.environment`.
But the best ones to know about are `kernel.cache_dir` - where Symfony stores its
cache - and `kernel.root_dir` - which is actually the `app/` directory where the
`AppKernel` class lives. Anytime you need to reference a path in your project, use
`kernel.root_dir` and build the path from it. 

Earlier, just to show off, we configured the `DoctrineCacheBundle` to store the
markdown cache in `/tmp/doctrine_cache`:

[[[ code('47962f6852') ]]]

Referencing absolute paths is a little weird: why not just store this stuff in Symfony's
cache dir? Ok, ok, the bundle actually did this by default, before we started messing
with the configuration. But we're learning people! So let's use one of these new `kernel.`
parameters to fix this.

How? Just change the `directory` to `%kernel.cache_dir%` then `/markdown_cache`:

[[[ code('b3dfa25003') ]]]

It's totally ok to mix the parameters inside larger strings.

Clear the cache in the `prod` environment:

```bash
./bin/console cache:clear --env=prod
```

And switch to the `prod` tab to try this all out. Now, in the terminal:

```bash
ls var/cache/prod/
```

And there's our cached markdown.

## Why is parameters.yml Special?

I have a question: if `config.yml` imports `parameters.yml`, then why bother having
this file at all? Why not just put all the parameters at the top of `config.yml`?

Here's why: `parameters.yml` holds *any* configuration that will be different from
one machine where the code is deployed to another.

For example, your database password is most likely *not* the same as *my* database
password and hopefully not the same as the production database password. But if
we put that password right in the middle of `config.yml`, that would be a nightmare!
In that scenario *I* would probably commit my password to git and then you would
have to change it to *your* password but then try to not commit that change. Gross.

Instead of that confusing mess of seaweed, we use parameters in `config.yml`. This
allows us to isolate all the machine-specific configuration to `parameters.yml`.
And here's the final key: `parameters.yml` is *not* committed to the repository - you
can see there's an entry for it in `.gitignore`:

[[[ code('246992bc4b') ]]]

Of course, if I just cloned this project, and I won't have a `parameters.yml` file:
I have to create it manually. Actually, this is the *exact* reason for this other
file: `parameters.yml.dist`:

[[[ code('b931d57b18') ]]]

This is not read by Symfony, it's just a template of all of the parameters
this project needs. If you add or remove things from the `parameters.yml`,
be sure to add or remove them from `parameters.yml.dist`. You *do* commit
this file to git.

***TIP
Due to a `post-install` command in your `composer.json`, after running `composer install`,
Symfony *will* read `parameters.yml.dist` and ask you to fill in any values that
are missing from `parameters.yml`.
***

Let's put this into practice. What if our app does *not* need to send emails. That
means we *don't* need SwiftmailerBundle. And *that* means we don't need any of these
`mailer_` parameters: these are used in `config.yml` under `swiftmailer`. We could
keep this stuff, but why not get rid of the extra stuff?

In `AppKernel`, start by removing the `SwiftmailerBundle` line completely:

[[[ code('48be553ed1') ]]]

Because that's gone, you'll need to remove the entire `swiftmailer` section in `config.yml`.
And finally, we don't need the `mailer_` parameters anymore, so delete them from
`parameters.yml` *and* `parameters.yml.dist` so other devs won't worry about adding
them. Awesome!

Head over to the terminal and run:

```bash
./bin/console debug:container mailer
```

Cool - the app still runs, but there are *no* services that match `mailer` anymore.
