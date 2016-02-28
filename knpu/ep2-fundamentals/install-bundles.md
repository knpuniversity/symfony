# Bundles

Woh! You're back! Hey friend! Ok, I'm glad you're here: this is a *big*
episode for us. We're about to learn some of the most critical concepts that will
*really* help you to master Symfony... and of course, impress all your friends.

Like always, you should totally code along with me. Download the code from the course
page and move into the `start` directory. I already have that ready, so let's start
the built-in web server. Open a new terminal tab and run the
`./bin/console server:run` command:

```bash
./bin/console server:run
```

Ding! Now dust off your browser and try to load `http://localhost:8000/genus/octopus`,
which is the page we made in the last tutorial. Awesome!

## The 2 Parts of Symfony

After [episode 1][1], we already know a lot. We know that Symfony is pretty simple: create
a **route**, create a **controller** function, make sure that function returns a `Response`
object and then go eat a sandwich. So, Route -> Controller -> Response -> Sandwich.
And suddenly, you know half of Symfony... *and*  you're not hungry anymore.

The second half of Symfony is a all about the huge number of optional useful objects
that can help you get your work done. For example, there's a *logger* object, a *mailer*
object, and a *templating* object that... uh... renders templates. In fact, the
`$this->render()` shortcut we've been using in the controller is just a shortcut
to go out to the `templating` object and call a method on it:

[[[ code('b6b40f1546') ]]]

All of these useful objects - or services - are put into one big *beautiful* object
called the container. If I give you the container, then you're *incredibly* dangerous:
you can fetch any object you want and do anything.

How do we know what handy services are inside of the container? Just use the `debug:container`
command:

```bash
./bin/console debug:container
```

You can even search for services - like `log`:

```bash
./bin/console debug:container log
```

## But Where do Services Come From?

But where do these come from? What magical, mystical creatures are providing us with
all of these free tools? The answer is: the bundle fairies.

In your IDE, open up `app/AppKernel.php`:

[[[ code('f3a32ac7a6') ]]]

The kernel is the *heart* of your Symfony application... but it really doesn't do much.
Its main job is to initialize all the *bundles* we need. A bundle is basically just
a Symfony plugin, and *its* main job is to add *services* to your container.

Remember that giant list from a minute ago? Yep, *every single* service in that list
is provided to us from one of these bundles.

But at its simplest: a bundle is basically just a directory full of PHP classes,
configuration and other goodies. And hey, we have our own: `AppBundle`:

[[[ code('94bc25121a') ]]]

## Install a Bundle: Get more Services

I have challenge for us: I want to render some of this octopus information through
a markdown parser. So the question is, does Symfony already have a markdown parsing
service?

I don't know! Let's find out via `debug:container`:

```bash
./bin/console debug:container markdown
```

Hmm, nothing: there's no built-in tool to help us.

Symfony community to the rescue! If you're missing a tool, there *might* be a Symfony
bundle that provides it. In this case, there is: it's called `KnpMarkdownBundle`.

Copy its `composer require` line. You don't need to include the version constraint:
Composer will figure that out for us. Run that in your terminal:

```bash
composer require knplabs/knp-markdown-bundle
```

Let's keep busy while that's working. To enable the bundle, grab the `new` statement
from the docs and paste that into `AppKernel`: the order of these doesn't matter:

[[[ code('6da43114e1') ]]]

That's it! Just wait for Composer to finish its job... and maybe send a nice
tweet to Jordi - he's the creator and maintainer of Composer. There we go!

Ok, before we do *anything* else, let's run an experiment. Try running
`debug:container` again with a search for `markdown`.

```bash
./bin/console debug:container markdown
```

Boom! Suddenly, there are *two* services matching. These are coming from the bundle
we just installed. The one we're really interested in is `markdown.parser`.


[1]: http://knpuniversity.com/screencast/symfony
