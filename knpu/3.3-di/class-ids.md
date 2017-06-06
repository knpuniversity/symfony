# Service Class Name as ids

Traditionally, our service ids looked like this: some underscored, lowercased version
of the class name:

[[[ code('9f789a2f9d') ]]]

That's still *totally* legal. But in Symfony 3.3, the best practice has changed:
a service's id should *now* be equal to its *class name*. I know, crazy, right!
This makes life simpler. First, you don't need to invent an arbitrary service id.
And second, class names as ids will work much better with autowiring and service
auto-registration... as you'll see soon.

The only complication is when you have multiple services that point to the same class.
We *will* handle this:

[[[ code('3547fb06a9') ]]]

## Using Class Service ids

So, let's start changing service ids! I'll copy the old `app.markdown_transformer`
id and replace it with `AppBundle\Service\MarkdownTransformer`. When your service
id is your class name, you can actually remove the `class` key to shorten things:

[[[ code('1a04f2d05d') ]]]

Nice!

But when we did that... we broke our app! Any code referencing the old service
id will explode! We could hunt through our code and find those now, but let's save
that for later. There's a faster, *safer* way to upgrade to the new format.

## Create Legacy Aliases to not Break Things

Create a new file in `config` called `legacy_aliases.yml`. Inside, add the normal
`services` key, then paste the old service id set to `@`. Copy the new service
id - the class name - and paste it: `@AppBundle\Service\MarkdownTransformer`:

[[[ code('7bf6ace54a') ]]]

This creates something called a service *alias*. This is *not* a new feature, though
this shorter syntax *is*. A service alias is like a symbolic link: whenever some code
asks for the `app.markdown_transformer` service, the `AppBundle\Service\MarkdownTransformer`
service will be returned. This will keep our old code working with *no* effort.

To load that file, at the top of `services.yml`, add an `imports` key with
`resource` set to `legacy_aliases.yml`:

[[[ code('e03a5fe6cc') ]]]

Now, our app is happy again.

## Updating all of the Service

Let's repeat that for the rest of our services. Honestly, when we upgraded KnpUniversity,
this was the most tedious step: going one-by-one, copying each service id, copying
the class name, and then adding it to `legacy_aliases.yml`. We wrote a dirty script
that used the `Yaml` class to load `services.yml` and at least create the `legacy_aliases.yml`
file for us.

Notice that `LoginFormAuthenticator` has *no* configuration anymore! Cool! Just set
it to a `~`:

[[[ code('50d13a8811') ]]]

Perfect! Let's finish the rest:

[[[ code('3dcddadce1') ]]]

[[[ code('f705efdf94') ]]]

## Multiple Services for the Same Class

[[[ code('44047d6cda') ]]]

The last two services are a problem: we *can't* set the id to the class name, because
the class is the same for each! When this happens, use the old id naming convention.
We're going to talk more about this situation soon.

And, we're done! We just changed all of the service ids to class names... but thanks
to `legacy_aliases.yml`, our code won't break. This may not have felt significant,
but it was actually a big step forward. Now, we can talk about private services.
