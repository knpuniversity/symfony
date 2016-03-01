# config_dev.yml & config_prod.yml

We have two environments! That's *super* flexible... or I think it will be, just
as soon as we figure out how the heck we can *configure* each environment.

Compare `app.php` and `app_dev.php`. What are the differences? Ok, ignore that big
`if` block in `app_dev.php`. The *important* difference is a single line: the one
that starts with `$kernel = new AppKernel()`. Hey, that's the class that lives in
the `app/` directory!

The first argument to `AppKernel` is `prod` in `app.php`:

[[[ code('1755c4b97e') ]]]

And `dev` in `app_dev.php`:

[[[ code('d437ddce09') ]]]

*This* defines your environment. The second argument - `true` or `false` - is a debug
flag and basically controls whether or not errors should be shown. That's less important.

## config_dev.yml versus config_prod.yml

Now, what do these `dev` and `prod` strings do? Here's the secret: when Symfony boots,
it loads only *one* configuration file for the entire system. And no, it's *not*
`config.yml` - I was lying to you. Sorry about that. No, the `dev` environment
loads *only* `config_dev.yml`:

[[[ code('f7e4beb5ef') ]]]

And in `prod`, the only file it loads is `config_prod.yml`:

[[[ code('058af43f40') ]]]

Ok fellow deep sea explorers, this is where things get cool! Look at the first line
of `config_dev.yml`:

[[[ code('604836e991') ]]]

What does it do? It *imports* the main `config.yml`: the main *shared* configuration.
Then, it overrides any configuration that's special for the `dev` environment.

Check this out! Under `monolog` - which is the bundle that gives us the `logger`
service - it configures extra logging for the `dev` environment:

[[[ code('a4051ad326') ]]]

By setting `level` to `debug`, we're saying "log everything no matter its priority!"

So what about `config_prod.yml`? No surprise: it does the *exact* same thing: it
loads the main `config.yml` file and then overrides things:

[[[ code('180c6162ba') ]]]

This file has a similar setup for the logger, but now it says `action_level: error`:

[[[ code('5100dc13a4') ]]]

This only logs messages that are at or above the `error` level. So only messages
when things break.

## Experimenting with config_dev.yml

Let's play around a bit with the `dev` environment! Under `monolog`, uncomment the
`firephp` line:

[[[ code('c668cbba41') ]]]

This is a cool handler that will show you log messages *right* in your browser.

Head over to it and run "Inspect Element". Make sure that the URL will access the
`dev` environment and then refresh. And check *this* out: a bunch of messages
telling us what route was matched. Heck, we can even see what route was matched for
our ajax call. To see this working, you'll need a `FirePHP` extension installed in
your browser. In your app, Monolog is attaching these messages to your response headers,
and the extension is reading those. We don't want this to happen on production,
so we only enabled this in the `dev` environment. 

Environments are awesome! So how could we use them *only* cache our markdown string
in the `prod` environment?
