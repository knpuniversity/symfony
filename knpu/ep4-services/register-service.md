# Register your Service in the Container

The `MarkdownTransformer` class is *not* an Autobot, nor a Decepticon, but it *is*
a service because it does work for us. It's no different from any other service,
like the `markdown.parser`, `logger` or *anything* else we see in `debug:container`...
except for one thing: it sees dead people. I mean, it does *not* live in the container.

Nope, we need to instantiate it *manually*: we can't just say something like
`$this->get('app.markdown_transformer')` and expect the container to create it for
us.

Time to change that... and I'll tell you why it's awesome once we're done.

Open up `app/config/services.yml`:

[[[ code('03cb1a7fbf') ]]]

To add a new service to the container, you basically need to *teach* the container
*how* to instantiate your object.

This file already has some example code to do this... kill it! Under the `services`
key, give your new service a nickname: how about `app.markdown_transformer`:

[[[ code('bb861ef334') ]]]

This can be anything: we'll use it later to *fetch* the service. Next, in order for the
container to be able to instantiate this, it needs to know two things: the class
name and what arguments to pass to the constructor. For the first, add `class:`
then the full `AppBundle\Service\MarkdownTransformer`:

[[[ code('38e3211b13') ]]]

For the second, add `arguments:` then make a YAML array: `[]`. These are the constructor
arguments, and it's pretty simple. If we used `[sunshine, rainbows]`, it would pass
the string `sunshine` as the first argument to `MarkdownTransformer` and `rainbow`
as the second. And that would be a very pleasant service.

In reality, `MarkdowTransformer` requires *one* argument: the `markdown.parser` service.
To tell the container to pass that, add `@markdown.parser`:

[[[ code('cc33a6998a') ]]]

That's it. The `@` is special: it says:

> Woh woh woh, don't pass the *string* `markdown.parser`, pass the *service* `markdown.parser`.

And with 4 lines of code, a *new* service has been born in the container. I'm such
a proud parent.

Go look for it:

```bash
./bin/console debug:container markdown
```

There is its! And it's so cute. Idea! Let's use it! Instead of `new MarkdownTransformer()`,
be lazier: `$transformer = $this->get('app.markdown_transformer)`:

[[[ code('b8e5ae4416') ]]]

When this line runs, the container will create that object for us behind the scenes.

## Why add a Service to the Container

Believe it or not, this was a *huge* step. When you add your service to the container,
you get two great thing. First, using the service is *so* much easier: `$this->get('app.markdown_transformer)`.
We don't need to worry about passing constructor arguments: heck it could have
*ten* constructor arguments and this simple line would stay the same.

Second: if we ask for the `app.markdown_transformer` service more than once during
a request, the container *only* creates one of them: it returns that same *one* object
each time. That's nice for performance.

Oh, and by the way: the container doesn't create the `MarkdownTransformer` object
until and *unless* somebody asks for it. That means that adding more services to
your container does *not* slow things down.

## The Dumped Container

Ok, I *have* to show you something cool. Open up the `var/cache` directory. If you
don't see it - you may have it excluded: switch to the "Project" mode in PhpStorm.

Open `var/cache/dev/appDevDebugProjectContainer.php`:

[[[ code('19d52ec5d9') ]]]

*This* is the container: it's a class that's dynamically built from our configuration.
Search for "MarkdownTransformer" and find the `getApp_MarkdownTransformerService()` method:

[[[ code('734e3d6ad0') ]]]

Ultimately, when we ask for the `app.markdown_transformer` service, *this* method
is called. And look! It runs the same PHP code that we had before in our controller:
`new MarkdownTransformer()` and then `$this->get('markdown.parser')` - since `$this`
*is* the container.

You don't need to understand how this works - but it's important to see this. The
configuration we wrote in `services.yml` may *feel* like magic, but it's not: it
causes Symfony to write plain PHP code that creates our service objects. There's
no magic: we *describe* how to instantiate the object, and Symfony writes the PHP
code to do that. This makes the container blazingly fast.
