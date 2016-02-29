# Adding a Cache Service

I've got a pretty important new challenge. We're going to be rendering a lot of
markdown... and we *don't* want to do this on every request - it's just too slow.
We really need a way to cache the parsed markdown.

Hmm, so caching is yet *another* tool that we need. If we had a service that was
really good at caching a string and letting us fetch it out later, that would be
perfect! Fortunately, Symfony comes with a bundle called `DoctrineCacheBundle` that
can give us *exactly* this.

## Enabling DoctrineCacheBundle

First, double-check that you have the bundle in your `composer.json` file:

[[[ code('e7b54100d4') ]]]

If for some reason you don't, use Composer to download it.

The bundle lives in the `vendor/` directory, but it isn't enabled. Do that in the
`AppKernel` class with `new DoctrineCacheBundle()`:

[[[ code('3bea87e73c') ]]]

That added a `use` statement on top of the class... which is great - but I'll move
it down to be consistent with everything else. Awesome!

Once you've enabled a bundle, there are usually two more steps: configure it, then
use it. And of course, this has its own documentation that'll explain all of this.
But guys, we're already getting really *good* at Symfony. I bet we can figure out
how to use it entirely on our own.

## 1) Configure the Bundle

First, we need to configure the bundle. To see what keys it has, find the terminal
and run:

```bash
./bin/console config:dump-reference
```

The list has a new entry: `doctrine_cache`. Re-run the command with this:

```bash
./bin/console config:dump-reference doctrine_cache
```

Nice! There's our huge configuration example! Ok, ok: I don't expect you to just
look at this and instantly know how to use the bundle. You really *should* read its
documentation. But before long, you really *will* be able to configure new bundles
really quickly - and maybe without needing their docs.

## Configuring a Cache Service

Now, remember the goal: to get a cache service we can use to avoid processing markdown
on each request. When we added `KnpMarkdownBundle`, we magically had a new service.
But with this bundle, we need to *configure* each service we want.

Open up `config.yml` and add `doctrine_cache`. Below that, add a `providers` key:

[[[ code('c072f5fa0b') ]]]

Next, the config dump has a `name` key. This `Prototype` comment above that is a
confusing term that means that we can call this `name` *anything* we want. Let's make
it `my_markdown_cache`:

[[[ code('e8111dea49') ]]]

You'll see how that's important in a second.

Finally, tell Doctrine what *type* of cache this is by setting `type` to `file_system`:

[[[ code('03143ad534') ]]]

This is just *one* of the built-in types this bundle offers: its docs would tell
you the others.

And that's it! In the terminal run `./bin/console debug:container` and search for 
`markdown_cache`:

```bash
./bin/console debug:container markdown_cache
```

Et voila! We have a new service called `doctrine_cache.providers.my_markdown_cache`.
That's the *whole* point of this bundle: we describe a cache system we want, and
it configures a service for that. Now we're dangerous.
