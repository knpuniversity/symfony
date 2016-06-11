# Validation Groups: Conditional Validation

Ready for the problem? Right now, we need the `plainPassword` to be required. But
later when we create an edit profile page, we *don't* want to make `plainPasword`
required. Remember, this is *not* saved to the database. So if the user leaves it
blank on the edit form, it just means they don't want to change their password.
And that should be allowed.

So, we need this annotation to only work on the registration form.

## Validation Groups to the Rescue!

Here's how you do it: take advantage of something called validation groups. On the
`NotBlank` constraint, add `groups={"Registration"}`.

This "Registration" is a string I just invented: there's no significance to it.

Without doing anything else, go back, hit register, and check it out! The error went
away. Here's what's happening: by default, all constraints live in a group called
`Default`. And when you form is validated, it validates all constraints in this
`Default` group. So now that we've put this into a different group called
`Registration`, when the form validates, it doesn't validate using this constraint.

To use this annotation *only* on the registration form, we need to make that
form validate everything in the `Default` group *and* the `Registration` group.
Open up `UserRegistrationForm` and add a second option to `setDefaults()`: `validation_groups`
set to `Defaults` - with a capital `D` and then `Registration`.

That should do it. Refresh: validation is back.

Ok team: one final mission: automatically authenticate the user after registration.
Because really, that's what our users want.
