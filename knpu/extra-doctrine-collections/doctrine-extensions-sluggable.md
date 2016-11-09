# DoctrineExtensions: Sluggable

Since `slug` is just a *normal* field, we *could* open our fixtures file and add
the slug manually here to set it:

[[[ code('2189a51273') ]]]

LAME! There's a cooler way: what if it were automagically generated from the name?
That would be awesome! Let's go find some magic!

## Installing StofDoctrineExtensionsBundle

Google for a library called [StofDoctrineExtensionsBundle][stof_doctrine_extensions_bundle].
You can find its docs on Symfony.com. First, copy the composer require line and paste
it into your terminal:

```bash
composer require stof/doctrine-extensions-bundle
```

Second, plug the bundle into your `AppKernel`: copy the `new` bundle statement,
open `app/AppKernel.php` and paste it here:

[[[ code('6bd6798483') ]]]

And finally, the bundle needs a little bit of configuration. But, the docs are kind
of a bummer: it has a lot of not-so-important stuff near the top. It's like a treasure
hunt! Hunt for a golden cold block near the bottom that shows some `timestampable`
`config.yml` code. Copy this. Then, find our `config.yml` file and paste it at the
bottom. And actually, the *only* thing we need is under the `orm.default` key: add 
`sluggable: true`:

[[[ code('44eb022559') ]]]

This library adds *several* different magic behaviors to Doctrine, and `sluggable` -
the automatic generation of a slug - is just one of them. And instead of turning
on *all* the magic features by default, you need to activate the ones that you want.
That's actually pretty nice. Another great behavior is `Timestampable`: an easy way
to add `createdAt` and `updatedAt` fields to any entity.

## The DoctrineExtensions Library

Head back to the documentation and scroll up. Near the top, find the link called
[DoctrineExtensions documentation][doctrine_extensions_docs] and click it.

The truth is, `StofDoctrineExtensionsBundle` is just a small wrapper
around this `DoctrineExtensions` library. And that means that *most* of the documentation
also lives here. Open up the `Sluggable` documentation, and find the code example.

## Adding the Sluggable Behavior

Ok cool, this is *easy*. Copy the Gedmo `use` statement above the entity: it's needed
for the annotation we're about to add. Open `Genus` and paste it there:

[[[ code('c1f02497ac') ]]]

Then, above the `slug` field, we'll add this `@Gedmo\Slug` annotation. Just change `fields`
to simply `name`:

[[[ code('7fdbd7e07c') ]]]

That is it! Now, when we *save* a `Genus`, the library will automatically generate
a unique `slug` from the name. And that means *we* can be lazy and *never* worry
about setting this field ourselves. Nice.

## Reload the Fixtures

Head back to your terminal. Woh! My `composer require` blew up! But look closely:
the library *did* install, but then it errored out when it tried to clear the cache.
This is no big deal, and was just bad luck: I was *right* in the middle of adding
the `config.yml` code when the cache cleared. If I run `composer install`, everything
is happy.

Now, because our fixtures file sets the `name` property, we should just be able to
reload our fixtures and watch the magic:

```bash
./bin/console doctrine:fixtures:load
```

So far so good. Let's check the database. I'll use the `doctrine:query:sql` command:

```bash
./bin/console doctrine:query:sql 'SELECT * FROM genus'
```

Got it! The name is Balaena and the slug is the lower-cased version of that. Oh,
and at the bottom, one of the slugs is `trichechus-1`. There are *two* genuses with
this name. Fortunately, the Sluggable behavior guarantees that the slugs stay unique
by adding `-1`, `-2`, `-3` etc when it needs to.

So the slug magic is all done. Now we just need to update our app to use it in
the URLs.


[stof_doctrine_extensions_bundle]: https://symfony.com/doc/current/bundles/StofDoctrineExtensionsBundle/index.html
[doctrine_extensions_docs]: https://github.com/Atlantic18/DoctrineExtensions/tree/master/doc/
