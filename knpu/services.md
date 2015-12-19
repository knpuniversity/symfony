# Services

Alright! First half of Symfony: route, controller, response - we've got it! Now what's the second half?
Well, that's all about useful objects. Obviously, just returning a string response like this is not going
to take us very far. Our aquanaut deserve more! Sometimes we'll want to render templates, maybe we'll
need to talk to the database, or maybe we'll create objects and have something that turns those into JSON
for our API. 

You can use these optional useful objects, if you want to, from within your controller. For example,
if you want to send an email, Symfony has an object for that. Our goal is simply to understand what objects
are available in Symfony and how we can use them. These objects are commonly called services. So when you
hear the word `service` just thnk that's a  `useful object`. To keep track of all of these services, Symfony
puts them all into one big array called the container. Well, it's not actually an array, it's an object. But
it looks and acts like an array. So, if I give you the container, you get access to any of the useful objects
that you want out of it like the mailer or logger object. 

As soon as you need access to one of the useful objects in Symfony, you're going to extend Symfony's base controller.
In the `GenusController` add `extends Controller` from the FrameworkBundle. And I'll hit tab on that to get autocomplete
and the use statment. 

What we want to do first is render a template. In this project we'll render some templates in HTML and we'll
build an API on the side so that you'll get both aspects. 

If you want to render a template, the useful object you need is called templating. Here, add `$templating = ` 
and then get that off of the container. As soon as we extend Symfony's base controller we can type 
`$this->container->get('')` and then we use the nickname of the service object that we want. In this case
it's called `templating`. 

Let's open the `var` directory, right click on the `cache` directory, we'll get into more details about this
later, but mark this directory as excluded. We're doing this because a few files in here are making our
autocompleting act foolish. 

So now, when we type `$this->container->get('templating')` we get some real autocomplete. With the templating
object we can, well, render a template! Add `$html = $templating->render('')` and then the name of the template.
In this case I'm going to follow the name of my controller, `genus/show.html.twig`. I"ll show you in a second
where that lives. From here we can pass variables into that. Let's pass a `name` variable which will be set to
our `$genusName`. With this `name` will be the variable inside of the twig template. 

Finally, what do we always do in Symfony controllers? Well, we always return a response object. Stick, that
`$html` into the response object. How did I know to call render in the templating engine? Well, that's your job.
Your job is to find out what objects you have available, and then what methods you can call on those objects. 
I'll show you a few ways to do that, or you can just read the documentation. 

Let's create this template! It's very simple in Symfony, all templates live in `App/Resources/views`. The page
we're looking for will be in `App/Resources/views/genus/show.html.twig`. This `index.html.twig` template here
is from the original homepage, you can look at that if you want, but when you're done just delete it. 

Create a new `genus` directory, and then a new file called `show.html.twig`. Symfony obviously uses twig for its
rendering, so let's throw a little twig code in here with an h1 of The Genus and the name variable, to print it
we'll write that with `{{ name }}`. Twig is really fun and easy, and we'll go into greater detail with it in a second.
That's it, let's give this page a try! Refresh and yes! Check out that sweet h1 tag. 

This is really cool, the first useful object we've played with is the templating object. If we ever want to render
a template from anywhere, it's not some magic function inside of Symfony. There's just an object called templating
and as long as you have the templating object you can render a template. Even above that you have the container
that holds all the useful objects. You now know that if I give you the container, you can fetch off the templating
service and render a template from wherever you are. 

Since this is such a common thing to do there is a shortcut for it inside of the controller. Instead of all this
long stuff we can instead write `return $this->render`, remove the return at the bottom and that's it. Let's make
sure that works. Head back to the browser and refresh.

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
