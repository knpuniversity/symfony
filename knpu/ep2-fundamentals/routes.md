# Routes

Now we know where services come from and how you configure them. So, where do
routes come from? Can external third party bundles give us more routes in our system?

The answer is, absolutely! In fact, in the terminal run `./bin/console debug:router`
and you might see a surprise. There are a lot more than just the two routes that we've
created. There are about 10 other routes, how is this possible? 

In the `dev` environment, this `routing_dev.yml` file is loaded and in all other
environments this `routing.yml` file is loaded. The `routing_dev.yml` imports routes
from the `WebProfilerBundle` and the `TwigBundle`, that's what gives us these routes
in our debug router. 

Of course we can import routes, external bundles can bring routes into your system 
but the cool thing is it doesn't happen magically or automatically. You get to choose
which routing files you want to load. Notice that these are xml files, which is
a different way of configuring routes, so far we've used `annotations` and `yml` is
another option.

Ultimately it's these routes that give us the web debug toolbar which loads via
ajax so if you click any of the links on it, there it is `/_profile` which is
using the routes that come from this second import here. 

In our main `routing.yml` file which loaded in all environments even we're doing the
same thing! We're loading routes from our bundle, they're not `yml` or `xml` routes
they are `annotation` routes loading from our controller files.

The routing files are meant to import routes from other places, but, if you want to
you can just define a routing file for a route right here. Instead of using 
`annotations` let's create a new route in `yml` for the `homepage`. The path is
simply going to be `/`. Now, we need to point our route to the controller, the function
that will render it. When we do this in `yml` it's a little bit more work, we need
a `defaults` key, an `_controller` key, and then we can use something like this,
`AppBundle:Main:homepage` which should look a little weird with those colons. These
mean that we will have a controller in `AppBundle` called `MainController`. 

In the controller directory, create a new class named, `MainController`. And
then because it was `homepage` we will have a `public function homepageAction()`.
Have this class extend Symfony's base controller which gives us access to the
`render ()` function. We'll render `'main/homepage.html.twig'` without passing
any variables. Let's create this real quick in `app/resources/views`, new file, 
`main/homepage.html.twig`. 

Remember, templates basically always look the same. Extend the base template, 
`base.html.twig`, which sits right here in the same directory. And override 
one or more of its blocks. Here override `block body` because that is the block that
holds the main content of our base template. 

In here put an `h1` with class `page-header text-center` with "Welcome Aquanauts!"

Before trying that in the browser, head over to the terminal and run `debug:router`
to check that the new route is now in our list, and hey there it is! This is a 
different way to configure routes but ultimately the result is exactly the same.

Now let's try out that browser refresh. Thank you `yml` for that lovely brand new route. 
