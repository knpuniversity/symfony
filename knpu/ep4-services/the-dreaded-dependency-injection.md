# The Dreaded Dependency Injection

The `MarkdownTransformer` will do two things: parse markdown and eventually cache
it. Let's start with the first.

Open up `GenusController` and copy the code that originally parsed the text through
markdown. Now... paste this into the parse function, return that and update the
variable to `$str`. Wow, that was easy:

[[[ code('0e8597e656') ]]]

Go back and refresh. It *explodes*!

> Attempted to call an undefined method named "get" on MarkdownTransformer

Forget about Symfony: this makes sense. The class we just created does *not* have
a `get()` function and it doesn't *extend* anything that would give this to us.

In a controller, we *do* have this function. But more importantly, we have access
to the container, either via that shortcut method or by saying `$this->container`.
From there we can fetch *any* service by calling `->get()` on it.

But that's special to the controller: as soon as you're *not* in a controller - like
`MarkdownTransformer` - you *don't* have access to the container, its services...
or *anything*.

## The Dependency Injection Flow

So here's the quadrillion bitcoin question: how can we *get* access to the container
inside `MarkdownTransformer`? But wait, we don't *really* need the *whole* container:
all we *really* need is the markdown parser object. So a better question is: how can
we get access to the *markdown parser* object inside `MarkdownTransformer`?

The answer is probably the scariest word that was ever created for such a simple
idea: dependency injection. Ah, ah, ah. I think someone invented that word *just* to
be a jerk... especially because it's *so* simple...

Here's how it goes: whenever you're inside of a class and you need access to an object
that you don't have - like the markdown parser - add a `public function __construct()`
and add the object you need as an argument:

[[[ code('54656c6ca4') ]]]

Next create a private property and in the constructor, assign that to the object:
`$this->markdownParser = $markdownParser`:

[[[ code('5d58419e7a') ]]]

Now that the markdown parser is set on the property, use it in `parse()`: get rid
of `$this->get()` and just use `$this->markdownParser`:

[[[ code('926e18e77e') ]]]

We're done! Well, done with *this* class. You see: *whoever* instantiates our `MarkdownTransformer`
will now be *forced* to pass in a markdown parser object.

Of course now we broke the code in our controller. Yep, in `GenusController` PhpStorm
is *angry*: we're missing the required `$markdownParser` argument in the
`new MarkdownTransformer()` call. That's cool - because now that we're in the controller,
we *do* have access to that object. Pass in `$this->get('markdown.parser')`:

[[[ code('65f2c7faf3') ]]]

Try it out!

It's alive! Twig is escaping the `<p>` tag - but that proves that markdown parsing
*is* happening. The process we just did is dependency injection. It basically says:
if an object needs something, you should pass it to that object. It's really programming
101. But if it still feels weird, you'll see a lot more of it.
