# Mastering Route config Loading

Ok, you're a configuration pro: you know where services come from and how to configure
them. Here's our question: where do routes come from? And can third party bundles
give us more routes?

The answer is, no :(. Ah, I'm kidding - they totally can. In fact, find your terminal
and run:

```bash
./bin/console debug:router
```

Surprise! There are a lot more than just the two routes that we've created. Where
are these coming from?

Answer time: when Symfony loads the route list, it only loads *one* routing file.
In the `dev` environment, it loads `routing_dev.yml`:

[[[ code('4c4f3f9472') ]]]

In *all* environments, it loads `routing.yml`:

[[[ code('0de32d05be') ]]]

Inside `routing_dev.yml`, we're importing additional routes from `WebProfilerBundle`
and the `TwigBundle`:

[[[ code('dca2c69df2') ]]]

That's why there are *extra* routes in `debug:router`. This *also* imports `routing.yml`
at the bottom to load all the main routes:

[[[ code('bf464e2c92') ]]]

You can really import *anything* you want: you're in complete control of what routes
you import from a bundle. These files are usually XML, but that doesn't make any
difference.

In the main `routing.yml`, there's yet *another* import:

[[[ code('d5b3c1a745') ]]]

We're out of control! This loads annotation routes from the controllers in our bundle.

## Creating YAML Routes

But you can also create routes right inside YAML - a lot of people actually prefer
this over annotations. The difference is *purely* preference: there's no performance
impact to either.

***TIP
In a *big* project, there is actually *some* performance impact in the `dev` environment
for using annotations.
***

Let's create a homepage route: use the key `homepage` - that's its name. Then add
`path` set to just `/`:

[[[ code('28b7633e80') ]]]

Now, we need to point this route to a controller: the function that will render it.
Doing this in `yml` is a bit more work. Add a `defaults` key and an `_controller` key
below that. Set this to `AppBundle:Main:homepage`:

[[[ code('d7c224653e') ]]]

Yes yes, this looks totally weird - this is a Symfony-specific shortcut. It means that we
will have a controller in `AppBundle` called `MainController` with a method named
`homepageAction()`.

In the `Controller` directory, create that new `MainController` class:

[[[ code('6ebb510560') ]]]

Next add `public function homepageAction()`. Make this class extend Symfony's base `Controller`
so that we can access the `render()` function. Set it to render `main/homepage.html.twig`
without passing any variables:

[[[ code('323dc38270') ]]]

Create this *real* quick in `app/Resources/views`: new file, `main/homepage.html.twig`:

[[[ code('42c03a3d7f') ]]]

Templates basically always look the same: extend the base template - `base.html.twig` -
and then override one or more of its blocks. Override block `body`: the block that
holds the main content in `base.html.twig`.

Add some content to greet the aquanauts:

[[[ code('87fe1fda46') ]]]

Done! Before trying this, head over to the terminal and run:

```bash
./bin/console debug:router
```

There it is! There are many ways to define a route, but the result is exactly the
same. Refresh the browser. Thank you `yml` for that lovely brand new route.

Woh guys. This course was a *serious* step forward. In the next parts, we're going
to start adding big features: like talking to a database, forms, security and more.
And when we do, I've got some exciting news: because of your work here, it's all going
to make sense. Let's keep going and get really productive with Symfony.
