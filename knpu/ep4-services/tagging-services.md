# Tagging Services (and having Fun!)

We need to somehow tell Twig about our fun new Twig extension. To do that, first,
register it as a service. The name doesn't matter, so how about `app.markdown_extension`.
Set the class, but skip `arguments`: we don't have any yet, so this is optional:

[[[ code('f6b8b0b57c') ]]]

Now, this service is a bit different: it's *not* something that we intend to use
directly in our controller, like `app.markdown_transformer`. Instead, we simply
want Twig to *know* about our service. We somehow need to raise our hand and say:

> Oh, oh oh! This service is special - this service is a *Twig Extension*!

We do that by adding a *tag*. The syntax is weird, so stay with me: Add `tags:`,
then under that a dash and a set of curly-braces. Inside, set `name` to `twig.extension`:

[[[ code('9cbc04ae04') ]]]

And that's it.

Real quick - make sure it works. Refresh! Boom! We see a pretty awesome-looking
upper-case string.

## What are these Tags???

Tags are *the* way to hook your services into different parts of the core system.
When Symfony creates the `twig` service, it looks for *all* services in the container
that are *tagged* with `twig.extension`. It then configures these as extensions on
`twig`.

Google for "Symfony dependency injection tags": there's an awesome reference section
on Symfony.com called [The Dependency Injection Tags][1]. It lists *every* tag that
can be used to hook into core Symfony. And if you're tagging a service, well, you're
probably doing something really cool.

For example, if you want to register an event listener and actually hook into Symfony's
boot process, you create a service and then tag it with `kernel.event_listener`.
You won't memorize all of these: you just need to understand their purpose. Someday,
you'll read some docs or watch a tutorial here that will tell you to *tag* a service.
I want you to understand what that tag is actually doing.

## Finish the Extension

Let's finish our extension: we need to parse this through markdown. We find ourselves
in a familiar position: we're inside a service and need access to some *other* service:
`MarkdownTransformer`. Dependency injection!

Add `public function __construct()` with a `MarkdownTransformer` argument. I'll hold
`option`+`enter` and select "Initialize fields" as a shortcut. Again, this just added
the property for me and assigned it in `__construct()`:

[[[ code('6f606645da') ]]]

***SEEALSO
Watch our [PhpStorm Course][2] to learn about these great shortcuts.
***

In `parseMarkdown()`, return `$this->markdownTransformer->parse()` and pass it `$str`:

[[[ code('e46cd4a3e9') ]]]

The last step is to update our service in `services.yml`. Add `arguments: ['@app.markdown_transformer']`:

[[[ code('f735cc4bee') ]]]

Refresh! And it's working. Now, let me show you a shortcut.


[1]: http://symfony.com/doc/current/reference/dic_tags.html
[2]: https://knpuniversity.com/screencast/phpstorm
