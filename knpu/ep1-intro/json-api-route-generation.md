# JSON Responses + Route Generation

Okay, this is cool, but what about APIs and JavaScript front-ends, all the new stuff?  How does Symfony stand up to that?  So, the answer is it stands up great.  It’s just – you can do whatever you want with it.  Some people still make traditional front-end HTML apps, and some people are going the route of pure API back-end.  We’re gonna do a mix of it.

So, right now, our notes are just rendered server-side, inside of our show.html.twig template.  What I wanna do is set up a new API endpoint that returns those notes in JSON and see if we can get this to render dynamically.

So first, how do we create JSON endpoints?  Well, remember that our controller just returns a response.  Symfony doesn’t really care whether that’s HTML or JSON, so actually, this turns out to be really easy.

Create a new controller.  I’ll call it getNotesAction.  This will return notes for a specific genus.  So, use @Route slash genus slash genusName in wildcards slash notes.  In this case, thinking about an API, we want this to only respond to GET requests.  So, to do that, we can add an @Method (“GET”), and without this, your endpoint responds to anything.  Now this will only respond to GET requests.

And notice that it’s highlighting it as a missing import, so don’t forget when you use these annotations to let them autocomplete.  So, when you do that, it adds the use statement you need up there for that.

Once we have that correct, we can go to the console and run ./bin/console debug:router, and you can see our new route at the bottom with method responding to GET.

Okay, great.  So, instead of copying and passing the notes into our template, I’ll remove that, and let’s create a new notes variable over here, set to this beautiful data.  So, we’re not using a database yet, but you can already see this looks kinda like it came out of a database.  It has a username, a photo for each avatar, and the actual note that they took.

Next, I’m gonna create a data variable and just put a notes key inside of that.  You don’t have to do this, but I’m just structuring my JSON so that it has a notes key on it.  And finally, how do we return this as JSON?  return new Reponse, we’ll just json_encode that data.  Boom!  Easy.

So, let’s go see if this works.  I’ll copy the existing URL, add /notes on the end.  Congratulations, you now have a JSON endpoint, effortlessly.

And to get even lazier, we don’t even have to do this json_encode thing.  Instead, we can say return new JsonResponse and just pass it the data.  That does two things.  One, it json_encodes the data for you, and second, it sets the application/json content type header automatically, which we could have done before, but this is a lot easier.  So, refresh.  Still works perfectly.

Now, ultimately, now we can go to this URL directly, but ultimately we’re going to need to write some JavaScript.  Now that we have two pages – well, this new JsonResponse isn’t really a page, but pretend it is for a second.  We can link from this page to our new JSON endpoint.  Eventually, we’re gonna use real JavaScript to do this, but just stay with me.

So, in show.html.twig, let’s get rid of all this notes stuff because we don’t have a notes variable anymore.  Instead, up here, I’m just gonna add a new link tag, and I’m gonna link to this new GetNotes action page.  And, of course, I could do something – just put /genus/{{ name }}/notes.  And if you try that, it is gonna work.  You can click on this.  It takes you to the notes action, but that kinda sucks because I want the flexibility to be able to change my URL, so if later I decide that the URL would be better if it was /comments, then obviously that’s gonna break all of our links across our site.

So, routing really has two jobs.  One is to create the URL for the page, but a second thing is route generation.  You can actually generate the URL to this route, and to do that, you need to give it a name.  So, after the URL, I’ll do comma, name=, and this can be anything, but it’s usually underscore lowercase, genus_show_notes.  And then in twig, instead of hardcoding that URL, you can use curly-curly and use a path function.  

And then to start path function – path function has two arguments.  The first argument is the name of that route, so genus_show_notes, and the second is an array, so in twig, use curly brace-curly brace for an array, just like JavaScript.  It’s gonna be an array of all the wildcards we need to fill in.  So in this case, genusName needs to be filled in, so we’ll say genusName, and we’ll set that to the name variable that we have available to us in the twig template.

So now, if we go back and refresh, that still links the exact same way, but if we did go back later and change the path on our routes, then it would automatically update all of our links.  

Okay, so linking to JSON is not realistic, so let’s actually write some JavaScript to give us a dynamic front-end.

