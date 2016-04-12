# Injecting the Cache Service

Phew! Dependency injection, check! Registering new services, check! Delicious snack,
check! Well, I *hope* you just had a delicious snack.

This tutorial is the start to our victory lap. We need to add caching to `MarkdownTransformer`:
it should be pretty easy. Copy part of the *old* caching code and paste that into
the `parse()` function. Remove the `else` part of the `if` and just return `$cache->fetch()`:

[[[ code('3682405b3f') ]]]

Below, assign the method call to the `$str` variable and go copy the old `$cache->save()`
line. Return `$str` and re-add the `sleep()` call so that things are *really* slow - that
keeps it interesting:

[[[ code('742dc49228') ]]]

On top, change the `$funFact` variables to `$str`. Perfect!

*We* know this won't work: there is no `get()` function in this class. And more importantly,
we don't have access to the `doctrine_cache.provider.my_markdown_cache` service.
How can we *get* access? Dependency injection.

## Dependency Inject!

This time, add a *second* argument to the constructor called `$cache`. And hmm,
we should give this a type-hint. Copy the service name and run:

```bash
./bin/console debug:container doctrine_cache.providers.my_markdown_cache
```

This service is an instance of `ArrayCache`. But wait! Do *not* type-hint that. In
our earlier course on environments, we setup a cool system that uses `ArrayCache` in
the `dev` environment and `FilesystemCache` in `prod`:

[[[ code('ae7e334c62') ]]]

If we type-hint with `ArrayCache`, this will explode in `prod` because this service
will be a different class.

Let's do some digging: open up `ArrayCache`:

[[[ code('c0ff6e601e') ]]]

This extends `CacheProvider`:

[[[ code('45fe273399') ]]]

That might work. But *it* implements several interface - one of them is just
called `Cache`. Let's try that. If this isn't the right interface - meaning it
doesn't contain the methods we're using - PhpStorm will keep highlighting
those after we add the type-hint:

[[[ code('f4d238a2f7') ]]]

I'll use a keyboard shortcut - `option`+`enter` on a Mac - and select initialize fields:

[[[ code('bb9d57b84e') ]]]

All this did was add the `private $cache` property and set it in `__construct()`.
You can also do that by hand.

Cool! Update `parse()` with `$cache = $this->cache`:

[[[ code('5425010693') ]]]

And look! All of the warnings went away. That *was* the right interface to use. Yay!

Because we added a new constructor argument, we need to update any code that instantiates
the `MarkdownTransformer`. But now, that's not done by us: it's done by Symfony,
and we help it in `services.yml`. Under arguments, add a comma and quotes. Copy
the service name - `@doctrine_cache.providers.my_markdown_cache` and paste it here:

[[[ code('73843e1ce5') ]]]

That's it! That's the dependency injection pattern.

Go back to refresh. The `sleep()` should make it really slow. And it *is* slow.
Refresh again: still slow because we setup caching to really only work in the `prod`
environment.

Clear the `prod` cache:

```bash
./bin/console cache:clear --env=prod
```

And now add `/app.php/` in front of the URI to use this environment. This should be
slow the first time... but then fast after. Super fast! Caching is working. And
dependency injection is behind us.
