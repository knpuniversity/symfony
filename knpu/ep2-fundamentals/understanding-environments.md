# Environments

Question: if `config.yml` is so important - then what the heck is the point of all
of these other files - like `config_dev.yml`, `config_test.yml`, `parameters.yml`,
 `security.yml` and `services.yml`. What is their purpose?

## What is an Environment?

The answer is *environments*. Now, I don't mean environments like `dev`, `staging`,
or `production` on your servers. In Symfony, an environment is a set of configuration.
Environments are also one of its most *powerful* features.

Think about it: an application is a big collection of code. But to get that code
running it needs configuration. It needs to know what your database password is,
what file your logger should write to, and at what priority of messages it should
bother logging.

## The dev and prod Environments

Symfony has *two* environments by default: `dev` and `prod`. In the `dev` environment
your code is booted with a lot of logging and debugging tools. But in the `prod`
environment, that same code is booted with minimal logging and other configuration
that makes everything fast.

***TIP
Actually, there's a third environment called `test` that you might use while writing
automated tests.
***

So.... how do we choose which environment we're using? And what environment have
we been using so far?

## app.php versus app_dev.php

The answer to that lives in the `web` directory, which is the *document root*. This
is the only directory whose files can be accessed publicly.

These two files - `app.php` and `app_dev.php` - are the keys. When you visit your
app, you're always executing *one* of these files. Since we're using the `server:run`
built-in web server: we're executing `app_dev.php`:

[[[ code('dc1cbf5027') ]]]

The web server is preconfigured to hit this file.

That means that when we go to `localhost:8000/genus/octopus` that's equivalent to
going to `localhost:8000/app_dev.php/genus/octopus`. With that URL, the page still
loads *exactly* like before.

So how can we switch to the `prod` environment? Just copy that URL and change
`app_dev.php` to `app.php`. Welcome to the `prod` environment: same app, but no web
debug toolbar or other dev tools:

[[[ code('205113c0ae') ]]]

This baby is optimized for speed.

But don't worry: in production you won't have this ugly `app.php` in your URL: you'll
configure your web server to execute that file when nothing appears in the URL.

So this is how you "choose" your environment. And other than on your production server,
you'll pretty much always want to be in the `dev` environment.

But the real fun starts next: when we learn how to bend and optimize each environment
exactly to our needs.
