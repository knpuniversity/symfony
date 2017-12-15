# Your Flex Project is Alive!

Thanks to the Flex recipe for `symfony/framework-bundle`, we now have a fully-functional
Symfony Flex app living *right* inside our directory! `public.` is the new
document root, `config/` has all of the configuration, and our PHP code lives in
`src/`, including the new `Kernel` class.

Yep, we have our *old* app with all our stuff, and a *new*, Flex, app, which is
basically empty and *waiting* for us to move our code into it.

## Re-Order .env

Open up `.env.dist`. Woh! this has more stuff now! That's thanks to the recipes
from DoctrineBundle, SwiftmailerBundle and FrameworkBundle. Copy the FrameworkBundle
section and move that to the top. Do the same thing to `.env`.

We don't need to do this, but `APP_ENV` is *so* important, I want to see it first.
If you start a *new* Flex app, it's on top.

## Re-Ordering the Libs

Next, this will sound weird, but run:

```terminal
composer require symfony/flex
```

We *already* have this library. I know. So... why are we doing this? It's a little
trick: one of the *new* keys in our `composer.json` is `sort-packages`, which is
set to true. Thanks to this, whenever you run `composer require`, it orders the packages
alphabetically. By requiring a package we already have, Composer just re-ordered
my packages.

Thanks Jordi!

## Fixing the console

But... we still have this *giant* error: attempted to load `SecurityBundle` from
`AppKernel`. Bummer! This happens because `bin/console` is still trying to boot the
*old* app.

When you start a *new* Flex project, the `symfony/console` recipe creates the
`bin/console` file. But, since our project already *had* this file, the recipe couldn't
do its job.

No worries! Let's go find the new file! Go to [github.com/symfony/recipes](https://github.com/symfony/recipes).
Welcome to the official recipes repository!

Navigate to `symfony`, `console`, then `bin`. There it is! Copy its contents. Then,
completely replace our version.

This will boot the *new* application! So... does it work? Run:

```terminal
./bin/console
```

No! But that's a new error: we are closer! This says that the autoloader expects
`App\AppBundle\AppBundle` to be defined in `AppBundle.php`, but it wasn't found.
That's strange... that is *not* the correct namespace for that class! If you look
closer, it says the error is coming from a new `config/services.yaml` file.

Our old code - the stuff in `src/AppBundle` - should not be used at *all* by the
new app yet. Open that new `config/services.yaml` file. It has the same auto-registration
code that we're familiar with. And, ah ha! Here's the problem: it is auto-registering
*everything* in `src/` as a service, but it's telling Symfony that the namespace
of each class will start with `App\`.  But, our stuff starts with `AppBundle`!

For now, completely ignore `AppBundle`: let's get the new project working and *then*
migrate our code.

Ok, try `bin/console` again:

```terminal-silent
bin/console
```

It's alive! We just hacked a fully-functional Flex app *into* our project! Now let's
move our code!
