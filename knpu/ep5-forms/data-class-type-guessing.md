# Binding Forms to Objects: data_class

Open `GenusFormType` and find the `configureOptions()` method. Add `$resolver->setDefaults()`.
Pass that an array with a single key called `data_class` set to `AppBundle\Entity\Genus`:

[[[ code('f53d936d53') ]]]

Do *nothing* else: refresh to re-submit the form.

Boom! Now we have a brand-new `Genus` object that's just waiting to be saved. Thanks
to the `data_class` option, the form creates a new `Genus` object behind the scenes.
And then it sets the data on it.

Earlier, when we got back an associative array, these field names - `name`, `speciesCount`
and `funFact` – could have been anything:

[[[ code('af561fae8d') ]]]

But as soon as you bind your form to a class, `name`, `speciesCount` and `funFact` need
to match property names inside of your class:

[[[ code('15f835e4fb') ]]]

Actually, that's *kind of* lie. These properties are private, so the form component
*can't* set them directly. In reality, it guesses a setter function for each field and
call that: `setName()`, `setSpeciesCount()` and `setFunFact()`:

[[[ code('8b07a59a74') ]]]

Technically, you could add a form field call `outOnAMagicalJourney` as long as you had
a public method in your class called `setOutOnAMagicalJourney()`.

## Form Field Guessing!

Head back to your browser, highlight the URL and hit enter. This just made a GET
request, which skipped form processing and just rendered the template.

Let's add a few more field we need: like `subFamily`:

[[[ code('95a0fef755') ]]]

Hey, we're even getting auto-complete now: PhpStorm knows `Genus` has a `subFamily` property!

Also add `isPublished` - that should eventually be a checkbox - and `firstDiscoveredAt` -
that will need to be some sort of date field:

[[[ code('26a41179c6') ]]]

Cool, try it out!

Huge error!

> Catchable Fatal Error: Object of class `SubFamily` could not be converted to string

Okay: that's weird. What's going on?

Until now, it looked like Symfony renders every field as an input text field by default.
But that's not true! There's a lot more coolness going on behind the scenes!

In reality, the form system looks at each field and tries to *guess* what type of
field it should be. For example, for `subFamily`, it sees that this is a `ManyToOne`
relationship to `SubFamily`:

[[[ code('8547fa6c8a') ]]]

So, it tries to render this as a select drop-down of sub families. That's amazing,
because it's *exactly* what we want.

But, it needs to be able to turn a `SubFamily` object into a string so it can render
the text for each option in the select. That's the source of the error.

To help it, add a `public function __toString()` to the `SubFamily` class:

[[[ code('09ab306943') ]]]

Refresh again!

Look at this! A free drop-down with almost no work. It also noticed that `isPublished`
should be a checkbox because that's a `boolean` field in Doctrine:

[[[ code('4c82d1c24c') ]]]

And since `firstDiscoveredAt` is a date, it rendered it with year-month-day drop-down
boxes. Now, those three boxes are *totally* ugly and we'll fix it later, but isn't it
cool that it's *guessing* the right field types?

Fill out the form again with super-realistic data and submit. Woh! One more error:

> Neither the property `isPublished`  nor one of the methods `getIsPublished()` exist
  and have public access in class `Genus`

Remember how every form field needs a setter function on your class? Like `name` and
`setName()`? Every field *also* needs a *getter* function - like `getIsPublished()`
or one of these other variations. 

This was my bad: when I set this up, I added an `isPublished` property, a `setIsPublished()`
method, but no getter! I'll use the "Code"->"Generate" menu - or `command`+`N` - to generate
that getter:

[[[ code('f6b18d1f04') ]]]

Refresh! It dumps the `Genus` object of course, but check out the `subFamily` field!
It's not the `SubFamily` *ID* - the form field took the submitted ID, queried the
database for the `SubFamily` object and set *that* on the property. That's HUGE.

We're ready to save this!
