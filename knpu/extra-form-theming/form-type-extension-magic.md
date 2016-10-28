# Form Type Extension Magic

The only way to make an option valid for a field is to, well, hack the core class
and add it! For example, since `funFact` is a `TextType`, I *could* - if I were feeling
crazy - open `TextType`, scroll down, and hack that `help` option into `configureOptions()`:

[[[ code('d99bce7e8b') ]]]

With a few other hacks, we could have this feature working!

## Form Plugins: Type Extensions

Obviously, this is *not* the right path to take, and that's ok, but there is
*another* way to add an option to a field. It's called a form *type extension*, and
it's basic a plugin to the Symfony form field system. By leveraging a form type extension,
you can modify *any* field in the system. You could, I don't know, add a new attribute
to literally every single field on your entire site.

Let's find out how.

## Creating a Form Type Extension

In your `Form` directory, create a new directory called `TypeExtension` and then
a new class called `HelpFormExtension`:

[[[ code('b5ceaf0cc7') ]]]

The goal of this class will be to to allow for a `help` option to be passed to any
field, *and* to turn that `help` option into a `help` variable.

First, all form type extensions should extend `AbstractTypeExtension`:

[[[ code('a0e7069e09') ]]]

Next, use the "Code"->"Generate" menu, or `Command`+`N` on a Mac, and click "Implement Methods".
This abstract class requires us to have one method: `getExtendedType()`:

[[[ code('27d337c437') ]]]

You see, when you create a form type extension, you could make it modify *every*
field in your entire system, *or* just one type, like the `FileType`. To modify
*every* field, return `FormType::class`:

[[[ code('99b1939f20') ]]]

Because remember, `FormType` is the parent for all fields.

***TIP
Technically, `FormType` is the parent type for *all* fields, except for buttons.
But I don't like adding buttons to my form anyways!
***

## Overriding Field Behavior

Here's the cool thing about these classes: they have all the same functions as a
normal form class, like `buildForm()` or `configureOptions()`. The difference is
that whatever modifications we make to this class will literally be applied to *every*
field in the system.

For example, go back to the "Code"->"Generate" menu, click "Override Methods", then
select `buildView()`:

[[[ code('ae778c33a8') ]]]

When we're done setting things up, whenever *any* field is transformed into a `FormView`
object, this method will be called and *we* will be able to add variables to anything!

Try it: add `$view` - which represents whatever one field is being setup -
`$view->vars['help']` set to `TURTLES`!

[[[ code('b165101fd4') ]]]

That's a ridiculous, and yet, fully-functional type extension.

## Registering a Type Extension

To tell Symfony about this, you guys can probably guess, we need to register this
as a service. In `app/config/services.yml`, add a new service: call it
`app.form.help_form_extension`. Set its class to `HelpFormExtension` and then I'll
set `autowire` to true... even though the class doesn't have any constructor arguments,
at least not yet:

[[[ code('4b8bacae1e') ]]]

Then, to actually tell Symfony: "Hey! This is a form type extension!", add a tag,
set to `form.type_extension`. Also give this an `extended_type` option. This needs
to match whatever you're returning from `getExtendedType()`. `FormType::class`
returns the long string in the `use` statement, so copy that, and paste it into your
service:

[[[ code('b3460d4779') ]]]

That's it team! Temporarily remove the `help` option from `GenusFormType`, ya know,
so the page doesn't explode. Then, refresh! OMG, everyone is screaming about
TURTLES! Well, everyone except for the `isPublished` field, because we're overriding
that `help` variable at the last possible second: from inside the template.

## Using the Option to Fuel the help Variable

Finally, uncomment the `help` option. So, how can we make this a valid option? Go
back to `HelpFormExtension`, use the "Code"->"Generate" menu one last time, click
"Override Methods", and select `configureOptions()`:

[[[ code('55056e6203') ]]]

Our job here is *so* simple: `$resolver->setDefault('help', null)`:

[[[ code('0c9bea19cc') ]]]

Just by doing that, you are now allowed to have a `help` option on any field. It
also means that when `buildView()` is called, the `$options` array will have a key
called `help`. All we need to say is if `$options['help']`, then set the `help` variable
to `$options['help']`:

[[[ code('f863de26c4') ]]]

And that takes care of it. Try this puppy out.

And consider yourself very, very dangerous.
