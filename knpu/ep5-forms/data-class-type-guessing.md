# Binding Forms to Objects: data_class

Open `GenusFormType` and find the `configureOptions()` method. Add `$resolver->setDefaults()`.
Pass that in an array with a single key called `data_class` set to `AppBundle\Entity\Genus`.
Do *nothing* else: refresh to re-submit the form.

Boom! Now we have a band-new `Genus` object that's just waiting to be saved. Thanks
to the `data_class` option, the form creates a new `Genus` object behind the scenes.
But how does it set the data?

When we got back an associative array, these field names - `name`, `speciesCount`
and `funFact` – could have been anything. But as soon as you bind your form to a
class, `name`, `speciesCount` and `funFact` need to match property names inside of
your class.

Actually, that's a *small* lie. These properties are private, so the form component
*can't* set them directly. In fact, it guesses a setter function for each field and
uses that: `setName()`, `setSpeciesCount` and `setFunFact`. Technically, you could
add a form field call `outOnAMagicalyJourney` as long as you had a method in your class
called `setOutOnAMagicalJourney`.

## Form Field Guessing!

Head back to your browser, highlight the URL and hit enter. This just made a GET,
which skipped form processing and just rendered things.

Let's add a few more field we need: like `subFamily`. Hey, we're even getting auto-complete
now: PhpStorm knows `Genus` has a `subFamily` property!

Also add `isPublished` - that should eventually be a checkbox - and `firstDiscoveredAt` -
that will need to be some sort of date field. Cool, try it out!

Huge error!

> Catchable fatal error: object of class SubFamily could not be converted to string.

Okay: that's weird. What's going on?

Until now, it looks like Symfony renders every field as an input text field by default.
But that's not true! there's a lot more coolness going on behind the scenes!

In reality, the form system looks at each field and tries to *guess* what type of
field it should be. For example, for `subFamily`, it sees that this is a `ManyToOne`
relationship to `SubFamily`. So, it tries to render this as a select menu of sub families.
That's amazing, because it's *exactly* what we want.

But, it needs to be able to turn a `SubFamily` object into a string so it can render
the text for each option in the select. That's the source of the error.

To help it, add a `public function __toString()` to the `SubFamily` class.

Refresh again!

Look at this! A free dropdown with almost no work. It also noticed that `isPublished`
should be a checkbox because that's a `boolean` field in Doctrine. And since `firstDiscoveredAt`
is a date, it rendered it with year-month-day drop-down boxes. Now, those three
boxes are *totally* ugly and we'll fix it later, but isn't it cool that it's *guessing*
the right field types?

Fill out the form again super-realistic data and submit. Woh! One more error:

> Neither the property `isPublished` nor does `getIsPublished` exist.

Remember how every form field needs a setter function on your class? Like name and
`setName`? Every field *also* needs a *getter* function - like `getIsPublished()`
or one of these other variations. 

This was my bad: when I set this up, I added an `isPublished` property, a `setIsPublished`
method, but no getter! I'll use the Code->Generate menu - or Command+N - to generate
that getter.

Refresh! It dumps the `Genus` object of course, but check out the `subFamily` field!
It's not the SubFamily *id* - the form field took the submitted id, queried the
database for the `SubFamily` object and set *that* on the object. That's HUGE.

We're ready to save this!
