# _defaults, autowire & autoconfigure

If you started a brand new Symfony 3.3 project, its `services.yml` file will look
like [this][services_yml].

You're actually seeing at least *four* new features all at once! Wow. All of
this is built on top of the existing service configuration system and you need to
"opt in" to any of the new features. That means that the traditional way of configuring
services that you've been using until now still works and always will. Winning!

But even if you ultimately choose *not* to use some of these new features, you need
to understand how they work, because you'll see them a lot. For example, the Symfony
documentation has already been updated to assume you're using these.

First, a word of warning: using the new features is *fun*. But, upgrading an existing
project to use them... well... it's *less* fun. It takes some work, and when you're
done... your project works... the same as before. I'm also going to show you the
ugliest parts of the new system so you can handle them in your project. But stick
with me! At the end, we'll use the new features to build some new code. And that,
is a *blast*.

## _defaults: File-side Service Defaults

Let's look at this `_defaults` thing first. Open up your `app/config/services.yml`
file. At the top of the `services` section - though order isn't important - add
`_defaults`. Then below that, `autowire: true` and `autoconfigure: true`:

[[[ code('c77043316b') ]]]

Let's unpack this. First, `_defaults` is a new special keyword that allows you to
set default configuration for all services in *this* file. It's equivalent to adding
`autowire` and `autoconfigure` keys under every service in this file only. And of
course, any config from `_defaults` can be overridden by a specific service.

## Autowiring

Autowiring is *not* new: we talk about it in our Symfony series. When a service is
autowired, it means that its constructor arguments are automatically configured
when possible by reading type-hints. For example, the `MarkdownExtension` is autowired:

[[[ code('0a1afc4971') ]]]

And its first constructor argument is type-hinted with `MarkdownTransformer`:

[[[ code('8b47456830') ]]]

Thanks to that, Symfony determines which service to pass here.

The *way* that autowiring works *has* changed in Symfony 3.3. But more on that later.

Since we have `autowire` under `_defaults`, we can remove it from everywhere else:
it's redundant. And yes, this *does* mean that some services that were *not* autowired
before are *now* set to `autowire: true`. For example, `app.markdown_transformer`
*is* now being autowired:

[[[ code('211e989ef5') ]]]

But... that's no problem! Both of its arguments are being *explicitly* set:

[[[ code('a003c472c7') ]]]

so autowiring simply doesn't do anything. Setting `autowire: true` under `_defaults`
is safe to add to an existing project.

## Autoconfigure

Next, this `autoconfigure` key *is* a brand new feature. When a service is autoconfigured,
it means that Symfony will automatically *tag* it when possible. For example, our
`MarkdownExtension` extends `\Twig_Extension`:

[[[ code('ae5b7aad51') ]]]

Which implements `Twig_ExtensionInterface`:

```php
abstract class Twig_Extension implements Twig_ExtensionInterface
{
    // ...
}
```

That's actually the important part. When a service is autoconfigured and its class
implements `Twig_ExtensionInterface`, the `twig.extension` tag is *automatically*
added for you:

[[[ code('7ded342ed8') ]]]

Basically, Symfony is saying:

> Hey! I see you configured a service that implements `Twig_ExtensionInterface`.
> Obviously, that's a Twig extension, so let me configure it for you.

[[[ code('6b97405932') ]]]

This works for many - but not all tags. It does *not* work for `doctrine.event_subscriber`
or `form.type_extension`:

[[[ code('323a9208fe') ]]]

Because it has an `extended_type` tag option... which the system can't guess for you.
When you're developing a feature, the docs will tell you whether or not you need to add
the tag manually. If you *do* add a tag, even though you didn't need to, no problem!
Your tag takes precedence.

So, all our services are autowired and autoconfigured! But, it doesn't make any difference,
besides shortening our config *just* a little. And when we refresh, everything
still works!


[services_yml]: https://github.com/symfony/symfony-standard/blob/3.3/app/config/services.yml
