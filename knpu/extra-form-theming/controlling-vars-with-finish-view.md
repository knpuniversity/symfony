# Controlling Vars with finishView()

Question: can we control form *view* variables directly from inside `GenusFormType`?
Of course! Use the "Code"->"Generate" menu, or `Command`+`N` on a Mac, click "Override Methods"
and then select a method called `finishView()`.

There are actually *two* methods that are called when your form is transformed into
a `FormView` object: `buildView()` and `finishView()`: one is called at the beginning,
and the other at the end.

In this case, we want `finishView()`:

[[[ code('6dc4e6b538') ]]]

Don't worry about calling the parent function, it's empty.

The `FormView` object that's passed to this method is the final, top-level `FormView`
object that represents the entire form. Now, check this out: use
`$view['funFact']->vars['help'] = ` and then type a message, like, a nice fun
fact suggestion:

[[[ code('eccbdaabe8') ]]]

Congratulations: you've just set that view variable. But let's break it down. The
`$view` variable is the *top* of our `FormView` tree. To get a `FormView` for
a specific field, access it like an array key.

At this point, `$view['funFact']` gives you the *same* `FormView` object that you
would get in a template by calling `genusForm.funFact`. Then, we access the public
`vars` array property and add a `help` key to it. Ultimately, this adds that view
variable.

Refresh to check it out. It works! And now there's nothing we can't change!

But let's do something even harder. Copy the `help` string, then comment out the
`finishView()` method entirely. Find the `funFact` field above, pass `null` as the
second option so that Symfony keeps guessing the field type, then add a new help
*option*:

[[[ code('f353a1ffce') ]]]

I want *this* to ultimately set a `help` variable for me.

But if you try it now, *huge* error!

> The option "help" does not exist.

That's no surprise: I just invented this option! But, we *can* make this work.
