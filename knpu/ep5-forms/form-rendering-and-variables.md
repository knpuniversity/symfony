# Form Rendering and Form Variables

Let's talk form rendering.

Sure, things looks nice right now, especially considering we're rendering all the
fields in one line!

The problem? First, we can't change the order of the fields. And second, we won't
be able to control the labels or anything else that we're going to talk about.

## Using form_row

So, in reality, I don't use `form_widget` to render all my fields at once.
Replace this with a different function: `form_row` and pass it `genusForm.` and
then the name of one of the fields - like `name`:

[[[ code('8b9aed8702') ]]]

Since this form has 1, 2, 3, 4, 5, 6 fields, I'll copy that and paste it six times.
Now, fill in all the field names: `subFamily`, `speciesCount`, `funFact`, `isPublished`
and `firstDiscoveredAt`:

[[[ code('3066070153') ]]]

Refresh! OMG - it's the *exact* same thing as before!!! This is what `form_widget`
was doing behind the scenes: looping over the fields and calling `form_row`.

## All the Form Rendering Functions

So, at this point, you're probably asking:

> What else can I do? What other functions are there? What options can I pass
  to these functions?

Look, I don't know! But I bet Google does: search for "form functions twig" to find
another reference section called [Form Function and Variable Reference][1].

Ah hah! This is our cheatsheet!

First - we already know about `form_row`: it renders the 3 parts of a field, which
are the label, the HTML widget element itself and any validation errors.

If you ever need more control, you can render those individually with `form_widget`,
`form_label` and `form_errors`. Use these *instead* of `form_row`, *only* when you
need to.

## Form Variables

Now notice, most of these functions - including `form_row` - have a second argument
called "variables". And judging by this code example, you can apparently control
the `label` with this argument.

Listen closely: these "variables" are the most *powerful* part of form rendering.
By passing different values, you can override almost *every* part of how a field
is rendered.

So what *can* you pass here? Scroll down near the bottom to find a big beautiful
table called [Form Variables Reference][2].

This gives you a big list of all the variables that you can override when rendering
a field, including `label`, `attr`, `label_attr`, and other stuff.

To show this off, find the `speciesCount` field and add a second argument set to
`{}` - the Twig array syntax. Override the `label` variable: set it to `Number of Species`:

[[[ code('bde0cb0d1b') ]]]

Refresh! It's just that easy.

## The Amazing Form Profiler

There's one *huge* form tool that we haven't looked at yet. Your web debug toolbar
*should* have a clipboard icon. Click it.

This is the profiler for your form, and it's *packed* with stuff that's going to
make your form life better. If you click `speciesCount`, you can see the different
data for your species - which isn't too interesting on this blank form. You can see
any submitted data and all of the variables that can be passed to the field.

It turns out, the reference section we looked at has *most* of the variables but
*this* will have *all* of them. This is your place to answer:

> What are the values for my variables? And, what can I override?

This also shows you "Resolved Options": these are the final values of the options
that can be passed as the third argument to the `add()` function.

## CSRF Protection

Oh, and check out this `_token` field. Do you remember adding this?

Hopefully not - because we never did! This is a CSRF token that's automatically added
to the form. It's rendered *for* us when we call `form_end` and validated behind the
scenes along with all the other fields. It's free CSRF protection.


[1]: http://symfony.com/doc/current/reference/forms/twig_reference.html
[2]: http://symfony.com/doc/current/reference/forms/twig_reference.html#form-variables-reference
