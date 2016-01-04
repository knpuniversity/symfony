# Listing and Using Services

Rendering a template is pretty common, so there's a shortcut when you're in a controller.
Replace all of this code with a simple `return $this->render`:

[[[ code('6ad09ec8e1') ]]]

That's it. Make sure this works by refreshing.

So what does this magic-looking `render()` function actually do? Let's find out!
Hold command or control (depending on your OS) and click `render()` to be taken straight
into the base `Controller` class where this function lives: deep in the heart of Symfony:

[[[ code('bfdb702039') ]]]

Ah, hah! In reality, this function simply goes out to the `templating` service - just
like we did - and calls a method named `renderResponse()`. This method is like the `render()`
function we called, except that it wraps the HTML in a Response object for convenience.

Here's the point: the base `Controller` class has a lot of shortcut methods that
you'll use. But behind the scenes, these don't activate some weird, core functionality
in Symfony. Instead, everything is done by one of the services in the container.
Symfony doesn't really *do* anything: all the work is done by different services.
That's awesome. 

## What Services are there?

Oh, you want to know what *other* services are hiding in the container? Me too!
To find that out, head back to the terminal and use the handy console:

```bash
php bin/console
```

Check out that `debug:container` command - run that!

```bash
php bin/console debug:container
```

You should see a short list of service. Ah, I mean, you should see over *200* useful
objects in Symfony that you get access to out of the box. But don't worry about memorizing
these: as you use Symfony, you'll find out which ones are important to you and your
project by reading the docs on how to accomplish different things.

But sometimes, you can just guess! For example, does Symfony have a service for logging?
Um, maybe?! We could Google that, or we could pass an argument to this command to
search for services matching "log":

```bash
php bin/console debug:container log
```

Wow, there are 18! Here's a secret: the service you usually want is the one with
the shortest name. In this case: `logger`. So if you wanted to log something, just
grab this out of the container and use it. This command also shows you what *class*
you'll get back, which you can use to find the methods on it.

We just figured this out without *any* documentation.

There's a lot more to say later about services and the container. In fact, it's one
of the most fundamentally important things that makes Symfony so special... and so fast.
