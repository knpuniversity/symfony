# Finishing framework Config

Let's finish this! Back on `debug:config`, search for `default_locale`. Apparently,
it's already set to `en`. Cool! Let's remove that from `config.yml`. You *can*
move it if you want: the `translator` *did* add a `locale` parameter. I'll delete
it.

## Migrating csrf_protection

Close a few files: I want to keep comparing `config.yml` and `framework.yaml`. In
`config.yml`, we have `csrf_protection` activated. Ok, so uncomment it in `framework.yaml`.
Then, remove it from `config.yml`. Let's also remove `serializer`: I wasn't using
it before. If you *are*, run `composer require serializer` to activate it. No config
is needed.

Ok, let's see if we broke anything! Run:

```terminal
./bin/console
```

Woh! We're busted!

> CSRF support cannot be enabled as the Security CSRF component is not installed.

Ohhhh. Like `translation` and `form`, `csrf_protection` activates a component that
we don't have installed! No problem! Go back to `symfony.sh` and search for "csrf".
There it is! Run:

```terminal
composer require security-csrf
```

By the way, once this is installed, the `csrf_protection` key in `framework.yaml`
should *not* be needed... well, starting in symfony 4.0.2... there was a small bug.
Since I'm using 4.0.1, I'll keep it.

Let's go check on Composer. It downloads the package and... explodes!

> CSRF protection needs sessions to be enabled

## Enabling Sessions

Ah, sessions. They are *off* by default. Uncomment this config to activate them.
Sessions are a bit weird, because, unlike `translator` or `csrf_protection`, you
can't activate them simply by requiring a package. You need to *manually* change
this config. It's no big deal, but it's the *one* part of `framework` config that
isn't super smooth.

Oh, and notice that this config *is* a bit different than before. In Symfony 3,
we stored sessions in `var/sessions`. And you can still *totally* do this. But
the *new* default tells PHP to store it on the filesystem wherever it wants. It's
just one less thing to worry about: PHP will handle all the file permissions.

***TIP
Just remember: when you change your session storage location, your users will lose
their current session data when you first deploy!
***

Remove the old session configuration. Let's see if the app works!

```terminal
./bin/console
```

Yes!

## Migrate Twig

We're getting close! Next is `templating`. This component still exists, but isn't
recommended anymore. Instead, you should use `twig` directly. So, delete it.

***TIP
If your app references the `templating` service, you'll need to change that to `twig`.
***

But our app *does* use Twig. So find your terminal. Oh, let's commit first: I want
to see what the Twig recipe does. Create a calm and sophisticated commit message.
Now run:

```terminal
composer require twig
```

Yay aliases! This added TwigBundle, and Flex installed its Recipe. Run:

```terminal
git status
```

Ah, this made some cool changes! First, in `config/bundles.php`, it automatically
enabled the bundle. Flex does this for *every* bundle. I love that!

It also added a `config/packages/twig.yaml` file. Where do templates live in a Flex
app? You can see it right here! In `templates/` at the root of our project. And
hey! It even *created* that directory for us with `base.html.twig` inside.

The config in `twig.yaml` is *almost* the same as our old app. Copy the extra
`form_themes` and `number_format` keys, delete the old config, and paste them at
the bottom of `twig.yaml`.

Oh, and the recipe gave us something else for free! Any routes in `config/routes/dev`
are automatically loaded, but only in the `dev` environment. The recipe added a
`twig.yaml` there with a route import. This helps you debug and design your error
pages. All of this stuff is handled automatically.

Now that we know that template files should live in `templates/`, let's move them
there! Open `app/Resources/views`. Copy *all* of the files and paste them. And yes,
we *do* want to override the default `base.html.twig`. 

Perfect! Now, celebrate: *completely* remove `app/Resources/views`. Actually, woh!
We can delete *all* of `Resources/`! Our `app/` directory is getting *really* small!

## Migrating trusted_hosts, fragments & http_method_override

We're now down to the *final* parts of `framework`. So what about `trusted_hosts`,
`fragments` and `http_method_override`? Remove all of those. And in `framework.yaml`,
uncomment `fragments`.

If you run:

```terminal
bin/console debug:config framework
```

you'll see that the other keys already default to the old values. Yep, `http_method_override`
is still `true` and `trusted_hosts` is already empty.

## Migrating assets

This leaves us with *one* last key: `assets`. And guess what? This enables a component.
And right now, in `debug:config`, you can see that `assets` is `enabled: false`.

Install it:

```terminal
composer require asset
```

It installs the component, but this time, there is no recipe. But run `debug:config`
again:

```terminal-silent
./bin/console debug:config framework
```

Search for "asset". Ha, yes! It enabled itself.

Ok: delete the `framework` key. This is *huge*! I know I know, it *feels* like we
still have a lot of work to do. But that's not true! With `framework` out of the way,
we are in the home stretch!
