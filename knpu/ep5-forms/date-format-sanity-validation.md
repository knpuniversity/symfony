# Date Format & "Sanity" Validation

Let's use the fancy new date picker. Fill in the other fields and hit submit.

Whoa! Validation Error!

First, the good news: the error looks nice! And we didn't do any work for that.

Now, the bad news: do you remember adding any validation? Because I don't! So, where
is that coming from?

## The Format of the Date Field

What you're seeing is a really amazing automatic thing that Symfony does. And I
invented a term for it: "sanity validation".

Remember, even though this has a fancy date picker widget, this is *just* a text
field, and it needs to be filled in with a very specific format. In this case, the
widget fills in month/day/year.

But what if Symfony expects a different format - like year/month/day?

Well, that's *exactly* what's happening: Symfony expects the date in one format, but
the widget is generating something else. When Symfony fails to parse the date, it
adds the validation error. 

## Sanity Validation

So, it turns out that many fields have sanity validation. It basically makes sure
that a *sane* value is submitted by the user. If an *insane* value is sent, it blocks
the way and shows a message.

For example, the `speciesCount` is using Symfony's `NumberType`, which renders as
an HTML5 field with up and down arrows on some browsers:

[[[ code('53f2ddc1ed') ]]]

If we tried to type a word here and submit, the `NumberType` would throw a validation
error thanks to sanity validation.

Our drop-down fields *also* have sanity validation. If a jerk user tries to hack
the system by adding an option that we did *not* originally include, the field will
fail validation. 99% of the time, you don't know or care that this is happening.
Just know, Symfony has your back.

## Making the Date Formats Match

But how do we fix the date field? We just need to make Symfony's expected format match
the format used by the datepicker. In fact, the `format` itself is an option on the
`DateType`. I'll hold `command` and click into `DateType`. When you use the `single_text`
widget, it expects this `HTML5_FORMAT`: so year-month-day.

Let's update the JavaScript widget to match this.

How? On its docs, you'll see that it *also* has a `format` option. Cool!

Now, unfortunately, the format string used by the DateType and the format string
used by the datepicker widget are not *exactly* the same format - each has its own
system, unfortunately. So, you may need to do some digging or trial and error.
It turns out, the correct format is `yyyy-mm-dd`:

[[[ code('fac9529909') ]]]

OK, go back and refresh that page. Fill out the top fields... and then select a
date. Moment of truth. Got it!

## Data Transformers

So I keep telling you that the purpose of the field "types" is to control how a field
is rendered. But that's only *half* of it. Behind the scenes, many fields have a
"data transformer".

Basically, the job of a data transformer is to transform the data that's inside of
your PHP code to a format that's visible to your user. For example, the `firstDiscoveredAt`
value on `Genus` is actually a `DateTime` object:

[[[ code('06515373da') ]]]

The data transformer internally changes that into the string that's printed in the box.

Then, when a date string is submitted, that same data transformer does its work in
reverse: changing the string back into a `DateTime` object.

The data transformer is also kicking butt on the `subFamily` field. The `id` of the
selected `SubFamily` is submitted. Then, the data transformer uses that to query
for a `SubFamily` object and set that on `Genus`.

You don't need to know more about data transformers right now, I just want you to
realize that this awesomeness is happening.
