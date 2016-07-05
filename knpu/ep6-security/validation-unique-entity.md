# Validation with the UniqueEntity Constraint

Registration is working, but it's missing validation.

Since the form is bound to the `User` class, that is where our annotation rules
should live. First, you need the `use` statement for the annotations. We added validation
earlier in `Genus`. So, you can either copy this `use` statement, grab it from the
documentation, or do what I do: cheat by saying `use`, auto-completing an annotation
I know exists - like `NotBlank`, deleting the last part, and adding the normal
`as Assert` alias:

[[[ code('395fc2df09') ]]]

We obviously want email to be `NotBlank`. We also want email to be a valid email
address. For `plainPassword`, that should also not be blank:

[[[ code('94d0552ca8') ]]]

Pretty simple.

Ok, go back, keep the form blank, and submit. Nice validation errors.

## Forcing a Unique Email

But check this out: type `weaverryan+1@gmail.com`. That email is already taken, so
I should *not* be able to do this. But since there aren't any validation rules
checking this, the request goes through and the email looks totally valid.

How can we add a validation rule to prevent that? By using a special validation constraint
made *just* for this occasion.

### The UniqueEntity Constraint

This constraint's annotation doesn't go above a specific property: it lives above
the entire class. Add `@UniqueEntity`. Notice, this lives in a different namespace
than the other annotations, so PhpStorm added its own `use` statement.

Next configure it. You can always go to the reference section of the docs, or, if
you hold command, you can click the annotation to open its class. The public properties
are always the options that you can pass to the annotation.

The options we need are `fields` - which tell it which field needs to be unique
in the database - and `message` so we can say something awesome when it happens.

So add `fields={"email"}`. This is called *fields* because you *could* make this
validation be unique across several columns. Then add
`message="It looks like you already have an account!"`:

[[[ code('a276e26fca') ]]]

Cool! Go back and hit register again. This just makes me happy!

We're good, right? Well, almost. There's one last gotcha with validation and registration.
