# Changing Validation Messages

Check out the web debug toolbar: it's highlighted with the number of validation errors,
which is pretty cool. It's even cooler because we can see where those are coming
from.

The default message for the `NotBlank` constraint is obviously

> This value should not be blank

We can easily change this by passing a `message` option to the annotation. But wait
a second: we're going to use `NotBlank` a lot. Is there a way to customize the default
message across the whole system?

Yea! All of these strings are passed through Symfony's translator. And we can
take advantage of that to customize this message, even in English.

## Enabling the Translator

First, in case you don't already have it enabled, open up `app/config/config.yml`.
Activate the `translator` service by uncommenting out the `translator` key under
`framework`:

[[[ code('0b3292c5a7') ]]]

Refresh this page and watch the web debug toolbar. Suddenly, there's an extra icon
that's coming from the translator. It's reporting that there are ten missing messages.
In other words, we are apparently already sending ten messages through the translator
that are missing translation strings.

This is because every form field and all validation errors are automatically sent
through the translator. Nothing looks weird, because those strings are already English,
so it's not really a problem that they aren't translated.

## Changing Validation Messages

But, if you want to customize this message, copy it. And, notice, the domain is
`validators`: that's basically a translation "category", and it's important for
what we do next.

We don't have any translation files yet, so create a new directory called `translations`
in `app/Resources`. Inside, add a new file: `validators.en.yml`. This is `validators`
because the message is being translated in that domain.

Inside, paste the string and set it to "Hi! Please enter something for this field.":

[[[ code('fd6c050434') ]]]

And that's it! Go back and refresh! Oh no, it didn't work! Well, I kind of expected
that. Find your terminal, open a new tab, and run:

```bahs
./bin/console cache:clear
```

You almost *never* need to worry about clearing your cache while developing but
*very* occasionally, you'll find a quirk in Symfony that needs this. Sometimes, when
you add a new translation file, this happens.

Let's refresh again. There it is!

So yay validation! There's one more constraint I want you to see: `Callback`. This
is your Swiss army knife: it allows you to write whatever custom validation logic
you want inside a method. There, you can create different validation errors and map
them to any field.
