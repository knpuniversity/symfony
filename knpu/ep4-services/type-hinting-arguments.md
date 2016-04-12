# Being Awesome with Type-Hints

[[[ code('fdfdf8a743') ]]]

What type of object is this `$markdownParser` argument? Oh, you can't tell? Well,
neither can I. With no type-hint, this could be anything! A `MarkdownParser` object,
a string, an octopus!

We need to add a *typehint* to make our code clearer... and avoid weird errors
in case we accidentally pass in something else... like an octopus.

Run:

```bash
./bin/console debug:container markdown
```

And select `markdown.parser` - that's the service we're passing into `MarkdownTransformer`.
Ok, it's an instance of `Knp\Bundle\MarkdownBundle\Parser\Preset\Max`. We can use that
as the type-hint.

But hold on - I'm going to complicate things... but then we'll all learn something
cool and celebrate. Press `shift`+`shift`, type "max" and open that class:

[[[ code('ead2bdc820') ]]]

Ah, this extends `MarkdownParser` and *that* does all the work:

[[[ code('6fc227888a') ]]]

And *this* implements a `MarkdownParserInterface`. We could type-hint with `Max`,
`MarkdownParser` *or* `MarkdownParserInterface`: they will all work. BUT, when possible,
it's best to find a base class - or better - and *interface* that has the methods
on it you need, and use that.

Type-hint the argument with `MarkdownParserInterface`:

[[[ code('b6c252c7a8') ]]]

Why is this the best option? Two small reasons. First, in theory, we could swap out
the `$markdownParser` for a different object, as long as it implemented this interface.
Second, it's *really* clear *what* methods we can call on the `$markdownParser` property:
only those on that interface.

But hold on a second, PhpStorm is angry about calling `transform()` on `$this->markdownParser`:

> Method "transform" not found in class `MarkdownParserInterface`

Weird! Open that interface. Oh, it has only one method: `transformMarkdown()`:

[[[ code('a83e4caf46') ]]]

Hold on: to be clear: everything will work right now. Refresh to prove it.

The weirdness is just that we are *forcing* an object that implements `MarkdownParserInterface`
to be passed in... but then we're calling a method that's *not* on that interface.

Change our call to `transformMarkdown()`:

[[[ code('daea309934') ]]]

Inside `MarkdownParser`, you can see that `transformMarkdown()` and `transform()`
do the same thing anyways:

[[[ code('a8582d7613') ]]]

This didn't change any behavior: it just made our code more portable: our class will work
with *any* object that implements `MarkdownParserInterface`.

And if this doesn't *completely* make sense, do not worry. Just focus on this takeaway:
when you need an object from inside a class, use dependency injection. And when you
add the `__construct()` argument, type-hint it with either the class you see in `debug:container`
*or* an interface if you can find one. Both totally work.
