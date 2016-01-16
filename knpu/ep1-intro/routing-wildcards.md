# Routing Wildcards

This page has a boring, hardcoded URL. What our aquanauts deserve is a dynamic route
that can handle the URL for any genus - like `/genus/octopus` or  `/genus/hippocampus`
which is the genus that sea horses belong to. Oh man, sea horses are cute. 

How? Change the URL to `/genus/{genusName}`:

[[[ code('47d7097331') ]]]

This `genusName` part could be named anything: the important part is that it is surrounded
by curly braces. As soon as you do this, you are allowed to have a `$genusName` argument
to your controller. When we go to `/genus/octopus` this variable will be set to octopus.
That's pretty awesome.

The important thing is that the routing wildcard matches the variable name.

To test this is, change the message in the response to `'The genus: '.$genusName`:

[[[ code('086c4c19c1') ]]]

***TIP
Be careful when rendering direct user input (like we are here)! It introduces a security
issue called XSS - [read more about XSS here.](https://www.owasp.org/index.php/Cross-site_Scripting_%28XSS%29)
***

Head back to the browser and refresh. Ah! A 404 error. That's because the URL is
no longer `/genus`, it's now `/genus/something`: we have to have something on the
other side of the URL. Throw octopus on the end of that (`/genus/octopus`). There's
the new message. And of course, we could change this to whatever we want. 

So what would happen if the wildcard and the variable name *didn't* match? Um I don't
know: let's try it: change the wildcard name and refresh!

[[[ code('9c659c702d') ]]]

OMG: that's a sweet error:

> The `Controller::showAction()` requires that you provide a value for the `$genusName` argument.

What Symfony is trying to tell you is:

> Hey fellow ocean explorer, I'm trying to call your `showAction()`, but I can't figure out
  what value to pass to `genusName` because I don't see a `{genusName}` wildcard in the
  route. I'm shore you can help me.

As long as those always match, you'll be great.

## Listing all Routes

When you load this page, Symfony loops over *all* the routes in your system and asks
them one-by-one: do you match `/genus/octopus`? Do *you* match `/genus/octopus`?
As soon as it finds *one* route that matches that URL, it stops and calls that controller.

So far, we only have one route, but eventually we'll have a lot, organized across
many files. It would be *swimming* if we could get a big list of every route. Ha!
We can!

Symfony comes with an awesome debugging tool called the console. To use it, go to
the terminal and run

```bash
php bin/console
```

This returns a big list of commands that you can run. Most of these help you with
debugging, some generate code and others do things like clear caches. We're interested
in `debug:router`. Let's run that:

```bash
php bin/console debug:router
```

Nice! This prints out *every* route. You can see our route at the bottom:
`/genus/{genusName}`. But there are other routes, I wonder where those are coming
from? Those routes give you some debugging tools - like the little web debug toolbar
we saw earlier. I'll show you where these are coming from later.

When we add more routes later, they'll show up here too.

Ok, fun fact! A baby seahorse is called a "fry".

How about a relevant fun fact? You now know 50% of Symfony. Was that really hard?
The routing-controller-response flow is the first half of Symfony, and we've got
it crossed off. 

Now, let's dive into the second half. 
