# Installing Flex

Our project is now on Symfony 4.0, and it *still* works! Well, it *almost* works:
we would just need to remove a few references to `SensioDistributionBundle`
and `SensioGeneratorBundle`.

The point is this: if you want, you can upgrade to Symfony 4, but *not* migrate
to the new Flex project structure. That's fine.

But... since Flex is *awesome*... let's do it!

## Flex: Composer Plugin & New BFF

Flex is a Composer *plugin*, and, it's pretty simple: when you install a package,
it checks to see if there is a *recipe* for that package. A recipe can add configuration
files, auto-enable the bundle, add paths to your `.gitignore` file and more. But,
for Flex to work, you need to use the Flex directory structure.

## Upgrade to Flex: The Plan

So here's the plan: we're going to bootstrap a new Flex application *right* inside
our *existing* project. Then, little-by-little, we'll move *our* code and configuration
*into* it. It's going to be pretty freakin' cool.

## Upgrade Composer. For Real

Before we start, make sure that your Composer is at the *latest* version:

```terminal-silent
composer self-update
```

Seriously, *do* this. Composer recently released a bug fix that helps Flex.

## Installing Flex

Ok, so... let's install Flex!

```terminal
composer require symfony/flex
```

As *soon* as this is in our project, it will find and install recipes each time
we add a new library to our project. In fact, check it out!

> Configuring symfony/flex

Ha! Flex even installed a recipe for *itself*! What an over-achiever! Let's find
out what it did:

```terminal
git status
```

Of course, it modified `composer.json` and `composer.lock`. But there are two *new*
files: `.env` and `symfony.lock`. Open the first.

How did this get here? It was added by the `symfony/flex` recipe! More about this
file later.

Next, look at `symfony.lock`. This file is managed by Flex: it keeps track of which
recipes were installed. You should commit it, but not think about it.

## Installing Missing Recipes

Because this is an existing project, our app already contains a bunch of vendor
libraries... and a lot of these *might* have recipes that were never installed
because Flex wasn't in our project yet! Lame! No problem! Empty the `vendor/` directory
and run `composer install`

```terminal-silent
rm -rf vendor
composer install
```

Normally, Flex only installs a recipe when you *first* `composer require` a library.
But Flex knows that the recipes for these libraries were *never* installed. So it
runs them now.

Yea! 11 recipes! Woh! And one of them is from the "contrib" repository. There are
two repositories for recipes. The official one is heavily guarded for quality.
The "contrib" one also has some checks, but the quality is not guaranteed. That's
why you see this question. I'll type "p" to permanently allow recipes from contrib.

Run `git status` to see what changed:

```terminal-silent
git status
```

Woh! We have a new `config/` directory and a lot more! Starting with nothing, Flex
is scaffolding the new project around us! It's even auto-enabling all the bundles
in a new `bundles.php` file.

Sweet!

## The Flex composer.json

When you start a *new* Flex project, you actually clone this
[symfony/skeleton](https://github.com/symfony/skeleton) repository... which is literally
one file: `composer.json`. This has a few *really* important things in it, including
the fact that it requires `symfony/framework-bundle` but *not* `symfony/symfony`.

Let's work on that next!
