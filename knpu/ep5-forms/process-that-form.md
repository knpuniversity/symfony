# Process that Form!

Inspect the HTML and check out the `<form>` element. Notice: this does *not* have
an `action` attribute. This means that the form will submit right back to the same
route and controller that renders it. You *can* totally change this, but we won't.

In other words, our single action method will be responsible for *rendering* the form
*and* processing it when the request method is POST.

Before we do any processing, we need the request. Type-hint it as an argument:

[[[ code('87f2bfa891') ]]]

## $form->handleRequest()

Next, to actually handle the submit, call `$form->handleRequest()` and pass it the
`$request` object:

[[[ code('5c828e90cc') ]]]

This is really cool: the `$form` knows what fields it has on it. So `$form->handleRequest()`
goes out and grabs the post data off of the `$request` object for those specific fields
and processes them.

The *confusing* thing is that this *only* does this for POST requests. If this is
a GET request - like the user simply navigated to the form - the `handleRequest()`
method does nothing and our form renders just like it did before.

***TIP
You *can* configure the form to submit on GET requests if you want. This is
useful for search forms
***

But if the form *was* just submitted, then we'll want to do something with that
information, like save a new `Genus` to the database. Add an if statement:
`if ($form->isSubmitted() && $form->isValid())`:

[[[ code('5377756e6b') ]]]

In other words, if this is a POST request and if the form passed all validation.
We'll add validation soon.

## Fetching $form->getData()

If we get inside this `if` statement, life is good. For now, just dump the submitted
data: `dump($form->getData())` and then `die;`:

[[[ code('e9f6199ca7') ]]]

OK, let's see what this dumps out!

Fill out the form with very realistic data and submit. Check that out! It dumps
and associative array with the three fields we added to the form. That's so simple!
We added 3 fields to the form, rendered them in a template, and got those three
values as an associative array.

Now, it would be very, very easy to use that associative array to create a new `Genus`
object, populate it with the data, and save it via Doctrine.

But, it would be awesomesauce if the form framework could do our job for us. I mean,
use the data to automatically create the `Genus` object, populate it, and return
*that* to us. Let's do that.
