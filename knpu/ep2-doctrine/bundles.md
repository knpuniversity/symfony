Hey, you're back! I knew you would be and you are not going to be dissapointed.
In this episode we are covering some of the most critical parts to absolutely
mastering Symfony. 

To code along with me through this tutorial, download the code and move into
the start directory, and start up the built in web server. I have my code right
here. Open up a new tab in your terminal, and run the `./bin/console server:run`
command. 

Now that's done, head over to the browser and we should be able to load
`localhost:8000/genus/octopus` which is the page we made in the last tutorial.
Awesome!

Quick review, In the first episode of this series we found out that the core
of what Symfony does is not really that much. You create a route, a controller,
and in that controller you return a response object. So, Route -> controller ->
response. And there you have half of Symfony. 

The second half of Symfony is a huge number of optional useful objects that you
can use to get work done. For example, there's a logger object, a mailer object, and
even a templating object to help you render templates. In fact, this render shortcut
is just a shortcut to go out to the templating service and call a method on it. 

For convenience all of these useful objects, or services, are put into one big
object called the container. If I give you the container then you are really 
dangerous because you can grab whatever objects you want off of it. 

How do we know what services are inside of the container? To find that out head 
over to the terminal and use the handy `./bin/console debug:container` command
which gives us this huge list of objects here. You can even search for things by
adding what you want to the end of the command, like log, which will give us info
about the logger service.

Now that we know that we have this giant list of services aren't you wondering
where these are coming from? What magical being is providing these services to us?
The answer is: bundles. 

Head back to your IDE and in the app directory open up the `AppKernel.php` file. 
This is the heart of your Symfony application, but it really doesn't do much. 
Its only job is to answer what bundles are in the system. A bundle is basically
just a Symfony plugin. Well it is a little more important than that but to keep
things simple think of it as a plugin. The primary job of a bundle is to add more
services to your container. 

This means that the giant list we saw a second ago all comes from one of the services
inside of this list. 

So, what is a bundle? It's basically just a directory with some php classes and
a little bit of configuration. Nothing too scary, in fact we have our own bundle
called `AppBundle` right here which will have the same basic structure as any of 
these core bundles. 

Why do you care? Because I have a new challenge for us! I want to render some of
the information about our octopus through markdown. Specifically, we're going to
start with the fun fact. So the question is, does Symfony already have a tool that
is able to render markdown? 

We could go and read the documentation about that or we could just search the container
for `markdown` at the end of our debug:container command. And there are no services
matching `markdown`. This means that there's no tool to help us with this. 

This is where the awesome Symfony community comes in, because much of the time
there is a community bundle for this. And in this case, there is one called
`KnpMarkdownBundle` and if we install this it's going to give us a tool to render
markdown. Grab it's composer require line, and you don't need to include the version
constraint. And let's run that back in the terminal, and while we're waiting 
grab this new statement here which goes into our `AppKernel`. I'll drop it right
here between the core bundles. That's it! 

Now we just have to wait for composer to finish its job, and maybe send a nice
tweet to Jordi. And there we go!

Without doing anything else, in the terminal, run `debug:container` again and
search for `markdown`. Boom! This time two services are returned, that are coming
from that bundle we just installed. The one we're really interested in is 
`mardown.parser`. 

Let's see if we can use this. In the template, remove the fun fact text and move
it into our `GenusController` with a new `$funFact` variable. And to make things
really interesting let's throw some asterisks around three-tenths. Now, when we
render this through markdown that should show up as italics. 

Pass `funFact` as a variable into our template and render that with `{{ funFact }}`.
Nothing special, and when we refresh in our browser we have the exact same text with
asterisk around it. This isn't our end goal, so how do we get access to the services?

As I showed you a second ago, in the controller we can always say, `this->container->get()`.
So add, `$funFact = $this->container->get('markdown.parser')`. This will give us
that object, and the method you can call on that is `->transform()` and pass it
`$funFact`. How do I know that this has a method called `->transform()`? Well it 
autocompleted for me, but also, you could read the documentation down here and see
how to use the bundle you are installing. 

Let's try this out! Refresh your browser. And hey, it's working! Not exactly how
I want it to yet. Check out the page source, it is rendering in html, but it is 
also escaping it inside of our template. The reason for this is Twig. One of the
great features of Twig is that for security everything is automatically escaped. 
If you do have a spot where you don't want Twig to escape something, just add
`|raw`. 

Now when we refresh, it is rending in some lovely italics. 

One more thing, because I will be doing this alot. Inside of your controller you can
say `$this->container->get()` or you can be lazy, save a few key strokes and just 
write `$this->get()`. This is a really nice shortcut. 

We bring bundles into the system because they add more services or tools to our
project. So my question now is, how can we configure those services so that we can 
control exactly what they do?

