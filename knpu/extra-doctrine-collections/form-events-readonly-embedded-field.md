# Form Events: A readonly Embedded Field

Ready for the last challenge? All four of these genus scientists are already saved
to the database. And while I guess it's kind of cool that I can change this scientist
from one `User` to another, it's also a little bit weird: When would I ever change a
specific scientist from one `User` to another? If this `User` weren't studying this
`Genus` anymore, I should delete them. And if a *new* `User` were studying this `Genus`,
we should probably just add a *new* `GenusScientist`.

So I want to update the interface: when I hit "Add Another Scientist", I *do* want
the `User` select, just like now. But for *existing* genus scientists - the ones
that are already saved to the database - I want to simply print the user's email
in place of the drop-down.

In Symfony language, this means that I want to remove the `user` field from the
embedded form if the `GenusScientist` behind it is already saved.

## About Form Events

To do that, open the `GenusScientistEmbeddedForm`. Guess what? We get to try a feature
that I don't get to use very often: Symfony Form Events.

Here's the idea: every form has a life cycle: the form is created, initial data is
set onto the form and then the form is submitted. And we can hook into this process!

## Form Event Setup!

To do it, write `addEventListener()` and then pass a constant `FormEvents::POST_SET_DATA`.
After that, say `array($this, 'onPostSetData')`:

[[[ code('b57165bb1d') ]]]

Let's break that down: the `POST_SET_DATA` is a constant for an event called
`form.post_set_data`. This is called after the data behind the form is added to it:
in other words, after the `GenusScientist` is bound to each embedded form.

When that happens, the form system will call an `onPostSetData()` function, which we
are about to create: `public function onPostSetData()`. This will receive a `FormEvent`
object:

[[[ code('9beb533a23') ]]]

Now we're close! Inside, add an if statement: if `$event->getData()`:This form is
always bound to a `GenusScientist` object. So this will return the `GenusScientist`
object bound to this form, *or* - if this is a new form - then it may return `null`.
That's why we'll say if `$event->getData() && $event->getData()->getId()`:

[[[ code('ec5783930a') ]]]

In human-speak: as long as there is a `GenusScientist` bound to this form and it's been
saved to the database - i.e. it has an id value - then let's unset the `user` field
from the form.

To do that, fetch the form with `$form = $event->getForm()`. Then, literally,
`unset($form['user'])`:

[[[ code('3129a70007') ]]]

This `$form` variable is a `Form` object, but you can treat it like an array, including
unsetting fields.

That's it for the form! The last step is to conditionally render the `user` field.
Because if we refresh right now, the form system yells at us:

> There's no `user` field inside of our template at line 9.

Wrap that in an if statement: `if genusScientistForm.user is defined`, then print it:

[[[ code('a1f36a3a13') ]]]

Else, use a strong tag and print the user's e-mail address with `genusScientistForm.vars` -
which is something we mastered in our [Form Theming tutorial][form_variables] -
`.data` - which will be a `GenusScientist` object - `.user.email`:

[[[ code('5421962963') ]]]

This says: find the `GenusScientist` object behind this form, call `getUser()` on
it, and then call `getEmail()` on that.

I think it's time to celebrate! Refresh the form. It looks *exactly* like I wanted.
It's like my birthday! And when we add a new one, it *still* has the drop-down.
You guys are the best!


[form_variables]: https://knpuniversity.com/screencast/symfony-form-theming/i-heart-form-variables
