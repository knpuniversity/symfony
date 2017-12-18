# Bye Bye AppBundle

If you want to stop now, you can! Your old code lives in `src/AppBundle`, but it
works! Over time, you could slowly migrate it directly into `src/`.

But I'm feeling pretty excited after our work so far: so let's move the files all
at once! If you're not using PhpStorm... this will be a nightmare. So this is one
of those rare times when you really *must* use it, if you want to move *all* of
your files quickly.

## Moving your Files

Open `AppBundle.php`. Then, right click on the `AppBundle` namespace and go to
Refactor -> Move. The new namespace will be `App`. And below... yea! The target
destination should simply be `src/`. If you need to change this, press F12.

So this says: change all `AppBundle` namespaces to `App` and move things into the
`src/` directory. Try it! On the big summary, click OK!

In addition to changing the namespace at the top of each file, PhpStorm is also
finding *references* to the namespaces and changing those too. Will it be perfect?
Of course not! But that last pieces are pretty easy.

Woh! Check this out! Everything is directly in `src/`. AppBundle is now empty, except
for a `fixtures.yml` file. We're actually going to replace that file soon anyways.

Delete AppBundle! That felt amazing!

## Refactoring tests/

Let's do the same thing for the `tests/` directory... even though we only have one
file. Open `DefaultControllerTest.php` and Refactor -> Move its namespace. In Flex,
the namespace should start with `App\Tests`. Then, press F12 to change the directory
to `tests/Controller`.

Ok, Refactor! Nice! Now delete that AppBundle.

## Cleaning up AppBundle

With those directories gone, open `composer.json` and find the `autoload` section.
Remove *both* `AppBundle` parts.

So... will it work? Probably not - but let's try! Refresh! Ah!

> The file ../src/AppBundle does not exist in config/services.yaml

Ah, that makes sense. Open that file: we're still trying to import services from
the old directory. Delete those two sections. And, even though it doesn't matter,
remove `AppBundle` from the exclude above.

In `routes.yaml`, we *also* have an import. Remove it! Why? Annotations are already
loaded from `src/Controller`. And *now*, that's where our files are!

Oh, and change `AppBundle` to `App` for the homepage route - I can now even
Command+Click into that class. Love it!

Back in `services.yaml`, we still have a lot of `AppBundle` classes in here: PhpStorm
is *not* smart enough to refactor YAML stings. But, the fix is easy: Find all
`AppBundle` and replace with `App`.

Done! There is one last thing we need to undo, in `config/packages/doctrine.yaml`.
Remove the `AppBundle` mapping we added.

So, what other `AppBundle` things haven't been updated yet? It's pretty easy to
find. At your terminal, run:

```terminal
git grep AppBundle
```

Hey! Not too bad. And most of these are the same: calls to `getRepository()`.
Start in `security.yaml` and do the same find and replace. You could do this for
your *entire* project, but I'll play it safe.

Now, *completely* delete the `AppBundle.php` file: we're *totally* not using that
anymore. Next is `GenusAdminController`. Open up that class. But instead of replacing,
which *would* work, search for AppBundle. Ah! It's a `getRepository()` call!

Our project has a lot of these... and... well... if you're lazy, there's a secret
way to fix it! Just change the `alias` in `doctrine.yaml` from `App` to `AppBundle`.
Cool but... let's do it the right way! Use `Genus::class`.

We have a few more in `GenusController`. Use `SubFamily::class`, `User::class`, 
`Genus::class`, `GenusNote::class` and `GenusScientist::class`.

Ok, back to the list! Ah, a few entities still have `AppBundle`. Start with `Genus`.
The `repositoryClass`, of course! Change `AppBundle` to `App`. There's another
reference down below on a relationship. Since all the entities live in the same
directory, this can be shortened to just `SubFamily`. 

Make the same change in `GenusNote`, `SubFamily` and `User`. 

Almost done! Next is `GenusFormType`: open that and change the `data_class` to
`Genus::class`.

Then, finally, `LoginFormAuthenticator`. Change `AppBundle:User` to `User::class`.

Phew! Search for `AppBundle` again:

```terminal-silent
git grep AppBundle
```

They're gone! So... ahh... let's try it! Refresh! Woh! An "Incomplete Class" error?
Fix it by manually going to `/logout`. What was that? Well, because we changed
the `User` class, the User object in the session couldn't be deserialized. On
production, your users shouldn't get an error, but they *will* likely be logged
out when you first deploy. 

Go back to `/admin/genus`, then login with `weaverryan+2@gmail.com`, password
`iliketurtles`. Guys, we're done! We have a Symfony 4 app, built on the Flex directory
structure and with *no* references to AppBundle. And it was all done in a safe,
gradual way.

To celebrate, I've added one last video with a few reasons to be *thrilled* that
you've made it this far.
