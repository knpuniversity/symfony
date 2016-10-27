# Form Options & Variables: Dream Team

We now know that these form variables kick butt, *and* we know how to override them
from inside a template. But, could we *also* control these from inside of our form
class?

Earlier, I mentioned that the *options* for a field are totally different than the
*variables* for a field. Occasionally, a field has an option - like `placeholder` -
*and* a variable with the same name, but that's not always true. But clearly, there
must be *some* connection between options and variables. So what is it?!

## Form Type Classes & Options

First, behind every field type is a class. Obviously, for the `subFamily` field,
the class behind this is `EntityType`:

[[[ code('1e23498bb7') ]]]

`name` is a *text* type, so the class behind it, is, well, `TextType`. I'll use
the `Shift`+`Shift` shortcut in my editor to open the `TextType` file, from the
Symfony Form component:

[[[ code('0664602efb') ]]]

Now, unlike variables, there is a specific *set* of valid options for a field. If
you pass an option that doesn't exist, Symfony will scream at you. The *valid*
options for a field are determined by this `configureOptions()` method:

[[[ code('8e1c3a8317') ]]]

Apparently the `TextType` has a `compound` option, and it defaults to `false`.

## Form Type Inheritance

Earlier, when we talked about form theme blocks, I mentioned that the field types
have a built-in *inheritance* system. Well, technically, `TextType` extends `AbstractType`,
but behind-the-scenes, the `TextType`'s parent type is `FormType`. In fact, *every*
field ultimately inherits options from `FormType`. Open that class:

[[[ code('cf5f4414ec') ]]]

***TIP
Wondering how you would know what the "parent" type of a field is? Each `*Type` class
has a `getParent()` method that will tell you. If you don't see one, then it's
defaulting to `FormType`.
***

This is cool because it *also* has a `configureOptions()` method that adds a *bunch*
of options:

[[[ code('e9fc241ddf') ]]]

These are the options that are available to *every* field type. And actually, the parent
class - `BaseType` - has even more:

[[[ code('d1a537f635') ]]]

There are easier ways to find out the valid options for a field - like the documentation
or the form web profiler tab. But sometimes, being able to see how an option is *used*
in these classes, might help you find the right value.

## The label Option versus Variable

Let's see an example. In the form, we add a `subFamily` field:

[[[ code('474124550a') ]]]

Then, in the template, we override the `label` variable:

[[[ code('b100ce3640') ]]]

But, according to `BaseType`, this field, well *any* field, also has a `label` *option*:

[[[ code('90667d3332') ]]]

### The Form to FormView Transition

That's interesting! Let's see if we can figure out how the option and variable
work together. Scroll up in `BaseType`. These classes also have another function
called `buildView()`:

[[[ code('ff85405008') ]]]

In a controller, when you pass your form into a template, you always call `createView()`
on it first:

[[[ code('e976b473a6') ]]]

*That* line turns out to be *very* important: it transforms your `Form` object into
a `FormView` object.

In fact, your form is a big tree, with a `Form` on top and fields below it, which
themselves are *also* `Form` objects. When you call `createView()`, all of the `Form`
objects are transformed into `FormView` objects.

To do that, the `buildView()` method is called on each individual field. And one
of the arguments to `buildView()` is an array of the final *options* passed to
this field:

[[[ code('e46a2e846c') ]]]

For example, for `subFamily`, we're passing three options:

[[[ code('cb09b1040b') ]]]

We could also pass a `label` option here.

These values - merged with any other default values set in `configureOptions()` -
are then passed to `buildView()` and... if you scroll down a little bit, many of
them are used to populate the *vars* on the `FormView` object of this field. Yep,
these are the same *vars* that become so important when rendering that field:

[[[ code('c49f861132') ]]]

To put it simply: every field has options and *sometimes* these options are used
to set the form *variables* that control how the field is rendered:

[[[ code('e0e3abc6de') ]]]

Symfony gives us a `label` *option* as a convenient way to ultimately set the `label`
variable.

Close up all those classes. Here's a question: we know how to set the `help` variable
from inside of a Twig template. But could we somehow set this variable from inside
of the `GenusFormType` class? Yes, and there are actually *two* cool ways to do it.
Let's check them out.
