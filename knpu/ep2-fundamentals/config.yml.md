# Config.yml: Control Center for Services

Ok, I get it: I bring in a bundle and it gives me more useful objects. But, there
*must* be a way for us to configure and *control* how these services behave, right?
Otherwise, how could we control what server the `mailer` uses for sending emails?
Or what if we want to change how the logger works: making it log to a database instead
of the default `var/logs/dev.log` file?

The answer to *all* of this lies in just *one* file: `app/config/config.yml`. That's
right: *one* file is responsible for controlling everything from the log file to
the database password. That's pretty powerful: so let's find out how it works!

Other than `imports` - which loads other files - and `parameters` - which we'll talk
about soon - *every* root key in this file - like `framework`, `twig` and `doctrine` -
corresponds to a *bundle* that is being configured:

[[[ code('fe4074dda4') ]]]

All of this stuff under `framework` is configuration for the `FrameworkBundle`:

[[[ code('102b867ee0') ]]]

Everything under `twig` is used to *control* the behavior of the services from `TwigBundle`:

[[[ code('5043c3a39b') ]]]

The job of a bundle is to give us services. And this is *our* chance to *tweak* how
those services behave.

## Get a big List of all Configuration

That's amazing! Except... how are we supposed to know *what* keys can live under
each of these sections? Documentation of course! There's a great reference section
on symfony.com that shows you *everything* you can control for each bundle.

But I'll show you an even cooler way.

Head back to terminal and use our favorite `./bin/console` to run `config:dump-reference`:

```bash
./bin/console config:dump-reference
```

Actually, there's a shorter version of this called `debug:config`.
This shows us a map with the bundle name on the left and the "extension alias" on
the right... that's a fancy way of saying the root config key.

***TIP
You can also use the shorter: `./bin/console debug:config` command.
***

That's not really that useful. But re-run it with an argument: `twig`:

```bash
./bin/console config:dump-reference twig
```

Woh! It dumped a giant yml example of *everything* you can configure under the
twig key. Ok, it's not all documented... but honestly, this is usually enough to
find what you need.

## Playing with Configuration

Ok, lets's experiment! Obviously, the `render()` function we use in the controller
leverages a `twig` service behind the scenes. Pretend that the number of known species
is this big 99999 number and send that through a built-in filter called `number_format`:

[[[ code('fe766ffab4') ]]]

Refresh! That filter gives us a nice, `99,999`, formatted-string. But what if we
lived in a country that formats using a `.` instead? Time to panic!!?? Of course
not: the bundle that gives us the `twig` service *probably* gives us a way to control
this behavior.

How? In the `config:dump-reference` dump, there's a  `number_format:`,
`thousands_separator` key. In `config.yml`, add `number_format:` then
`thousands_separator: '.'`:

[[[ code('bc7ef4f75a') ]]]

Behind the scenes, this changes how the service behaves. And when we refresh,
that filter gives us `99.999`.

If this makes sense, you'll be able to control virtually *every* behavior of *any*
service in Symfony. And since *everything* is done with a service... well, that makes
you pretty dangerous.

Now, what if you make a typo in this file? Does it just ignore your config? Hmm,
try it out: rename this key to `thousand_separators` with an extra `s`. Refresh!
Boom! A *huge* error! All of the configuration is *validated*: if you make a typo,
Symfony has your back.
