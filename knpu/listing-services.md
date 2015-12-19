# Listing and Using Services

Rendering a template is pretty common, so there's a shortcut when you're in a controller.
Replace all of this code with a simple `return $this->render`.

That's it. Make sure this works by refreshing.

----> TODO START HERE!!


Nice, things look happy here! If this looks kind of magical to you, let's look deeper. This render function comes
from the base controller. I'll hold command or control (depending on your OS), click render and it takes me
into that base controller file deep in the heart of Symfony where we can see exactly what it does. 

This simply goes out to the templating service, the same way we did, and calls method named `renderResponse`. 
`renderResponse` is just like the render function we call, except that it renders the template and puts it into
a response object for us. 

Even when you use these shortcut methods inside of the controller, behind the scenes it's not some weird core
Symfony functionality, it all comes down to using one of the services out of the container. That's awesome. 

Oh, you want to know what other services we have in the container? Well, to find that out head back to the 
terminal and use our handy, `php bin/console` and there's another command in here called `debug:container`.
Let's run that! `php bin/console debug:container`. Ah, here's our very short list of, oh I'd say a little over
200 useful objects in Symfony that you just get out of the box. 

Don't worry about memorizing these, as you keep using Symfony you'll see which ones are important to you and your
project. Just remembering that this list is here is very powerful. For example, we don't know whether or not
Symfony gives us any logging functionality. Say we wanted to log a message from our controller, we don't know
if Symfony can do that. We could google for it of course, or we could pass an argument to `debug:container` called
`log` and see if there are any services with the word log in it. And, wow, we see there are 18. Usually,
the one you're interested in is the one with the shortest name. 

In fact, there's actually a service called `logger` which we could grab out of the container and use to log stuff.
We just figured that out without any documentation, instead just using one of the tools that Symfony offers. 

We'll talk a ton more about services in the container. It's one of the most fundamentally important thing that
makes Symfony special.