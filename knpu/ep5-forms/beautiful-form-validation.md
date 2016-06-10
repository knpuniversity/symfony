# Beautiful Form Validation

Guess what! Server-side validation is really, really fun. Google for Symfony validation,
and find the book chapter.

There is *one* weird thing about validation... which I *love*. Here it is: you don't
apply validation to your form. Nope, there will be *no* validation code inside of
`GenusFormType`. Instead, you add validation to the *class* that is bound to your
form. When the form is submitted, it automatically reads those validation rules
and uses them.

Validation is added with annotations. So copy the `use` statement from the code block,
find `Genus` and paste it on top:

[[[ code('b9649a6bf9') ]]]

## The Giant List of Constraints

Good start! Next, we'll add validation rules - called constraints - above each
property. On the left side bar, find the "Constraints" link.

Check out this menu of validation rules: `NotBlank`, `NotNull`, `Email`, `Length`,
`Regex`... so many things! Pretty much anything you can dream up is inside of this
list.

Let's start with an easy one: above the `name` property, add `@Assert\NotBlank`:

[[[ code('6be497def9') ]]]

Without doing anything else, refresh. Boom! Validation error. And, it looks nice.

Let's add some more. For `subFamily` - that should be required, so add `@NotBlank`:

[[[ code('f1eb96eb0a') ]]]

For `speciesCount`, add `@NotBlank` again:

[[[ code('0783df8947') ]]]

But in addition to that, we want `speciesCount` to be a positive number: we don't want
some funny biologist entering negative 10.

## Constraint Options

On the constraints list, there's one called `Range`. Check that out.

Ok cool: just like the form field types, you can pass options to the constraints.
The `Range` constraint has several: `min`, `max`, `minMessage` and `maxMessage`.
Add `@Assert\Range` with `min=0` and `minMessage="Negative species! Come on..."`:

[[[ code('254655350d') ]]]

Ok, let's finish up. It's ok if `funFact` is empty - so don't add anything there.
The same is true for `isPublished`: we *could* add a constraint to make sure this
is a boolean, but the sanity validation on the form already takes care of that.

Finally, let's make sure `firstDiscoveredAt` is also `NotBlank`:

[[[ code('ee2c9e1dd0') ]]]

Ok, refresh! Leave everything blank and put -10 for the number of species. I love
it!
