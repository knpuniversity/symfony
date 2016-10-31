# Hooking up the Scientist Removal JavaScript

Endpoint, done! Let's call this bad boy from JavaScript. Back in the template, each
delete link will have a different URL to the endpoint. Add a new attribute called
`data-url` set to `path('genus_scientist_remove')` and pass it `genusId` set to
`genus.id` and `userId` set to `genusScientist.id`. Remember, that's a `User` object.

Oh, and do one more thing: give the `li` above its own class: `js-scientist-item`.
That'll also help in JavaScript.

## Making the AJAX Call

Scroll back to the `javascripts` block. I'll paste a few lines of code here to get
us started.

Ok, no big deal: the first line uses `$(this)`, which is the link that was just clicked,
and finds the `.js-scientist-item` li that is around it. We'll use that in a minute.
The second chunk changes the `fa-close` icon into a loading spinner... ya know...
because we deserve fancy things.

The *real* work - the AJAX call - is up to us. I'll use `$.ajax()`. Set the `url`
key to `$(this).data('url')` to read the attribute we just set. And then, set
`method` to `DELETE`.

To add a little bit *more* fancy, add a `.done()`. After the AJAX call finishes,
call `$el.fadeOut()` so that the item disappears in dramatic fashion.

Testing time! Refresh.

Cute close icon, check! Click it! It faded away in dramatic fashion! Yes!

## Checking the Delete Query

Check out the web debug toolbar's AJAX icon. Mixed in with AJAX call for notes is
our DELETE call. Click the little sha, then go to the Doctrine tab. Ooh, look at
this:

> DELETE from genus_scientist where genus_id = 11 AND user_id = 11

Gosh darn it that's nice. To prove it, refresh: the scientist is gone. ManyToMany?
Yea, it's as simple as adding and removing objects from an array.

Well, ok, it *will* get a bit harder soon...
