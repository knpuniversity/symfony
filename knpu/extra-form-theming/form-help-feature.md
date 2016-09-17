# Adding Form Field Help Text

I think we should becomes legends by adding a *totally* new feature to Symfony!

I want to be able to add some help text under each field - ya know to give the user
a little bit more info about that field.

Bootstrap already has markup and CSS for this. If we add a `span` and give it a
`help-block` class, it should look great, for free.

## Inventing a new help Variable

This feature doesn't exist in Symfony... yet, but here's how I *want* it to work:
I want to be able to pass a variable called `help` and just have it show up.

As promised, nothing happens yet. But! Now that we are passing in a new, invented
variable called `help`, this variable is *already* available in our form theme templates.
Head into the `form_row` block, render `dump()` with no arguments, and then refresh.

Search for help: it's alive! The `isPublished` field is *rocking* that variable.

So yea, you're free to pass in *whatever* variables you want. And that makes us,
super dangerous. If the `help` message is set, then add the span, give it the `help-block`
class and print help.

## Using the default Filter Everywhere

Try that out. Oh... and it does not work. Of course: the `form_row` block is called
for *every* field, but the `help` variable *only* exists for the `isPublished` field.
We need to code defensively! How? Just pipe the `help` variable to the `default`
filter.

Yep, that's it. This says:

> If the `help` variable does *not* exist, don't throw a big error, just default
> the variable to null and, have a nice day.

When you use `default`, you can either pass it a default value - like we did above -
or let it use `null`, which is cool for us.

Try this! Suhweet!

Next, we'll do a bit more work to make our forms friendly for screen readers. Pulling
this off gets *really* interesting.
