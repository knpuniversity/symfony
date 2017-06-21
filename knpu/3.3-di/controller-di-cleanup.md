# Autowiring Controller Arguments

Our app is now *fully* using the new config features. It's time to start enjoying
it a little!

Let's start by cleaning up `legacy_aliases.yml`:

[[[ code('93326875dd') ]]]

Remember, we created this because these old service ids might still be used in
our app. Let's eliminate these one-by-one.

Copy the first id and go see where it's used:

```terminal
git grep app.markdown_transformer
```

## Private Services and $container->get()

Ok! This is used in `GenusController`. Open that up - there it is!

[[[ code('90a3cebda2') ]]]

Easy fix! Let's change this to use the new service id: `MarkdownTransformer::class`:

[[[ code('3ff867efe4') ]]]

Awesome! Let's try it: navigate to `/genus`. That code was on the show page, so click
any of the genuses and... explosion!

> You have requested a non-existent service `AppBundle\Service\MarkdownTransformer`.

But... we *know* that's a service: it's even *explicitly* configured:

[[[ code('07bb4de882') ]]]

What's going on!?

Remember, *all* of these services are *private*... which means that we *cannot*
fetch them via `$container->get()`:

[[[ code('021ad65ed8') ]]]

This is actually one of the *big* motivations behind all of these autowiring and
auto-registration changes: we do not want you to fetch things out of the container
directly anymore. Nope, we want you to use dependency injection.

Not only is dependency injection a better practice than calling `$container->get()`,
using it will actually give you better *errors*!

For example, if you use `$container->get()` and accidentally fetch a service that
doesn't exist, you'll only get an error if you visit a page that runs that code.
But if you use dependency injection and reference a service that doesn't exist, you'll
get a huge error when you access *any* page or try to do *anything* in your app.
If you make all services private, the new config system is actually more stable than
the old one.

## Controller Action Injection

To fix our error, we need to use classic dependency injection. And actually, there
are *two* ways to do this in a controller. First, we could of course, go to the top
of our class, add a `__construct` function, type-hint a `MarkdownTransformer` argument
set that on a property, and use it below. Thanks to autowiring, we wouldn't
need to touch any config files.

But, because this is a bit tedious and so common to do in a controller, we've added
a shortcut. In controllers *only*, you can autowire a service into an argument of
your action method. We'll add `MarkdownTransformer $markdownTransformer`:

[[[ code('78660af441') ]]]

Now, remove the `$this->get()` line... which is a shortcut for `$this->container->get()`.

This fixes things... because we've eliminated the `$container->get()` call that
does *not* work with private services.

Celebrate by removing the first alias! The rest are easy!

[[[ code('4ab3841a23') ]]]

The `app.markdown_extension` id isn't referenced anywhere, so remove that. The
`app.security.login_form_authenticator` is used in *two* places: `security.yml`
and also `UserController`:

[[[ code('f32cd1b9d1') ]]]

[[[ code('4ebe21692d') ]]]

Copy the new service id - the class name. In `security.yml`, just replace the old
with the new:

[[[ code('49b3b72d86') ]]]

Next, in `UserController`, I'll search for "authenticator". Ah, we're fetching it
out of the container directly! We know the fix: type-hint a new argument with
`LoginFormAuthenticator $authenticator` and use that below:

[[[ code('407ef6e468') ]]]

Almost done! The `app.doctrine.hash_password_listener` service isn't being used anywhere,
and neither is `app.form.help_form_extension`.

And... that's it! At the top of `services.yml`, remove the import:

[[[ code('b4d6e6b3d1') ]]]

Then, delete `legacy_aliases.yml`.

Our *last* public service is `MessageManager`:

[[[ code('4a0c777718') ]]]

Now we know how to fix this. In `GenusAdminController`, find `editAction()` and add
an argument: `MessageManager $messageManager`:

[[[ code('578a69e7a7') ]]]

Use that below in both places:

[[[ code('f399fb00dc') ]]]

Back in `services.yml`, make that service private:

[[[ code('036931ea75') ]]]

This is reason to celebrate! *All* our services are now private! We're using proper
dependency injection on everything! Thanks to this, the container will optimize itself
for performance *and* give us clear errors if we make a mistake... anywhere.

Next, we need to talk more about aliases: the key to unlocking the full potential of
autowiring.
