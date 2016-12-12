# Using the new OneToMany Collections

Open up the `genus/show.html.twig` template. Actually, let's start in the `Genus`
class itself. Find `getGenusScientists()`:

[[[ code('3f72a8f236') ]]]

This method is lying! It does not return an array of `User` objects, it returns
an array of `GenusScientist` objects!

[[[ code('11a5c8f4d0') ]]]

In the template, when we loop over `genus.genusScientists`, `genusScientist` is *not*
a `User` anymore. Update to `genusScientist.user.fullName`, and above, for the `user_show`
route, change this to `genusScientist.user.id`:

[[[ code('ec45fde385') ]]] 

Then, in the link, let's show off our new `yearsStudied` field: `{{ genusScientist.yearsStudied }}`
then years:

[[[ code('ddc0242634') ]]]

We still need to fix the remove link, but let's see how it looks so far!

Refresh! It's way less broken! Well, until you click to view the user!

## Updating the User Template

To fix this, start by opening `User` and finding `getStudiedGenuses()`. Change the
PHPDoc to advertise that this *now* returns an array of `GenusScientist` objects:

[[[ code('656651b8a8') ]]]

Next, go fix the template: `user/show.html.twig`. Hmm, let's rename this variable
to be a bit more clear: `genusScientist`, to match the type of object it is. Now,
update `slug` to be `genusScientist.genus.slug`. And print `genusScientist.genus.name`:

[[[ code('3cfed09d22') ]]]

Try it! Page is alive!

## Updating the Delete Link

Back on the genus page, the other thing we need to fix is this remove link. In the
`show.html.twig` template for genus, update the `userId` part of the URL:
`genusScientist.user.id`:

[[[ code('a640e8f884') ]]]

Next, find this endpoint in `GenusController`: `removeGenusScientistAction()`:

[[[ code('4d3701ff7b') ]]]

It's about to get *way* nicer. Kill the queries for `Genus` and `User`. Replace them with
`$genusScientist = $em->getRepository('AppBundle:GenusScientist')` and `findOneBy()`,
passing it `user` set to `$userId` and `genus` set to `$genusId`:

[[[ code('612145b530') ]]]

Then, instead of removing this link from `Genus`, we simply delete the entity:
`$em->remove($genusScientist)`:

[[[ code('12e53699c2') ]]]

And celebrate!

Go try it! Quick, delete that scientist! It disappears in dramatic fashion, *and*,
when we refresh, it's *definitely* gone.

Phew! We're almost done. By the way, you can see that this refactoring takes some work.
If you know that your join table will probably need extra fields on it, you can save
yourself this work by setting up the join entity from the very beginning and avoiding
`ManyToMany`. But, if you definitely won't have extra fields, `ManyToMany` is way
nicer.

## Updating the Fixtures

The *last* thing to fix is the fixtures. We won't set the `genusScientists` property
up here anymore. Instead, scroll down and add a new `AppBundle\Entity\GenusScientist`
section:

[[[ code('41052d004b') ]]]

It's simple: we'll just build new `GenusScientist` objects ourselves, just
like we did via `newAction()` in PHP code earlier. Add `genus.scientist_{1..50}`
to create 50 links. Then, assign `user` to a random `@user.aquanaut_*` and `genus`
to a random `@genus_*`. And hey, set `yearsStudied` to something random too:
`<numberBetween(1, 30)>`:

[[[ code('cc9592c232') ]]]

Nice! Go find your terminal and reload!

```bash
./bin/console doctrine:fixtures:load
```

Ok, go back to `/genus`... and click one of them. We have scientists!

So our app is fixed, right? Well, not so fast. Go to `/admin/genus`: you might need
to log back in - password `iliketurtles`. Our genus form is still *totally* broken.
Ok, no error: but it doesn't even make sense anymore: our relationship is now more
complex than checkboxes can handle. For example, how would I set the `yearsStudied`?

Time to take this form up a level.
