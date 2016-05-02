# Intro to Services

Ok! The first half of Symfony: route-controller-response is in the books!

The second half is all about useful objects. Obviously, returning a string response
like this is not going to take us very far. Our aquanauts demand more! In real life,
we might need to render a template, query a database, or even turn objects into JSON
for an API!

Symfony comes with many, optional, useful objects to help out with stuff like this.
For example, want to send an email? Symfony has an object for that. How about log
something? There's an object for that.

These objects are commonly called services, and that's important: when you hear the
word `service`, just think "useful object".


## Service Container

To keep track of all of these services, Symfony puts them into one big associative
array called the container. Each object has a key - like `mailer` or `logger`. And
to be more honest with you - sorry, I do like to lie temporarily - the container
is actually an object. But think of it like an array: each useful object has an
associated key. If I give you the container, you can ask for the `logger` service
and it'll give you that object.

The second half of Symfony is all about finding out what objects are available and
how to use them. Heck, we'll even add our *own* service objects to the container
before too long. That's when things get really cool.

## Accessing the Container

The first useful object is the `templating` service: it renders Twig templates. To
get access to the service container, you need to extend Symfony's base controller.

***SEEALSO
Why does extending `Controller` give you access to the container? Find out:
[Injecting the Container (ContainerAwareInterface)][http://knpuniversity.com/screencast/symfony-journey/determine-the-controller#injecting-the-container-containerawareinterface] (advanced).
***

In `GenusController`, add `extends Controller` from `FrameworkBundle`. Hit tab to
autocomplete and get the `use` statement:

[[[ code('5b15e8d678') ]]]

To get the `templating` service, add `$templating = $this->container->get('templating')`:

[[[ code('91682ab135') ]]]

The container pretty much only has one method: `get`. Give it the nickname to the
service and it will return that object. It's super simple.

Quickly, open the `var` directory, right click on the `cache` directory and click
"mark this directory as excluded". Symfony caches things... that's not important
yet, but excluding this *is* important: this directory confuses autocompletion.

Now type `$this->container->get('templating')`. Well hey autocompletion!

## Rendering a Template

With the templating object we can... well... render a template! Add
`$html = $templating->render('')` followed by the name of the template. This could
be anything, but let's be logical: `genus/show.html.twig`. I'll show you where this
lives in a second:

[[[ code('e5fac212d9') ]]]

We'll also want to pass some variables into the template. Pass a `name` variable
into Twig that's set to `$genusName`.

Finally, what do we always do in Symfony controllers? We always return a Symfony's
`Response` object. Stick, that `$html` into the response object and return it:

[[[ code('4476121646') ]]]

***SEEALSO
You can actually return *anything* from a controller via the `kernel.view` event:
[The kernel.view Event][2] (advanced)
***

## Create the Template

Ok, where do templates live? Ah, it's so simple: templates live in `app/Resources/views`.
The one we're looking for will be in `app/Resources/views/genus/show.html.twig`.
The existing `index.html.twig` template was for the original homepage. Check it out
if you want to, then delete it!

Create a new `genus` directory and then a new file: `show.html.twig`. Welcome to
Twig! You'll love it. Add an `<h1>` tag with `The Genus` and then `{{ name }}` to
print the `name` variable. More on Twig in a second:

[[[ code('5e9e3ad586') ]]]

But that's it! Refresh the browser. Check out that sweet `h1` tag. 

Now back up: we just did something really cool: used our first service. We now know
that rendering a template isn't done by some deep, dark part of Symfony: it's done
by the templating object. In fact, Symfony doesn't really do *anything*: everything
is done by one of these services.


[1]: http://knpuniversity.com/screencast/symfony-journey/determine-the-controller#injecting-the-container-containerawareinterface
[2]: http://knpuniversity.com/screencast/symfony-journey/kernel.view-event
