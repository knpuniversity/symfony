# Adding a Twig Extension + DI Tags

Because the `$funFact` needs to be parsed through markdown, we have to pass it as
an independent variable into the template. you know what would be *way* cooler? If
we could just say `genus.funFact|markdown`. Ok, actually we *can* say this already:
the KnpMarkdownBundle comes with a filter called `markdown`. Remove the `app.php`
from the URL and refresh. Voilà! This parses the string to markdown. Well, it doesn't
look like much - but if you view the HTML, there's a `p` tag from the process.

Let's make this a little more obvious while we're working. Open up the `Genus` entity
and find `getFunFact()`. Temporarily hack in some bold markdown code.

Ok, try it again.

Nice! The bold **TEST** tells us that the `markdown` filter from KnpMarkdownBundle
is working.

Ready for me to complicate things? I always do. The `markdown` filter uses the
`markdown.parser` service from `KnpMarkdownBundle` - it does *not* use our `app.markdown_transformer`
service. This means that it's not using our caching system. Instead, let's create
our *own* new Twig filter.

## Creating a Twig Extension

To do that, you need a new Twig "extension" - that's basically Twig's plugin system.
Create a new directory called `Twig` - and nope, that name is *not* important. Inside,
create a new php class - `MarkdownExtension`. 

Remember: Twig is its own, independent library. If you read Twig's documentation about
creating a Twig extension, it will tell you to create a class, make it extend
`\Twig_Extension` and then fill in some methods.

Use the Code->Generate menu - or cmd+n - and select "Implement Methods". The *one*
method you *must* have is called `getName()`. It's not important at all: just make
it return something unique: like `app.markdown`.

To add a new filter, go back to the Code->Generate menu and select "Override Methods".
Choose `getFilters`. Here, you'll return an array of new filters: each is described
by a new `\Twig_SimpleFilter` object. The first method will be the filter name - how
about `markdownify` - that sounds trendy. The point to a function in *this* class
that should be called when that filter is used: `parseMarkdown`.

Create the new `public function parseMarkdown()` with a `$str` argument. For now,
just `strtoupper` that guy to start. Cool? Update the Twig template to use this.

Our Twig extension is perfect... but it will *not* work yet. Refresh. Huge error:

> Unknown filter markdownify

Twig doesn't automatically find and load our extension. Somehow, we need to say:

> Hey Symfony? How's it going? Oh, I'm good. Listen, when you load the
> twig service, can you add my MarkdownExtension to it?

## Dependency Injection Tags

How? First, register it as a service. The name doesn't matter, so how about
`app.markdown_extension`. Setup that class, but skip `arguments`: we don't have
any arguments yet, so we don't need this.

This service is a bit different: it's *not* something that we intend to use from
our controller, like `app.markdown_transformer`. Instead, we 

Now this service is not something that we
are gonna use directly in our controller like markdown transformer. Instead, we
want Twig to know to use our service. So we need to somehow raise our hand and
say, "Oh oh oh oh! This service is special. This service is a Twig extension."
To do that, you're going to add a tag. The syntax looks a little weird but add
tags go out four spaces hit dash, curly brace, and then name Twig dot extension
and that's it. So real quick, let's make sure that works. Go back, refresh.
There is the uppercase string. Tags are the way that you hook your services
into some existing core part of the system. Quite literally, when Symfony
starts the Twig service, it looks for all of the services in the container that
are tagged with Twig dot extension. And it makes sure to tell the Twig service
about those.

In fact, if you Google for "Symfony dependency injection tags," there's an
awesome reference section on Symfony.com called "the dependency injection
tags." And it lists all of the dependency injection tags that are in the core
Symfony. And if you're using a dependency injection tag, then you're doing
something really cool. So, for example, if you wanna register an event listener
on Symfony and actually hook in the boot process you create a service and then
tag it with kernel dot event listener. So you don't have to have these
memorized or even know what they are. But eventually you're gonna try to do
something in Symfony and you're going to – it's going to tell you to tag it and
I want you to understand what that tag is actually doing.

Finally, instead of actually doing STR to upper we want to – we actually wanna
transform this into markdown. So once again, we are in a service and we need
access to an outside object. We need access to our markdown transformer object.
How do we do that? Dependency injection. So when I public function underscore
underscore and construct type hand it with markdown transformer and then I will
hold option enter to go to initialize fields and that will add the property for
me. Again, you can just do that by hand if you don't know that shortcut or
watch our peach tree storm tutorial. Then down here in parse markdown, let's
return this arrow markdown transformer arrow parse. STR and that's it – inside
this class. Then we just need to go to services dot YML and update it so
Symfony knows to pass it arguments. So arguments colon and then at app dot
markdown transformer and that should be it.

Go back. Refresh. And it's working. You can tell because it's actually taking
longer. Our service has that one second wait. Now one thing you can do which is
really cool is instead of having arguments here, you could do another key
called "autowire." If you do that and refresh, it still works. It's total
awesome magic. When you use autowiring, Symfony looks at your class and looks
at each argument constructor and tries to figure out what service to pass to
you based on the type hint. So in this case, it looked at our markdown
transformer type hint and it figured out that there's only one service in the
container that has that class and it automatically passed that as the
constructor argument.

This doesn't always work because sometimes there are certain classes with
multiple instances, but this is a really cool thing to use when it works. And
it can save you a lot of time. Now last detail is – you see this is still
escaped. We could fix that really easily by doing pipe E or pipe raw. But
instead, let's actually update our filter so that that's – always comes out on
escape, because we know if you're using the markdownify filter, your content
should not be escaped. To do that, a third argument Twig simple filter which is
an array type is underscore safe and that in an array save HTML. This means
that, "Hey when this filter's being used in the HTML context, hey, it's safe so
don't escape it." And that's it.

All right, guys. It didn't take very long but you now know how to add your own
services to the container. You can now create a service-oriented architecture
where instead of putting lots of code in your control; you start to isolate it
into services, register those services with Symfony's container, and create
your own set of tools. Eventually you'll have many services inside of here,
many tools that you built that you can reuse across your application.
Ingraining services is really quite simple. You're ultimately just teaching
Symfony's container how to instantiate your objects. And you do that with the
class key and the arguments key. And the at symbol is the special thing that
tells Symfony that this markdown dot parser is a service. Because you can also
pass just plain configuration to your services by just having a normal argument
without the at symbol or even a parameter.

You'll need – and then the only extra thing with service is when you create a
service – not so that you can use it yourself, but so your service can be
hooked into some core part of the system. And those are always done with tags.
So now, just understand when you see a tag you say, "It means this service is
being hooked into some core part of Symfony." Oh, and don't forget about
autowiring. Really, really cool shortcut. Okay, that was short but that's huge.
There's really nothing that we can't do in Symfony, so let's start learning
other important concepts in the next tutorials.
