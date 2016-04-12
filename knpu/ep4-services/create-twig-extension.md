# Adding a Twig Extension + DI Tags

Because the `$funFact` needs to be parsed through markdown, we have to pass it as
an independent variable into the template. You know what would be *way* cooler? If
we could just say `genus.funFact|markdown`. Ok, actually we *can* do this already:
the `KnpMarkdownBundle` comes with a filter called `markdown`:

[[[ code('72dc5bde55') ]]]

Remove the `app.php` from the URL and refresh. Voilà! This parses the string
to markdown. Well, it doesn't look like much - but if you view the HTML,
there's a `p` tag from the process.

Let's make this a little more obvious while we're working. Open up the `Genus` entity
and find `getFunFact()`. Temporarily hack in some bold markdown code:

[[[ code('2c991dd210') ]]]

Ok, try it again.

Nice! The bold **TEST** tells us that the `markdown` filter from `KnpMarkdownBundle`
is working.

Ready for me to complicate things? I always do. The `markdown` filter uses the
`markdown.parser` service from `KnpMarkdownBundle` - it does *not* use our `app.markdown_transformer`.
And this means that it's *not* using our caching system. Instead, let's create
our *own* Twig filter.

## Creating a Twig Extension

To do that, you need a Twig "extension" - that's basically Twig's plugin system.
Create a new directory called `Twig` - and nope, that name is *not* important. Inside,
create a new php class - `MarkdownExtension`:

[[[ code('d9e75a791f') ]]]

Remember: Twig is its own, independent library. If you read Twig's documentation about
creating a Twig extension, it will tell you to create a class, make it extend
`\Twig_Extension` and then fill in some methods.

Use the "Code"->"Generate" menu - or `cmd`+`n` - and select "Implement Methods".
The *one* method you *must* have is called `getName()`. It's also the most boring:
just make it return any unique string - like `app_markdown`:

[[[ code('496ebd40a7') ]]]

To add a new filter, go back to the "Code"->"Generate" menu and select "Override Methods".
Choose `getFilters()`:

[[[ code('54864f3d3c') ]]]

Here, you'll return an array of new filters: each is described by a new `\Twig_SimpleFilter`
object. The first argument will be the filter name - how about `markdownify` - that
sounds fun. Then, point to a function in *this* class that should be called when that filter
is used: `parseMarkdown`:

[[[ code('635110223e') ]]]

Create the new `public function parseMarkdown()` with a `$str` argument. For now,
just `strtoupper()` that guy to start:

[[[ code('ee640e7c99') ]]]

Cool? Update the Twig template to use this:

[[[ code('013f7a76d4') ]]]

Our Twig extension is perfect... but it will *not* work yet. Refresh. Huge error:

> Unknown `markdownify` filter.

Twig doesn't automatically find and load our extension. Somehow, we need to say:

> Hey Symfony? How's it going? Oh, I'm good. Listen, when you load the
  twig service, can you add my `MarkdownExtension` to it?

How are we going to do this? With *tags*.
