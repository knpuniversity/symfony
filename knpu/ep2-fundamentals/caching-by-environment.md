# Caching in the prod Environment Only

We absolutely need to cache our markdown processing. But what if we need to tweak
how the markdown renders? In that case, we *don't* want caching. Could we somehow
*disable* caching in the `dev` environment only?

Yes! Copy the `doctrine_cache` from `config.yml` and paste it into `config_dev.yml`.
Next, change `type` from `file_system` to `array`:

[[[ code('b359b543b4') ]]]

The `array` type is basically a "fake" cache: it won't ever store anything.

Yea, that's it! Head back to the browser and refresh. This is definitely *not* caching:
it takes an entire second because of the `sleep()`. Try again. *Still* not caching!
Now, change to the `prod` environment and refresh. Beautiful, this is still really,
really fast. Well that was easy.

## Clearing prod Cache

Ok, this *did* work, but there's a small gotcha we're not considering. In `config.yml`,
change that `thousands_separator` back to a comma:

[[[ code('7527460447') ]]]

Try this first in the `dev` environment: Yep! No problems. Now refresh
in the `prod` environment. Huh, it's *still* a period. What gives?

Here's the thing: the `prod` environment is primed for speed. And that means, when
you change *any* configuration, you need to manually clear the cache before you'll
see those changes.

How do you do that? Simple: in the terminal, run:

```bash
./bin/console cache:clear --env=prod
```

You see, even the console script executes your app in a specific environment. By
default it uses the `dev` environment. Normally, you don't really care. But for
a few commands, you'll want to switch using this flag.

Ok, back to the browser. Refresh in `prod`. Boom! There's our comma!

## The other Files: services.yml, security.yml, etc

Alright, what about all of these *other* configuration files. It turns out, there
all part of the *exact* same configuration system we've just mastered. So where is
`parameters.yml` loaded? Well, at the top of `config.yml` its imported, along with
`security.yml` and `services.yml`:

[[[ code('6b4e517eff') ]]]

The key point is that *all* of the files are just loading each other: it's all the
same system.

In fact, I could copy all of `security.yml`, paste it into `config.yml`, completely
delete `security.yml` and everything would be fine. In fact, the only reason
`security.yml` even exists is because it *feels* good to keep that stuff in its
own file. The same goes for `services.yml` - a *big* topic we'll talk about in the
future.

Now, `parameters.yml` *is* a little special. Let's find out why.
