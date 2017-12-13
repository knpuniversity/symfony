# Upgrade to Symfony 3.4

Symfony 4: it's a *game* changer. It's my *favorite* thing since chocolate milk.
Honestly, I've *never* been so excited to start writing tutorials: you are going
to *love* it!

But first, we need to talk about how you can *upgrade* to Symfony 4 so that all your
projects can enjoy the goodness! 

There are two big steps. First, well, of course, we need to *actually* upgrade our
app to Symfony 4! And second, we need to update our project to support Symfony *Flex*.
*That* is where things get interesting.

Upgrading *does* take some work. But don't worry: we'll walk through it together
and learn a ton on the way.

## Download the Course Code

As always, if you *really* want to get a handle on upgrading... or you just like
chocolate milk, you should download the course code from this page and code along.
Full disclosure: the download does *not* contain chocolate milk.

But, after you unzip it, it *does* contain a `start/` directory with the same code
you see here. Follow the `README.md` file for the steps needed to get your project
running.

The last step will be to find your terminal and run:

```terminal
./bin/console server:run
```

to start the built-in web server. Check it out at `http://localhost:8000`. Hello
AquaNote! This is the Symfony *3.3* project that we've been building in our Symfony
series.

## Upgrading to Symfony 4

So: what's the first step to upgrading to Symfony 4? It's upgrading to *3.4*! And
that's *delighyfully* simple: Open `composer.json`, change the version of `symfony/symfony`
to `^3.4`, find your terminal and run:

```terminal
composer update
```

And celebrate! So easy! By teh way, you *could* just update `symfony/symfony`. But,
honestly, it's just *easier* to upgrade *everything*. And since I keep responsible
version constraints in `composer.json`, ahem, no `dev-master` or `*` versions, this
is pretty safe and also means I get bug fixes, security fixes and new features.

And... hello Symfony 3.4! The best part? Ah, you guys already know it: thanks to
Symfony's backwards-compatibility promise, our project will just work... immediately.
Refresh! Yep! Welcome to Symfony 3.4.

## Symfony 3.4 Versus Symfony 4.0

So why did we do this? Why not just skip *directly* to Symfony 4? Well, Symfony
3.4 and Symfony 4.0 are *identical*: they have the exact same features. The *only*
difference is that all deprecated code paths are *removed* in 4.0.

On the web debug toolbar, you can see that *this* page contains *9* deprecated code
calls. By upgrading to Symfony 3.4 first, we can hunt around and fix these. As soon
as they're all gone... well, we'll be ready for Symfony 4!

## Deprecation: Kernel::loadClassCache() 

Click the icon to go see the full list of deprecations. Check out the first one:
`Kernel::loadClassCache()` is deprecated since version 3.3. You can click "Show Trace"
to see where this is coming from, but I already know!

Open `web/app.php` and `web/app_dev.php`. There it is! On line 28, remove the
`$kernel->loadClassCache()` line. Do the same thing in `app.php`. Why is this deprecated?
This *originally* gave your app a performance boost. But thanks to optimizations
in PHP 7, it's not needed anymore. Less code, more speed, woo!

## Deprecation: GuardAuthenticator::supports()

Close those files. What's next? Hmm, something about `AbstractGuardAuthenticator::supports()`
is deprecated. Oh, and a recommendation! We should implement `supports()` inside
our `LoginFormAuthenticator`.

Because I obsess over Symfony's development, I know what this is talking about.
If you have more of a life than I do and are not already aware of *every* single
little change, you should go to [github.com/symfony/symfony](https://github.com/symfony/symfony)
and find the `UPGRADE-4.0.md` file. It's not perfect, but it contains explanations
behind a *lot* of the changes and deprecations you'll see.

Go find the `LoginFormAuthenticator` in `src/AppBundle/Security`. We need to add
a new method: `public function supports()` with a `Request` argument.

Copy the logic from `getCredentials()` that checks the URL, and just *return* it.
Here's the deal: in Symfony 3, `getCredentials()` was called on *every* request.
If it returned `null`, the authenticator was done: no other methods were called on
it.

In Symfony 4, `supports()` is now called on every request instead. If it returns
false, the authenticator is done like before. But if it returns `true`, then
`getCredentials()` is called. We split the work of `getCredentials()` into two methods.

So, remove the logic at the top of it: we know this will *only* be called when
the URL is `/login` and it's a POST request.

## Deprecation: Quoting % in YAML

Most of the other deprecations are pretty easy, like the next one:

> Not quoting the scalar `%cache_type%` starting with the "%" indicator character
> is deprecated since Symfony 3.1.

This, *and* the next deprecation are in `config.yml` - and it even tells us the
exact lines!

Open up `app/config/config.yml` and find line 71. Yep! Put quotes around `%cache_type%`.
To more closely follow the official YAML spec, if a value starts with `%`, it needs
to have quotes around it. Do the same around the `directory` value.

## Deprecation: logout_on_user_change

Back on the list, there is one more easy deprecation!

> Not setting logout_on_user_change to true on firewall "main" is deprecated
> as of 3.4.

Copy that key. Then, open `app/config/security.yml`. Under the `main` firewall,
paste this and set it to `true`.

So, what the heck is this? Check it out: suppose you change your password while
on your work computer. Previously, doing that did *not* cause you to be logged out
on any *other* computers, like on your home computer. This was a security flaw, and
the behavior was changed in Symfony 4. But turning this on, you can test to make
sure your app doesn't have any surprises with that behavior.

Phew! Before we talk about the last deprecations, go back to the homepage and refresh.
Yes! In 5 minutes our 9 deprecations are down to 2! Open up the list again. Interesting:
it says:

> Relying on service auto-registration for `Genus` is deprecated. Create a service
> named AppBundle\Entity\Genus instead.

That's weird... and involves changes to autowiring. Let's talk about those next!
