# Autowiring Madness

Ooh, bonus feature! In `services.yml`, remove `arguments` and instead just say
`autowire: true`:

[[[ code('65334b7f81') ]]]

Refresh again. It still works! But how? We didn't tell Symfony what arguments to pass
to our constructor? What madness is this!? With `autowire: true`, Symfony reads the
*type-hints* for each constructor argument:

[[[ code('489a2a0cfe') ]]]

And tries to automatically find the correct service to pass to you. In this case,
it saw the `MarkdownTransformer` type-hint and knew to use the `app.markdown_transformer`
service: since that is an instance of this class. You can also type-hint interfaces.

This doesn't *always* work, but Symfony will give you a big clear exception if it
can't figure out what to do. But when it *does* work, it's a great time saver.

## Auto-Escaping a Twig Filter

The HTML is *still* being escaped - I don't want to finish before we fix that! We
*could* add the `|raw` filter... but let's do something cooler. Add a third argument
to `Twig_SimpleFilter`: an options array. Add `is_safe` set to an array containing `html`:

[[[ code('9e2bfbd6ed') ]]]

This means it's *always* safe to output contents of this filter in HTML.
Refresh one last time. Beautiful.

## Where now!?

Oh my gosh guys! I think you just leveled up: Symfony offense increased by five points.
Besides the fact that a *lot* more things will start making sense in Symfony, you
also know everything you need to start organizing your code into service classes - that
whole *service-oriented architecture* thing I was talking about earlier. This will
lead you to *wonderful* applications.

There's really nothing that we can't do now in Symfony. In the next courses, we'll
use all this to master new tools like forms and security. Seeya next time!
