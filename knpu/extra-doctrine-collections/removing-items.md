# Removing a ManyToMany Item

Back on the Genus page, I want to add a little "X" icon next to each user. When
we click that, it will make an AJAX call that will remove the scientist from
this `Genus`.

## How a ManyToMany Link is Removed

To link a `Genus` and a `User`, we just added the `User` object to the `genusScientists`
property:

[[[ code('94187180f5') ]]]

So guess what? To *remove* that link and delete the row in the join table, we do
the exact opposite: *remove* the `User` from the `genusScientists` property and
save. Doctrine will notice that the `User` is missing from that collection and
take care of the rest.

## Setting up the Template

Let's start inside the the `genus/show.html.twig` template. Add a new link for
each user: give some style classes, and a special `js-remove-scientist-user`
class that we'll use in JavaScript. Add a cute close icon:

[[[ code('6e5cdd9ee6') ]]]

Love it! Below, in the `javascripts` block, add a new `script` tag with a
`$(document).ready()` function:

[[[ code('f74cf8a0c3') ]]]

Inside, select the `.js-remove-scientist-user` elements, and `on` `click`,
add the callback with our trusty `e.preventDefault()`:

[[[ code('04ec1b2784') ]]]

## The Remove Endpoint Setup

Inside, we need to make an AJAX call back to our app. Let's go set that up.
Open `GenusController` and find some space for a new method:
`public function removeGenusScientistAction()`. Give it an `@Route()` set to
`/genus/{genusId}/scientist/{userId}`:

[[[ code('a3335485be') ]]]

You see, the *only* way for us to identify exactly *what* to remove is to pass both
the `genusId` and the `userId`. Give the route a name like `genus_scientist_remove`.
Then, add an `@Method` set to `DELETE`:

[[[ code('34b8ce4816') ]]]

You don't *have* to do that last part, but it's a good practice for AJAX, or API
endpoints. It's very clear that making this request will delete something. Also,
in the future, we could add another end point that has the *same* URL, but uses
the `GET` method. That would *return* data about this link, instead of deleting it.

Any who, add the `genusId` and `userId` arguments on the method:

[[[ code('c67d0cbd33') ]]]

Next, grab the entity manager with `$this->getDoctrine()->getManager()` so we can
fetch both objects:

[[[ code('3348596de0') ]]]

Add `$genus = $em->getRepository('AppBundle:Genus')->find($genusId)`:

[[[ code('b5e7e46dd9') ]]]

I'll add some inline doc to tell my editor this will be a `Genus` object. And of
course, if `!$genus`, we need to `throw $this->createNotFoundException()`: "genus
not found":

[[[ code('dcd4b5d1ca') ]]]

Copy *all* of that boring goodness, paste it, and change the variable to `$genusScientist`.
This will query from the `User` entity using `$userId`. If we don't find a `$genusScientist`,
say "genus scientist not found":

[[[ code('cf2812e834') ]]]

## Deleting the Link

Now *all* we need to do is remove the `User` from the `Genus`. We don't have a method
to do that yet, so right below `addGenusScientist()`, make a new public function
called `removeGenusScientist()` with a `User` argument:

[[[ code('33c30c9918') ]]]

Inside, it's *so* simple: `$this->genusScientists->removeElement($user)`:

[[[ code('1554876da6') ]]]

In other words, just remove the `User` from the array... by using a fancy convenience
method on the collection. That doesn't touch the database yet: it just modifies the array.

Back in the controller, call `$genus->removeGenusScientist()` and pass that the
user: `$genusScientist`:

[[[ code('f6fc79517d') ]]]

We're done! Just persist the `$genus` and flush. Doctrine will take care of the
rest:

[[[ code('e6d6987f04') ]]]

## Returning from the Endpoint

At the bottom, we still need to return a Response. But, there's not really any information
we need to send back to our JavaScript... so I'm going to return a `new Response`
with `null` as the content and a 204 status code:

[[[ code('92f883ef4e') ]]]

This is a nice way to return a response that is successful, but has no content.
The 204 status code literally means "No Content".

Now, let's finish this by hooking up the frontend.
