# Form Variables are the Bomb

My favorite form rendering function is `form_row()` - pass the field as the first
argument and... um... something weird called *variables* as the second argument.
What are these variables?

## Overriding the label Variable

Apparently, it's an array, and one variable you can pass is called `label`. So if
you want to override a field's label, one way is with variables.

Give that a try with the `subFamily` field: add a second argument - a Twig array
or hash - and say `label` set to `Taxonomic Subfamily`:

[[[ code('ccc9b494b7') ]]]

Try that - refresh! Okay, that's cool.

## Overriding the attr Variable

So what *else* can we do with these variables? It also turns out that every field
has a variable called `attr`, which is itself, an array. These are attributes that
you want set on the widget, meaning the actual field itself.

So, you can give your field a class `foo`, or set `disabled` to `disabled`:

[[[ code('cdcba1f991') ]]]

Try that out. Perfect! The field is disabled and if you dig a little, there's the
`foo` class.

These variables give us *huge* control over our fields. But, this still does *not*
answer my original question: what are the variables that I can use on a field beyond
just `label` and `attr`?

## Listing all Available Variables

It turns out, the answer is hiding right down here in your web debug toolbar. Click
the clipboard icon to go to the forms section of the profiler. Check this out: if
you select a single field - like `subFamily` - you'll get a *ton* of good information.
It shows you stuff about the submitted data, the options you passed when you originally
created the field, and - most importantly - View Variables! Yes! This is your master
list of *every* variable that's being used to render *this* field. And you can override
- get this - *everything*.

This gives you access to the `id` attribute, the `name` attribute, the `label` we
just overrode and even a way to add an attribute to your label element! Heck there's
even a variable called `disabled`: we can just use that instead of setting the attribute.

Remove the `disabled` attribute, and then set `disabled` to `true`:

[[[ code('1dd197650e') ]]]

That'll have the same effect: the field is still disabled.

## Field Options Versus Variables

Head back into the profiler. The `subFamily` field has a variable called `placeholder`
set to "Choose a Sub Family". To see what this does, remove the `disabled` variable.
Then, refresh. There it is! The `placeholder` is the option that appears at the
*top* of the `select` element.

Why is this set to "Choose a Sub Family"? Because that's what *we* passed as the
`placeholder` *option* when we configured the field:

[[[ code('773850a5b0') ]]]

Back in the template, override the variable, set `placeholder` to `Select a Subfamily`:

[[[ code('ad285f74f6') ]]]

So, which will win? The `placeholder` option, or the `placeholder` variable? Let's
find out! Refresh!

It's "Select a Subfamily": the *variable* wins.

I wanted to show you this because this touches on a *really* important thing. When
you configure a field in your form class, each field has a set of options. These are
*not* the same thing as the variables you can override in your template.

Nope: your form class holds field *options*, and your rendering functions have *variables*.
Occasionally, a field has an option and a variable with the same name, like `placeholder`.
But for the most part, these are two totally separate ideas: a field has a set of
*options*, which mostly influence how the field should *function*, and a different
set of *variables*, which help decide how the field will be *rendered*.

## Dumping Form Variables

Before we move into form theming, there's *one* other way to get a list of the variables
for a field: dump them! 

When we write `genusForm.subFamily`, this is actually an instance of an object
called `FormView`. A `FormView` object doesn't really have much information on it,
*except* for a public `$vars` property that holds all of its variables:

[[[ code('49dd8d327a') ]]]

Print them with `dump(genusForm.subFamily.vars)`:

[[[ code('d7009bf568') ]]]

Head back, refresh, and boom! Check out this beautiful list. This will become even
more important later. Ok, let's talk about form theming.
