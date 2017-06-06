# Upgrading to Symfony 3.3!

Yo peeps! Wow, Symfony 3.3! Actually, that version number *sounds* kinda boring.
I mean, 3.3? Really? I expect cool stuff to happen in version 3.3?

Well..... normally I'd agree! But Symfony 3.3 is special: it has some big, awesome,
exciting, dinosauric changes to how you configure services. And that's why we made
this crazy tutorial in the first place: to take those head on.

If you're not already comfortable with how services work in Symfony, stop, drop and
roll... and go watch our [Symfony Fundamentals][symfony-fundamentals] course.
Then come back.

## Symfony's Backwards-Compatibility ~~Awesomeness~~ Promise

So, how can we upgrade to Symfony 3.3? I have no idea. No, no, no - upgrading Symfony
is always *boring* and simple. That's because of Symfony's backwards compatibility
promise: we do not break things when you upgrade a minor version, like 3.2 to 3.3.
It's Symfony's secret super power. I *will* show you how to upgrade, but it's easy.

As always, you should totally bake cookies while watching this tutorial... and also,
code along with me! Click download on this page and unzip the file. Inside, you'll
find a `start/` directory with the same code you see here. Open the `README.md` file
to find poetic prose... which doubles as setup instructions.

## Upgrading

Time to upgrade! Open up `composer.json`:

[[[ code('37fa63c3ff') ]]]

This is actually a Symfony *3.1* project, but that's no problem. I'll change the version
to `3.3.0-RC1` because Symfony 3.3 has not been released yet at the time of this recording.
You should use `3.3.*`:

[[[ code('c2ee44c913') ]]]

By the way, we *could* update other packages too, but that's optional. Often, I'll
visit the Symfony Standard Edition, make sure I'm on the correct branch, and see
what versions it has in its [composer.json file][composer_json].

For now, we'll *just* change the Symfony version. To upgrade, find your favorite
terminal, move into the project, and run:

```terminal
composer update
```

This will update *all* of your packages to the latest versions allowed in `composer.json`.
You could also run `composer update symfony/symfony` to *only* update that package.

Then.... we wait! While Jordi and the Packagists work on our new version.

## Removing trusted_proxies

It downloads the new version then... woh! An error! Occasionally, if we have a *really*
good reason, Symfony will change something that *will* break your app on upgrade...
but only in a huge, obvious and unavoidable way:

> The "framework.trusted_proxies" configuration key has been removed in Symfony 3.3.
> Use the `Request::setTrustedProxies()` method in your front controller instead.

This says that a `framework.trusted_proxies` configuration was removed. Open up
`app/config/config.yml`: there it is! Just take that out:

[[[ code('b204e46017') ]]]

The option was removed for security reasons. If you *did* have a value there,
check out the docs to see the replacement.

Ok, *even* though `composer update` exploded, it *did* update our `composer.lock`
file and download the new version. Just to be sure, I'll run `composer install` to
make sure everything is happy:

```terminal
composer install
```

Yes!

## Enabling the WebServerBundle

Ok, start the built-in web server:

```terminal
php bin/console server:run
```

Ahhh!

> There are no commands defined in the "server" namespace

What happened to `server:run`? Well actually, Symfony is becoming more and more decoupled.
That command now lives in its own bundle. Open `app/AppKernel.php`. And in the `dev`
environment only, add `$bundles[] = new WebServerBundle()`:

[[[ code('4bb7c38132') ]]]

That bundle still *comes* with the `symfony/symfony` package, but it wasn't enabled
in our project. A *new* Symfony 3.3 project already has this line.

Flip back to your terminal and try again:

```terminal
php bin/console server:run
```

Got it! Find your browser and open up `http://localhost:8000` to find the famous
Aquanaut project that we've been working on in this Symfony series.

Okay, we're set up and we are on Symfony 3.3. But we are *not* yet using any of
the cool, new dependency injection features. Let's fix that!


[symfony-fundamentals]: https://knpuniversity.com/screencast/symfony-fundamentals
[composer_json]: https://github.com/symfony/symfony-standard/blob/3.3/composer.json
