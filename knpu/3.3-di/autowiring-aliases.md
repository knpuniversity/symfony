# Aliases & When Autowiring Fails

Let's talk more about what happens when autowiring goes wrong. Right now, the
`MarkdownTransformer` class has two arguments, type-hinted with `MarkdownParserInterface`
and `Cache` from Doctrine:

[[[ code('e40dbfa829') ]]]

But, these are *not* being autowired: we're explicitly specifying each argument:

[[[ code('b13ec4a4a3') ]]]

## Letting Symfony tell you about Autowiring Failures

If I were creating this service today, I actually wouldn't specify *any* configuration
at first. Nope, I'd just create the class, add the type-hints, and let Symfony
tell me if it had any problems autowiring my arguments.

To show off one of the ways autowiring can fail, I'm going to remove the first argument
and set it to an empty string:

[[[ code('bd38f2610c') ]]]

When you do this, it means that you *do* want Symfony to try to autowire it. Symfony
will try to autowire the first argument, but not the second. Actually, if this looks
ugly to you, I agree! In a few minutes, I'll show you a cleaner way of explicitly
wiring only *some* arguments.

Anyways, let's see if the `MarkdownParserInterface` type-hint can be autowired. Refresh
the page... or *any* page.

Explosion!

> Cannot autowire service `AppBundle\Service\MarkdownTransformer`: argument `$markdownParser`.

It's very clearly saying that there is a problem with *this* specific argument.

The error continues:

> ... it references interface `MarkdownParserInterface` but no such service exists.

This is because it's looking for a service with *exactly* this id. But, none was
found! So, it tries to help out:

> You should maybe alias this interface to one of these existing services.

and it lists one, two, three, four, *five* services in the container that implement
`MarkdownParserInterface`. This is autowiring the Symfony way: there's no guess
work.

## Using Aliases to add Valid Autowiring Types

Previously, we were using a service called `markdown.parser`. Find your terminal
and get some information about this service:

```terminal
php bin/console debug:container markdown.parser
```

Interesting! This is actually an alias to `markdown.parser.max`. This service comes
from `KnpMarkdownBundle`, and it ships with a few different markdown parsers. It
then creates an alias from `markdown.parser` to whatever parser we configured as
the default.

So to fix the error, we have two options. First, we could of course explicitly specify
the argument, just like we were doing before. Or, as the error suggests, we can
create an *alias*. Let's do that: alias `Knp\Bundle\MarkdownBundle\MarkdownParserInterface`
to `@markdown.parser`:

[[[ code('ca990b85d0') ]]]

We just told Symfony *exactly* what service to autowire when it sees the `MarkdownParserInterface`
type-hint. In theory, KnpMarkdownBundle would come with this alias already, and
it probably will in the future.

Try the page! It works!
