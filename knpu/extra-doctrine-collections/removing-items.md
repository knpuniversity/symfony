# Removing Items

Back on the Genus page, here's what I want to do next. I want to add a little x icon, and when we click that, it will make an AJAX called-in server and remove this scientist from this genus.

Now the way that we're going to do this inside of Doctrine is exactly the same way that we add a user to a genus. So to make the link, we just added a user object to the genusScientist array, so to remove that link and delete the row in the joint table, we just need to remove that user from the genus scientist array and save. Doctrine will notice that our user is missing from our genus scientist collection, and it will delete that row from the database automatically, which is pretty awesome.

So let's start inside of our genus/show template, and I'm going to add a new link down here and it will give us some styling classes, and a special class called js-remove-scientist-user, which we'll use in JavaScript in a second to attach some behavior to this link.

With the content, let's put a little close icon.

Perfect.

Now, down below, in our JavaScript, let's start to get this hooked up. Start a script tag, with a (document).ready block, and inside of here, we will select that js-remove-scientist-user, and on click, we'll add a function, so easy stuff here. We'll put the e.preventDefault on that.

Great.

So inside of here, we're going to make an AJAX call, so let's actually go and set up that AJAX end point, and we'll do it inside of genus controller all the way at the bottom. Let's make a new public function inside of here called removeGenusScientistAction.

And give us an @route, and let's set the u route to /genus/{genusId}/scientist/{userId}.

You see, the only way for us to identify exactly what to remove is to pass both the genus ID and the user ID up to the system, so we can figure out which user to remove from the genus, now the u route structure here doesn't really matter, but it is kind of nice that we're sort of identifying a genus, have a little word here that identifies the scientist, and then we're identifying a specific user on that.

Give the route a name like genusScientist remove and finally add an @method for delete.

You don't have to do this, but this is a nice way of saying if you make a delete request to this URL, we will delete this user from that genus.

We might also have another end point in the future that has the exact same URL, but is a way for us to fetch information about this user who is studying this genus.

Make sure you add the genus ID and user ID arguments against the controller.

Next, grab the end [inaudible 00:04:25] with this getDoctrine getManager, and we now just need to query for the genus and the user which is going to pretty simple.

Say genus = em getRepository app on load genus→find genusId. I'll add some inline documentation above that so that [inaudible 00:04:51] knows that's a genus object, and of course if not genus, then we need to throw this→createNotFoundException, and we'll just say genus not found.

I'll copy all of that down here, and we'll change this to genusScientist which is actually s-querying from the user table, but I'm calling it a genusScientist, and here we will query for the user ID.

If we don't find a genus scientist, we will say genus scientist not found.

Great. So we have the user object, we have the genus object, now we just need to remove them from each other.

We don't have a way inside of genus to do that yet, so right below addGenusScientist, make a new public function called removeGenusScientist.

This will take a user object as an argument, and then what are we going to do inside of it? Very simply, we're will say this→genusScientist→removeElement($user). In other words, just remove the user from that array. That doesn't touch the database yet, it just removes that element from that array using a fancy convenience method called remove element.

Back in the controller, we can call genus→removeGenusScientist($user). And past that our genus scientist, which is our user object.

And that's it. At this point, I'll persist the genus. I will flush the genus, and that will take care of updating the database for us.

Finally, at the bottom, we have to return something.

There's not really any information we need to return from this AJAX end point, so I'm going to return a new response with null as the content coming back and a 204 status code.

You've probably seen me do that before. This is just a nice way to return a response that is valid and successful, but you have nothing to send back. The 204 means blank response.

So now let's finish hooking this up inside of our template.

First go back up to the anchor and add another attribute called data-url. Set that to path. We're going to set this to the URL to that delete link. I'm going to say genus_scientist_remove, and we'll pass it genusId set to genus.id and userId set to genusScientist which again is a user object.id. In a second, we will read that key from JavaScript.

First, find the first li above this, and also give that a js-scientist-item key. That'll help us in JavaScript here in a second.

Now scroll back down to our JavaScript here, and I'm going to paste in just a few lines of code here to get us started.

These are really simple. This first line here just starts with the anchor, which is represented by this, and finds the js-scientist item which is the li element that surrounds this, and we're not doing anything with that at this second, but we will in a moment.

Secondly, what we do here, is I actually find my little close icon, and I replace it with a spinner icon so it looks like this is loading.

The real work, though, is for us to make an AJAX call, and I'll do that with $.AJAX, and here we'll set the URL to this which is the anchor that was just clicked .data URL. That will give us the data-url attribute, and then we'll set method=delete. And that's it.

And just to make things a little fancier, we'll add a .done at the end. When everything is done, we will call l.fadeout. We'll find the li tag on everything, and we'll fade it out so it actually looks deleted.

Phew! Okay.

Let's give that a try.

Refresh the page. There's our fancy anchor tag here. If you click that, it fades away. If you look quickly at the web debug tool bar, you can see our delete AJAX call right here, along with our other get AJAX calls for the notes on this page. If we click that and go to Doctrine, we should see ... Here it is ... delete from genus scientist where genus_id = 11 and user_id = 11, so that is the deleting of our scientist.

Now when I go back and refresh, it's gone. So it's a long way of saying that handling things in that joint table, it's as simple as adding users and removing users from your genus scientist array.

It's that simple guys, come on.
