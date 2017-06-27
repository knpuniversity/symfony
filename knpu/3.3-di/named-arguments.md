# Configuring Specific (Named) Arguments

We saw earlier that sometimes you only *need* to pass *one* argument... and the rest
can be autowired. For `MarkdownTransformer`, we *only* need to configure the *second*
argument:

[[[ code('5463492ac0') ]]]

To allow the first to be continue to be autowired, we set it to an empty string.
That works... but it's just weird. So, in Symfony 3.3, there's a better way.

In `MarkdownTransformer`, the argument *names* are `$markdownParser` and `$cache`:

[[[ code('00646afc00') ]]]

The `$cache` argument is the one we need to configure. Back in `services.yml`, copy
the cache service id, clear out the arguments, and add `$cache: '@doctrine_cache.providers.my_markdown_cache'`:

[[[ code('7e2b38e22f') ]]]

The dollar sign is the important part: it tells Symfony that we're actually configuring
an argument by its *name*. `$cache` here must match `$cache` here.

And it works beautifully - refresh now! Everything is happy!

## Named Arguments are Validated

But wait! Isn't this dangerous!? I mean, normally, if I were coding in `MarkdownTransformer`,
I could safely rename this variable to `$cacheDriver`:

[[[ code('42b788d470') ]]]

That change shouldn't make any difference to any code outside of this class.

But suddenly now... it *does* make a difference! The `$cache` in `services.yml`
no longer matches the argument name. Isn't this a huge problem!? Actually, no. Yes,
you *will* get an error - you can see it when you refresh. But this error will happen
if you try to refresh *any* page across your entire system. Symfony validates *all*
of your services and configuration. And as soon as it saw `$cache` in `services.yml`
with no corresponding argument, it screamed.

So yes, changing the argument in your service class *will* break your app. But the
error is unignorable: nothing works until you fix it. Update the configuration to
`$cacheDriver`:

[[[ code('5b0a1e9b00') ]]]

And refresh again.

Back working! This is what makes Symfony's autowiring special. If there is *any*
question or problem wiring the arguments to *any* service, Symfony throws an exception
at *compile* team... meaning, it throws an exception when you try to refresh *any*
page. This means no surprises: it's *not* possible to have an autowiring error on
only *one* page and not notice it.
