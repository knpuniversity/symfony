# The Flex composer.json File

We need to make *our* `composer.json` file look like the one from `symfony/skeleton`.
Actually, go to "Releases", find the latest release, and then click to browse the
files. Now we can see the *stable* `composer.json` contents.

So... yea, this *one* file is all you need to start a *new* project. That's crazy!
Flex *builds* the project structure around it.

## Bye Bye symfony/symfony

Anyways, the *most* important change is that, with Flex, you *stop* requiring `symfony/symfony`.
Yep, you require *only* the specific packages that you need. Copy all of the
`require` lines, find our `composer.json` file, and paste over the `php` and `symfony/symfony`
lines. Oh, and remove `symfony/flex` from the bottom: it's up here now.

The `symfony/framework-bundle` package is the most important: this is the *core*
of Symfony: it's *really* the only required package for a Symfony app.

Go back and also copy the `dotenv` package from `require-dev` and put it in our
`composer.json` file. This package is responsible for reading the new `.env` file.

## Synchronizing the rest of Composer.json

Go back and also copy the `config` line and paste that here too. Skip the
`autoload` sections for now, but copy the rest of the file. Replace the existing
`scripts` and `extras` sections with this new, shiny stuff.

Brilliant!

## Autoloading src/ & src/AppBundle

Let's talk about `autoload`. In Symfony 3, everything lived in `src/AppBundle`
and had an `AppBundle` namespace. But in Symfony 4, as you can see, everything
should live *directly* in `src/`. And even though we don't have any examples yet,
the namespace will start with `App\`, even though there's no `App/` directory.

Eventually, we *are* going to move all of our files into `src/` and refactor all
of the namespaces. With PhpStorm, that won't be as scary as you think. But, it *is*
a big change, and you may *not* be able to do that all at once in a real project.

So, I'm going to show you a more "gentle", gradual way to upgrade to Flex. Yep,
for now, we're going to leave our files in `AppBundle` and make them work. But *new*
files will directly in `src/`.

Right now, the `autoload` key in `composer.json` says to look for *all* namespaces
in `src/`. Make this more specific: the `AppBundle\\` namespace prefix should live
in `src/AppBundle`. Do the same in `autoload-dev`: `Tests\\AppBundle\\` will live
in `tests/AppBundle`.

Why are we doing this? Because *now* we can go copy the `autoload` entry from the
official `composer.json` file and add it below our `AppBundle\\` line. Copy the
new `autoload-dev` line also.

Thanks to this, Composer can autoload our *old* classes *and* any new classes!

## Scaffold the Full Structure

Ok, that was a *huge* step. Run `composer update`:

```terminal-silent
composer update
```

The *biggest* change is that we're not relying on `symfony/symfony` anymore. And,
yep! You can see it remove `symfony/symfony` and start adding individual libraries.

Ah, it explodes! Don't worry about that yet: Composer *did* finish and Flex configured
*3* new recipes!

At this point, the new Flex project is *fully* built... and it already works!
I'll prove it to you next.
