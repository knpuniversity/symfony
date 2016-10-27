# Go Deeper: Vars, Twig merge & Form Functions

Look closer at the Bootstrap help feature: to be nice to screen readers, we should
add an `aria-describedby` attribute to the field that points to an `id` that we add
to the help span:

```html
<label class="sr-only" for="inputHelpBlock">Input with help text</label>
<input type="text" id="inputHelpBlock" class="form-control" aria-describedby="helpBlock">
...
<span id="helpBlock" class="help-block">
    A block of help text that breaks onto a new line and may extend beyond one line.
</span>
```

That way, when a screen reader focuses on the text box, it will read the help text,
which is pretty rad. It also turns out that pulling this off is a cool challenge!

Let's start with a plan: when the `form_widget()` function is called inside `form_row`:

[[[ code('288dcc5fb4') ]]]

we want the `attr` variable to have a new key called `aria-describedby`. We've seen
magic like this before: in the Bootstrap layout, the `form_widget_simple` block
*modifies* the `attr` variable before calling the parent block:

[[[ code('b5d2c4f2ca') ]]]

That's what we want to do!

## Modifying the attr variable

Back in our block, before `form_widget()`, add another if `help|default`. Inside,
set `attr = attr|merge()` with an array argument. The core `merge` filter will
`array_merge()` the argument back into the `attr` variable. Add `aria-describedby`
set to... well, nothing yet:

[[[ code('687c851ee0') ]]]

First, we need to give our help span an id. Do that: set it to `help-block-` then
print the `id` variable to make sure this is unique:

[[[ code('43dc815563') ]]]

The `id` variable will become the `id` attribute on the field itself.

Now set the `aria-describedby` to `help-block-`, a `~` then id:

[[[ code('8e6757fde9') ]]]

The `~` is Twig's rarely-used concatenation operator, so, it's like `.` in PHP.

Ok! Now that `attr` is changed *before* we call `form_widget`, it'll hopefully
render on that widget. Time to give it a try. Refresh!

Ok, go dig into the source to see if the attribute is there. Umm... it's not! There
is *not* any `aria-describedby`. This tutorial is a LIE!

## To Pass or Not Pass Variables

No no, it's cool. It turns out that there's a very subtle, but important detail that
I'm neglecting. Let me show you: click to open the parent `form_div_layout.html.twig`
template. We're letting Symfony *guess* this, but the `speciesCount` is a `NumberType`,
meaning it'll render as an `<input type="number" />` field:

[[[ code('0fe54c89e8') ]]]

Inside the layout file, find the `number_widget` block that renders this:

[[[ code('44a6202df5') ]]]

Ok, check it out: it sets a `type` variable, and then calls the `form_widget_simple`
block. Then, when `form_widget_simple` executes, `type` is set to `number`:

[[[ code('1e696cad90') ]]]

So, why does *that* work, but not our code? Well look at that code again: it sets
a variable and then calls the *block* function. When you call `block()`, all variables
flow through to that block.

But now check out our code: we set a variable, but then we don't execute a block!
We call `form_widget()`. Hey! that's a form rendering function - the same kind that
we use inside our normal templates. In this case, the variables *do not* magically
flow through. But that's ok! We already know how to pass variables into `form_widget()`.
Add a second argument, and pass `attr` set to `attr`:

[[[ code('0be92f841a') ]]]

Let's refresh! Inspect the field, well, not *any* field - inspect the `isPublished`
field. This time, we got it!

So not only are you a form-theming pro, but you're quickly becoming a Twig all star.
