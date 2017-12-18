# Migrating framework Config

Most of our old code lives in `app/config`, and also `src/AppBundle`. We'll talk
about that directory later - it's easier.

Yep, *most* of the work of migrating our code to the new app involves moving each
piece of config into the new location. Honestly, it's tedious and slow. But you're
going to learn a lot, and the end result is totally worth it.

## Moving Parameters

Start in `config.yml`. Ignore imports: we'll look at each file one-by-one. The
first key is parameters. Copy those, delete them, and open `config/services.yaml`.
This is where your `parameters` and `services` will live. Paste them here. Oh, but
remove the `strict_mode` line: autowiring *always* works in "strict mode" in Symfony 4.

## Environment Variables

Keep going! Back to `config.yml`. The keys under `framework` will be the *most* work
to migrate... by *far*. In Flex, this configuration will live in `config/packages/framework.yaml`:
each package has its *own* config file.

Remove the `esi` line from the old file: it's *also* commented out in the *new* one:
nothing to migrate.

Check out the `secret` config: it's set to `%env(APP_SECRET)%`. That's a relatively
new syntax that reads from *environment* variables. In the `dev` environment, Symfony
loads the `.env` file, which sets all these keys as environment variables, including
`APP_SECRET`.

Delete the old `secret` key. The *way* this value is set is a bit different, but,
the point is, it's handled.

## Requiring translator

The next key is `translator`. Are you ready? Because *this* is where things get
fun! You *might* think that all we need to do is copy this line into `framework.yaml`.
But no!

Many of the keys under `framework` represent *components*. In Symfony 3, by adding
the `translator` key, you *activated* that component.

But with Flex, the Translator component isn't even *installed* yet. Yep, if you
want a translator, you need to install it. In your terminal, run:

```terminal
composer require translator
```

If that package name looks funny... it should! There is *no* package called `translator`!
But look! It added a new `symfony/translator` key to `composer.json`.

This is another superpower of Flex. Go to [https://symfony.sh/](https://symfony.sh/).
This is a list of *all* of the packages that have a recipe. Search for "translation"
to find `symfony/translation`. See those Aliases? Yep, we can reference `translation`,
`translations` or `translator` and Flex will, um, translate that into `symfony/translator`
automatically.

## The translator Recipe

Back to the terminal! Before I started recording, I committed all of our changes
so far. That was no accident: Flex just installed a recipe and I want to see *exactly*
what it did! Run:

```terminal
git status
```

Cool! It created a new `translation.yaml` file and a `translation/` *directory*.
That is where translation files should live in Symfony 4. And even though the `translator`
config lives under `framework`, in Flex, it has its *own* configuration file. Oh,
and this is one of my *favorite* things about Flex. Why should my translation files
live in a `translations/` directory? Is that hardcoded somewhere deep in core? Nope:
it's right here in *your* configuration file. Want to put them somewhere else?
Just update that line or add a second path.

So, do we need to move the `translator` config from our old project? Actually, no!
It's already in the new file. Delete it.

And since we now know that translations should live in this new `translations/`
directory, let's move our existing files... well file. In `app/Resources/translations`,
move `validators.en.yml` down into `translations/`.

Celebrate by deleting the old directory!

## Migrating router Config

We're on a roll! What about the `router` config? It told Symfony to load `routing.yml`.
All of that is taken care of in the new app: it loads a `routes.yaml` file and anything
in the `routes/` directory, like `annotations.yaml`.

There's also a `config/packages/routing.yaml` file, and even another one in
`dev/` to tweak that `strict_requirements` setting.

The point is this: routing is handled. Delete that stuff!

## Migrating Forms and Validator

Next, forms! Like with translations, this activates a component that is not installed
yet. We *do* have forms in our app, so we need this and validation. Let's get them
installed:

```terminal
composer require form validator
```

Yep! More aliases! Perfect! This time, it did not install *any* recipes. That's cool:
not all packages need a recipe.

So, do we need to move these 2 lines of config into `framework.yaml`? Actually, no!

Go back to your terminal and run:

```terminal
./bin/console debug:config framework
```

This prints out the current `framework` configuration. Search for `form`. Nice!
It's *already* enabled, even without *any* config! This is really common with Flex:
as soon as a component is installed, `FrameworkBundle` automatically enables it.
No configuration is needed unless you want to change something. Delete the `form`
line.

Search for "validation" next: it's even *more* interesting! It's *also* enabled,
and `enable_annotations` is set to `true`. Great! Delete the `validation` line!
What's *really* interesting is that `enable_annotations` is set to true because
it detected that we have the Doctrine annotations package installed. This is the
flow with Flex: install a package and you're done.

Ok! It might not look like it, but we're almost done with the `framework` stuff.
Let's finish it next!
