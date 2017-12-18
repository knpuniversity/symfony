# Hello Flex: Moving Final Files

We're on a mission to remove the *last* parts of our Symfony 3 structure!

## Moving DoctrineMigrations

So what about the `DoctrineMigrations` directory? Look in `src/`. Interesting...
the DoctrineMigrationsBundle recipe added a `Migrations/` directory. So, I guess
that's where they go!

Copy all of the migration files and paste them there. I guess that worked? Let's
find out:

```terminal
./bin/console doctrine:migrations:status
```

Ah! I guess not! It says that my migration class wasn't found: Is it placed in
a `DoctrineMigrations` namespace? Bah! I don't know! 

Our files have an `Application\Migrations` namespace. What's going on? Open the
`config/packages/doctrine_migrations.yaml` file.

Ah ha! The recipe installed config that told the bundle to expect a `DoctrineMigrations`
namespace. Easy fix! Copy the current namespace, and paste it here.

Try the command again:

```terminal-silent
./bin/console doctrine:migrations:status
```

Life is good! Well, we don't have a database - but life is still *pretty* good.

## Removing the app/ Directory

At this point, `app/` only has 3 files left: `AppKernel`, `AppCache` and `autoload.php`.
And unless you made some crazy customizations to these, you don't need any of them.
Yes, I'm telling you to delete the `app/` directory!

And in `composer.json`, remove the `classmap` line: those files are gone!

## Moving & Delete Files

Let's reset our files and look at each directory one by one. We need `bin/`,
`config/` and `public/` is the new document root. `src/` holds our code, and `templates/`,
`tests/` and `translations/` are all valid Flex directories. Oh, and `tutorial/`?
Ignore that: I added that for this course - it has a file we'll use later.

But expand `var/`. Delete everything except for `cache` and `log`: the default logs
directory was renamed in Flex. And that bootstrap file is a relic of the past!

And finally.... `web/`! This directory should *not* exist. Select the files we need:
`css/`, `images/`, `js/` and `vendor/`: move these into `public/`. Let's also move
`robots.txt`.

And that's it! The `favicon` is from Symfony and we don't need the app files anymore.
What about `.htaccess`? You only need that if you use Apache. And if you *do*, Flex
can add this file for you! Just run `composer require symfony/apache-pack`. The
recipe will add this inside `public`.

Anyways, delete `web/`! This is it! Our app is *fully* in Flex! And we didn't even
*need* to move all our files from `src/AppBundle`... though we *will* do that soon.
And as far as `bin/console` is concerned, the app works!

But to really prove it's alive, let's try this in a browser and handle a few last
details. That's next!
