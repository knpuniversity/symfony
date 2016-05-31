# Render that Form Pretty (Bootstrap)

Head into the `GenusAdminController`. I gave us a *tiny* head start - there's already
a `newAction()`:

[[[ code('076835d9b5') ]]]

In the admin area, the "Add" button points here. Click it!

> The controller must return a response (`null` given). Did you forget to add a return
  statement somewhere in your controller?

Yep, a great explosion!

## Instantiating the Form Object

To create the form object, add `$form = $this->createForm()`. This is a shortcut method
in the base `Controller` that calls a method on the `form.factory` service. That's
my friendly reminder to you that *everything* - including form magic - is done by
a service.

To `createForm()`, pass it the form type class name - `GenusFormType::class`:

[[[ code('b01ef61f94') ]]]

And because I used autocomplete, that *did* just add the `use` statement for me. The
`::class` syntax is new in PHP 5.5 - and we're going to use it a lot.

## Rendering the Form

Now that we have a form object, just render a template a pass it in: `return $this->render()`
with `admin/genus/new.html.twig` to somewhat follow the directory structure of the
controller:

[[[ code('dbc33ca85a') ]]]

Pass in one variable `genusForm` set to `$form->createView()`:

[[[ code('80f30b2f56') ]]]

Don't forget that `createView()` part - it's something we'll talk about more in a future
course about form theming.

Hold `command`+`click` to jump into the template. Yep, I took the liberty of already
creating this for us in the `app/Resources/views/admin/genus` directory:

[[[ code('3abfa8e6ee') ]]]

Here, we know we have a `genusForm` variable. So... how can we render it? You can't
render! I'm kidding - you totally can, by using several special Twig functions that
Symfony gives us.

## The Form Twig Functions

First, we need an opening form tag. Render that with `form_start(genusForm)`:

[[[ code('1e8a3ab021') ]]]

To add a closing form tag, add `form_end(genusForm)`:

[[[ code('43beee4372') ]]]

I know, having functions to create the HTML form tag seems a little silly. But, wait!
`form_start()` is cool because it will add the `enctype="multipart/form-data"` attribute
if the form has an upload field. And the `form_end()` function takes care of rendering
hidden fields. So, these guys are my friends.

Between them, render all three fields at once with `form_widget(genusForm)`:

[[[ code('b4b5eb8b48') ]]]

And finally, we need a button! We can do that by hand: `<button type="submit">`, give
it a few Bootstrap classes and call it "Save":

[[[ code('c2ea3033ef') ]]]

***TIP
You *can* also add buttons as fields to your form. But this is helpful in very
few cases, so I prefer just to render them by hand.
***

that's it! Head to the browser and refresh.

There it is! A rendered form with almost no work. They're all text boxes now: we'll
customize them soon.

## The Bootstrap Form Theme

Of course, it *is* pretty ugly... Symfony has default HTML markup that it uses to
render everything you're seeing: the labels, the inputs and any validation errors.

Since we're using Bootstrap, it would be *really* cool if Symfony could automatically
render the fields using Bootstrap-friendly markup.

Yep, that's built-in. Open `app/config/config.yml`. Under `twig`, add `form_themes`
and then below that `- bootstrap3_layout.html.twig`. Actually, make that `bootstrap_3_layout.html.twig`:

[[[ code('a2ecc68935') ]]]

Form themes are how we can control the markup used to render forms. The `bootstrap_3_layout.html.twig`
template lives in the core of Symfony and now, our form markup will change to use
HTML bits that live inside of it.

Try it out. Beautiful. Now, let's submit this form and do something with its data.
