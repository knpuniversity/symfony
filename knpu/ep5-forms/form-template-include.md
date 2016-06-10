# Sharing Form Templates with include()

Adding edit was quick! But the *entire* template is now duplicated. This includes
the code to render the form *and* the other blocks that include the needed CSS
and JS files.

First, copy the form rendering code and move that into a new file: `_form.html.twig`:

[[[ code('c79ca5156a') ]]]

Paste it here.

In edit, just include that template: `include('admin/genus/_form.html.twig')`:

[[[ code('5460e8d5d0') ]]]

Copy that, open `new.html.twig`, and paste it there:

[[[ code('1de49cef81') ]]]

Ok, I'm feeling better. Refresh now: everything still looks good.

And by the way, if there *were* any customizations you needed to make between
new and edit, I would pass a variable in through the second argument of the `include`
function and use that to control the differences. 

## Using a Form Layout

So let's fix the last problem: the duplicated block overrides.

To solve this, we'll need a shared layout between these two templates. Create a new
file called `formLayout.html.twig`. This will *just* be used by these two templates.

Copy the `extends` code all the way through the `javascripts` block and delete it
from `edit.html.twig`:

[[[ code('6f8f969fd9') ]]]

Paste it in `formLayout.html.twig`:

[[[ code('5846589678') ]]]

So this template *itself* will extend `base.html.twig`, but not before adding some
stylesheets and some JavaScripts. In edit, re-add the `extends` to use this template:
`admin/genus/formLayout.html.twig`:

[[[ code('379db3bfb3') ]]]

Copy that, open `new.html.twig` and repeat: delete the `javascripts` and `stylesheets`
and paste in the new extends:

[[[ code('2ca068cdb0') ]]]

Try it! Cool! We're using our Twig tools to get rid of duplication!

## A Word of Caution

Congrats team - that's it for our first form episode. You should feel dangerous.
Most of the time, forms are easy, and amazing! They do *a lot* of work for you.

Let me give you one last word of warning: because this is how I see people get into
trouble.

Right now, our form is bound to our entity and that makes this form super easy to
use. But eventually, you'll need to build a form that does *not* look exactly like
your entity: perhaps it has a few extra fields or is a combination of fields from
several entities.

When you run into this: here's what I want you to do. Don't bind your form to your
entity class. Instead, create a brand new class: I usually put these classes inside
my `Form` directory. For example, `GenusModel`. This class will have the *exact*
properties that your form needs.

Bind *this* class to your form and add all your validation rules like normal.
After you submit your form, `$form->getData()` will return this *other* object.
Then, it'll be your job to write a little bit of extra code that reads this data,
updates your entities - or whatever else you need that data for - and saves things.

If you have questions, let me know in the comments.

There's certainly more to learn, but don't wait! Get out there and build something
crazy cool!

Seeya guys next time!
