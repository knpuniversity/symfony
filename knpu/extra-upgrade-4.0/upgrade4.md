# Upgrade to Symfony 4.0

With the deprecations gone... yeah! It's time to upgrade to Symfony 4! If you
were hoping this was going to be really cool and difficult... sorry. It's *super*
easy... well... *mostly* easy.

Open `composer.json` and change `symfony/symfony` to `^4.0`. There are a few other
libraries that start with `symfony/`, but they're independent and follow different
release cycles. Oh, except for `symfony/phpunit-bridge`: change that to `^4.0` also.

[[[ code('21b00f2815') ]]]

Let's do this! Find your terminal and run:

```terminal
composer update
```

Yep, upgrading is *just* that easy! Except... there are almost *definitely* some
libraries in our `composer.json` file that are *not* yet compatible with Symfony 4.
The best way to find out is just to try it! And then wait for an explosion!

## Removing Alice

Ah! Here is our first! Look closely... this is coming from `nelmio/alice`: the version
in our project is *not* compatible with Symfony 4. If we did some digging, we would
find out that there *is* a new version of Alice that *is* compatible. But, that version
also contains a lot of changes to Alice... and I don't like the library's new version
very much. At least, not at this moment.

So, instead of upgrading, remove alice from `composer.json`. This will break our
fixtures: we'll fix them later.

Update again!

```terminal-silent
composer update
```

## Removing Outdated Libraries

Our next explosion! This comes from `incenteev/composer-parameter-handler`. This
library helps you manage your `parameters.yml` file and... guess what? When we
finish upgrading, that file will be *gone*! Yep, we do not need this library anymore.

Remove it from `composer.json`. Oh, also remove the distribution bundle: it helps
support the *current* directory structure, and isn't needed with Flex. And below,
remove the generator bundle. We'll install the new MakerBundle later.

Ok, update again!

```terminal-silent
composer update
```

## When a Library is not Ready: StofDoctrineExtensionsBundle

It works! I'm just kidding - it totally exploded again. This time the culprit is
StofDoctrineExtensionsBundle: the version in our project is not compatible with Symfony
4. Now... we become detectives! Maybe the library supports it in a new version?
Let's find out.

Google for StofDoctrineExtensionsBundle to find its [GitHub](https://github.com/stof/StofDoctrineExtensionsBundle)
page. Check out the [composer.json file](https://github.com/stof/StofDoctrineExtensionsBundle/blob/4619e9d8190f19aac7c9e44f78d13710b7f2966a/composer.json#L16).
It *does* support Symfony 4! Great! Maybe there's a new version that has this! Check
out the releases. Oof! No releases for a *long*, long time.

This means that Symfony 4 support *was* added, but there is not *yet* a release
that contains that code. Honestly, by the time you're watching this, the bundle
probably *will* have a new release. But this is likely to happen with other libraries.

Actually, another common problem is when a library does *not* have Symfony 4 support,
but there is an open pull request that adds it. In both situations, we have a problem,
and *you* have a choice to make.

First... you can wait. This is the most responsible decision... but the least fun.
I hate waiting!

Second, if there is a pull request, you can use that *fork* as a custom composer
repository and temporarily use that until the library merges the pull request and
tags a release. For example, imagine this pull request was *not* merged. We could
add this as a `vcs` repository in `composer.json`, and then update the version constraint
to `dev-master`, because the branch on the fork is `master`.

And third, since the pull request *is* merged, but there is no tag, we can simply
change our version to `dev-master`. Believe me: I am *not* happy about this. But
I'll update it later when there *is* a release.

[[[ code('505911cc20') ]]]

Try to update again:

```terminal-silent
composer update
```

Ha! Look! It's *actually* working! Say hello to our new Symfony 4 app! Woohoo!

## Upgrading old Packages

Oh, but check out that warning: the `symfony/swiftmailer-bridge` is abandoned. I
don't like that! Hmm, I don't see that package in our `composer.json` file. Run:

```terminal
composer why symfony/swiftmailer-bridge
```

Ah! It's required by `symfony/swiftmailer-bundle`. We're using version `2.3.8`,
which is *apparently* compatible with Symfony 4. But I wonder if there's a newer
version?

***TIP
Actually, version 2.3.8 is *not* compatible with Symfony 4. But due to an old issue
with its `composer.json` file, it *appears* compatible. Be careful with old libraries!
***

Google for the package to find its [GitHub](https://github.com/symfony/swiftmailer-bundle)
page. Click releases.

Woh! There is a new version *3* of the bundle. And I bet it fixes that abandoned
packages issue. Change our version to `^3.1`.

[[[ code('e633fcdd82') ]]]

And now, update! 

```terminal-silent
composer update
```

Because we're upgrading to a new *major* version, you'll want to check out the
CHANGELOG on the project to make sure there aren't any major, breaking changes.

Yes! Abandoned package warning gone! And our project is on Symfony 4. Not bad!

But... get ready... because now the *real* work starts. And the fun! It's time to
migrate our project to the Flex project structure!
