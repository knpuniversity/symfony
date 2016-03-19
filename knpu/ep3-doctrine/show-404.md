# Show them a Genus, and the 404

We have a list page! Heck, we have a show page. Let's link them together.

First, the poor show route is nameless. Give it a name - and a new reason to live -
with `name="genus_show"`:

[[[ code('4b7af6f602') ]]]

That sounds good.

In the list template, and the `a` tag and use the `path()` function to point this
to the `genus_show` route. Remember - this route has a `{genusName}` wildcard, so
we *must* pass a value for that here. Add a set of curly-braces to make an array...
But this is getting a little long: so break onto multiple lines. Much better. Finish
with `genusName: genus.name`. And make sure the text is still `genus.name`:

[[[ code('0e55b0bb5e') ]]]

Cool! Refresh. Oooh, pretty links. Click the first one. The name is "Octopus66", but
the fun fact and other stuff is *still* hardcoded. It's time to grow up and finally
make this dynamic!

## Querying for One Genus

In the controller, get rid of `$funFact`. We need to query for a Genus that matches
the `$genusName`. First, fetch the entity manager with `$em = $this->getDoctrine()->getManager()`:

[[[ code('6dac8fe5ba') ]]]

Then, `$genus = $em->getRepository()` with the `AppBundle:Genus` shortcut.
Ok now, is there a method that can help us? Ah, how about `findOneBy()`. This
works by passing it an array of things to find by - in our case `'name' => $genusName`:

[[[ code('af967d44de') ]]]

Oh, and comment out the caching for now - it's temporarily going to get in the way:

[[[ code('3310038fb2') ]]]

Get outta here caching!

Finally, since we have a `Genus` *object*, we can simplify the `render()` call and
*only* pass it:

[[[ code('2eca403371') ]]]

Open up `show.html.twig`: we just changed the variables passed into this template,
so we've got work to do. First, use `genus.name` and then `genus.name` again:

[[[ code('99be045d7b') ]]]

Remove the hardcoded sadness and replace it with `genus.subFamily`, `genus.speciesCount`
and `genus.funFact`. Oh, and remove the `raw` filter - we're temporarily not rendering
this through markdown. Put it on the todo list:

[[[ code('86341b14f8') ]]]

There's *one* more spot down in the JavaScript - change this to `genus.name`:

[[[ code('2f5b2c4526') ]]]

Okay team, let's give it a try. Refresh. Looks awesome! The known species is the
number it should be, there is no fun fact, and the JavaScript is still working.

## Handling 404's

But what would happen if somebody went to a genus name that *did* not exist - like
FOOBARFAKENAMEILOVEOCTOPUS? Woh! We get a bad error. This is coming from Twig:

> Impossible to access an attribute ("name") on a `null` variable

because on line 3, `genus` is null - it's *not* a Genus object:

[[[ code('da07c939c3') ]]]

In the `prod` environment, this would be a 500 page. We do *not* want that - we want
the user to see a nice 404 page, ideally with something really funny on it.

Back in the controller, the `findOneBy()` method will either return *one* Genus object
or null. If it does *not* return an object, throw `$this->createNotFoundException('No genus found')`:

[[[ code('8a26d34c8c') ]]]

Oh, and that message will only be shown to developers - not to end-users.

Head back, refresh, and *this* is a 404. In the `prod` environment, the user
will see a 404 template that you need to setup. I won't cover how to customize the
template here - it's pretty easy - just make sure it's really clever, and send me
a screenshot. Do it!
