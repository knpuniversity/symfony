# First Page

## Code goes in src/ and app/

You may have noticed that *most* of the committed files were in `app/` and `src/`.
That's on purpose: these are the *only* two directories you need to worry about.
`src/` will hold all the PHP classes you create and `app/` will hold everything else:
mostly configuration and template files. Ignore all the other directories for now
and *just* focus on `src/` and `app/`.

## Building the First Page

Remember the functional homepage? It's coming from this `DefaultController.php` file.
Delete that! Do it! Now we have an absolutely empty project. Refresh the homepage!

> No route found for "GET /"

Perfect! That's Symfony's way of saying "Yo! There's no page here."

Now back to the main event: building a real page.

Our top secret project is called AquaNote: a research database for Aquanauts. These
cool underwater explorers log their discoveries of different sea creatures to this
nautical site. Our first page will show details about a specific genus, for example,
the octopus genus.

Creating a page in Symfony - or any modern framework - is two steps: a route and
a controller. The route is a bit of configuration that says what the URL is. The controller
is a function that builds that page.

### Namespaces

So, step 1: create a route! Actually, we're going to start with step 2: you'll see
why. Create a new class in `AppBundle/Controller` called `GenusController`. But wait!
The `namespace` box is empty. That's ok, but PhpStorm can help us out a bit more.
Hit escape and then right-click on `src` and select "mark directory as sources root".

Now re-create `GenusController`. This time it fills in the namespace for me:

[[[ code('a38a533735') ]]]

***SEEALSO
If namespaces are new to you, welcome! Take a break and watch our [PHP Namespaces Tutorial][1].
***

The most important thing is that the namespace *must* match the directory structure.
If it doesn't, Symfony won't be able to find the class. By setting the sources root,
PhpStorm is able to guess the namespace. And that saves us precious time.

### Controller and Route

Inside, add a `public function showAction()`:

[[[ code('6fb3a28a3b') ]]]

Hey, this is the controller - the function that will (eventually) build the page -
and its name isn't important. To create the route, we'll use annotations: a comment
that is parsed as configuration. Start with `/**` and add `@Route`. Be sure to let
PhpStorm autocomplete that from the `FrameworkExtraBundle` by hitting tab. This is
important: it added a `use` statement at the top of the class that we need. Finish
this by adding `"/genus"`:

[[[ code('0eb5bddd53') ]]]

Beautiful, that's the route and the URL for the page is `/genus`.

## Returning a Response

As I already said: the controller is the function right below this, and its job is
to build the page. The *only* rule for a controller is that it must return a Symfony
`Response` object.

But hold on. Let's just all remember what our *only* job is as web developers: to
understand the incoming request and send back a response, whether that's an HTML
response, a JSON response of a PDF file. Symfony is modeled around this idea.

Keep things simple: `return new Response`. The `Response` class is the one from
the `HttpFoundation` component. Hit tab to auto-complete it. This adds the `use`
statement on top that we need. For the content, how about: `'Under the Sea!'`:

[[[ code('cf4b818272') ]]]

That's it!

We've only created one file with one function, but we already have a route, a controller
and a lot of sea floor that needs discovering!

If you refresh the homepage, well... that's not going to work. Navigate instead to
the URL: `/genus`. Woh! There's your first page in Symfony, done in about 10 lines
of code. Simple enough for you?

Next, let's create a dynamic URL.


[1]: http://knpuniversity.com/screencast/php-namespaces-in-120-seconds
