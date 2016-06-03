# Field Types and Options

So far, we set the property name of the form fields and Symfony tries to *guess*
the best field type to render. Since `isPublished` is a `boolean` in the database,
it guessed a checkbox field:

[[[ code('a212b44524') ]]]

But obviously, that's not always going to work.

Google for "Symfony form field types", and find a document called
[Form Types Reference][1].

These are *all* the different field types we can choose from. It's got stuff you'd
expect - like `text` and `textarea`, some HTML5 fields - like `email` and `integer` and
some more unusual types, like `date`, which helps render date fields, either
as three drop-downs or a single text field.

Right now, `isPublished` is a checkbox. But instead, I'd rather have a select drop-down
with "yes" and "no" options. But... you won't see a "select" type in this list. Instead,
it's called [ChoiceType][2].

## Using ChoiceType

`ChoiceType` is a little special: it can render a drop-down, radio buttons or checkboxes
based on what options you pass to it. One of the options is `choices`, which, if
you look down at the example, you can see controls the actual items in the drop-down.

Let's use this! In `GenusFormType`, the optional second argument to the `add` function
is the field *type* you want to use. Set it to `ChoiceType::class`:

[[[ code('94506effac') ]]]

The third argument is an array of options to configure that field. What can you pass
here? Well, each field type has different options... though there are a lot of options
shared by *all* types, like the ability to customize the label.

Either way, the reference section will tell you what you can use. Pass in the `choices`
option and set that to an array. Add `Yes` mapped to `true` and `No` mapped to `false`.
The keys - `Yes` and `No` will be the text in the drop down:

[[[ code('5d8a5e1641') ]]]

The values - `true` and `false` will be the value that's passed to `setIsPublished()` if
that option is chosen.

Try it out! Head back to the form and refresh! Perfect.

## The EntityType

Let's keep going with this. This `subFamily` field is also a drop-down. So that's
probably being *guessed* as a `ChoiceType`, right? *Almost*. Check out the [EntityType][3].
This is *just* like the `ChoiceType`, except it's really good at fetching the options
by querying an entity.

In this case, it's automatically querying for the `SubFamily` entity: it guessed
which type to use *and* auto-configured it. And yeah, I know - these sub-families
are totally silly. They're actually just the last names of people - coming from the
Faker library - I was being lazy.

## Form Field Options

But I do have one problem with this `EntityType` field: it auto-selects the first
option. That's lame - I'd rather have an option on top that says "Choose a Sub-Family".

Check out the options for `EntityType`: there's one called `placeholder`. Click to
read more about that. Yes! This is exactly what we want!

Open the form class back up. We know that Symfony is guessing the `EntityType` for
the `subFamily` field. We *could* now manually pass `EntityType::class` as the second
argument. But don't! Pass `null` instead. Now, add a `placeholder` option set
to `Choose a Sub-Family`:

[[[ code('84499a94cb') ]]]

But wait, why did I pass `null` as the second argument? Well first, because I can!
I can be lazy here: if I pass `null`, Symfony will guess the `EntityType`. That's
cool.

Second, when you use the `EntityType`, there's a required option called `class`.
Let me show you an example: `'class' => 'AppBundle:User'`. You have to tell
it *which* entity to query from. But if you let Symfony *guess* the field type for
you, then it will also guess any options it can, including this one. So by being
lazy and passing `null`, it will continue to guess the field type *and* a few other
options for me, like `class`.

Anyways, go back, refresh, and there it is. Here are the key takeaways. First, you
have a giant dictionary of built-in form field types. And second: you configure each
field by passing a third argument to the `add()` function.

Now, how could we *further* control the query that's made for the `SubFamily` options?
What if we need them to be listed alphabetically?


[1]: http://symfony.com/doc/current/reference/forms/types.html
[2]: http://symfony.com/doc/current/reference/forms/types/choice.html
[3]: http://symfony.com/doc/current/reference/forms/types/entity.html
