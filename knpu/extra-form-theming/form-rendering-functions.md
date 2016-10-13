# Form Rendering Functions

I want to render this form, but be as *lazy* as humanly possible.

## The Lazy Way: form()

Copy the existing code - we'll put it back in a second. Then, use our first form
rendering function: `form()` and pass it the `genusForm` variable:

[[[ code('d727843eee') ]]]

That's it! Refresh! This prints all the fields... but dang! What happened to my submit
button!? The `form()` function renders *everything* in your form... but nothing else.
If you like this function, you'll actually need to add a submit button as a field
to your form. That's totally supported, but I like rendering my submit buttons by
hand. So I like being lazy, but not this lazy.

## A Little Less Lazy

If you're feeling just *one* level less lazy, try this: start with `form_start(genusForm)`
`form_end(genusForm)` and a submit button:

[[[ code('332bb31cbc') ]]]

Then, render all the fields with `form_errors(genusForm)` and `form_widget(genusForm)`:

[[[ code('f1ca795db2') ]]]

`form_start()` adds the starting form tag, but *with* the all-important
`enctype="multipart/form-data"` attribute if your form has a file field. The
`form_end()` function prints the closing form tag *plus* any fields that you forgot
to render. That's handy for automatically printing out hidden fields.

Next, this `form_errors()` is a little strange. Usually, when you have a validation
error, it's for one specific field - like "Name is required". But occasionally, you
might have an error that doesn't really belong to *one* field, but the form as a
whole. This line prints out those rare, but possible, global form errors.

Finally, if you call `form_widget()` and pass it your *entire* form, it loops over
and prints each one.

If you look at the reference now, we've already covered *most* of the form functions.

## The Nice Middle ground: form_row

Now, I like to render my forms a bit different. Let me undo my changes. Between the
form start and end tags, I usually render each field individually with `form_row()`:

[[[ code('829e3aaee4') ]]]

Oh, and we *should* still have the global form errors line: `form_errors(genusForm)`:

[[[ code('88c8569c74') ]]]

It's so rarely needed, I actually forgot to include it before. So... shame on me.

In reality, each field - like `name` or `subFamily` - consists of *three* parts:
the label, the widget - like an input field, textarea or select element, and the
validation errors, if there are any. If you leave "Name" blank and submit, bam!
Validation error.

The `form_row()` function renders all three parts at the same time, *and* wraps them
up in some markup that we can control. We'll talk soon about *how* to do that.

## Getting Specific

But, if you already need more control, you can skip `form_row()` and render the three
pieces individually: `form_label()`, `form_widget()` and `form_errors()` - passing
each the `genusForm.name` field:

[[[ code('03f3570b6b') ]]]

Refresh that! It's *almost* the same: the three parts are there, but the red error
styling is gone. That makes sense: `form_row()` prints the three parts, but also
surrounds them in some markup, which until now, was giving us some fancy error styling
thanks to Bootstrap CSS.

So let's switch *back* to using `form_row()` so that *every* field is rendered in
a consistent way, *unless* you actually need to do something custom.

So those are your brave and valiant form rendering functions. Each function's first
argument is something called "view" - that's just the field - like `genusForm.name`.
We call it a view, and you'll find out why later.

But check *this* out! Most of these functions *also* have an argument called `variables`.
I know, that's a *really* generic-sounding argument. But it turns out that when it
comes to kicking butt with form rendering, these *variables* are the key.
