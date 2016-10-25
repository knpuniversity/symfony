# Embedded Form Collections

Now that we've changed our genus scientist to have a year studied field in the middle, I'm not sure that this form interface with checkboxes really make sense anymore. I mean, if I want to show that a user has studied a genus, I need to select a user, but I also need to tell the system how many years they have studied. It's not as simple as just checking a box anymore, so how do we want this to look? Well, I'll tell you one possibility, the one possibility that works well with Symfony's form system, and that is a number of different subforms down here, one for each user that studies this genus. In each subform, we would be able to select the user from a dropdown and then fill in how many years they studied.

If we had three scientists for this genus, we'd have three little forms down here, each with a dropdown to the specific user, and the number of years they've studied in a textbox. As we build this, we're even going to have the ability to add and remove those dynamically with JavaScript. Let's get started on this.

The first thing we need to do is actually build a form class which represents just that little embedded form. Inside your Form directory, I'll do command N, select a new form, and let's call it GenusScientistEmbeddedForm. I'll remove the getName method because that's not needed anymore. In configureOptions, do resolver, arrow, setDefaults and do a classic data_class set to GenusScientist::class.

See this form is going to be embedded into our main genus form, but other than that fact, it looks and acts exactly like any form. It's bound to a genus scientist, which means that this form will give us a genus scientist object when we're finished.

Now for the form, we're going to need two fields, a field called user and another field called yearsStudied. We won't need a genus dropdown field because we're going to set that to automatically be this genus, this genus that we're editing right now. We don't need the user to select that.

Now the user field should be an Entity Type dropdown and I'm actually going to go over to our genus form type, and I'm actually going to steal all of these options that we have before because they're almost what we need for our genus type.

I'll set the type to EntityType and now I'll paste in the options. Make sure that you retype the r in user and hit tab so you get the use statement for that up top. Do the same thing for the userRepository. Now the only thing that's different is now this form we're going to be selecting just one user, so get rid of multiple and expanded.

This form is perfect, so how do we embed this into our main genus form type, which is this entire page? You do it with the CollectionType. Now first, remember our goal is to modify the genusScientist property on genus, so our field is still going to be called genusScientist, but I'm going to clear all these other options out and we're going to use the CollectionType. We're going to pass this one option called entry_type and set that to GenusScientistEmbeddedForm::class.

Before I talk about what that does, let's just go back and refresh this page to see how that field renders. Boom, check this out. For the four genus scientist that are in the database for this genus, it actually builds an embedded form for each of those. It's super ugly but we get that for free out of the box.

If you update one of these, like 26 to 27 and hit save, that does save perfectly. Now the first thing I want to do is actually clean this up because this looks awful.

Go into your Templates directory, App, Resources, Views, Admin, Genus, _form.html.twig. Now this genusScientist field is no longer actually a field. It's in array of fields. In fact, even those fields are actually themselves composed of subfields. What we have here is a fairly complex form tree, which is something we talked about in our form thing tutorial.

To render this in a little bit of more controlled way, I'm going to delete the form row. We'll add a little h3 here called Scientists, a little Bootstrap row, and then we'll say for genusScientistForm in genusForm.genusScientists. We're going to actually iterate over all four of those embedded forms. Same here. We'll add a little column and then we can call form_row genusScientistForm and that will render that entire embedded form. At the very least, this should get rid of this weird zero, one, two numbering stuff. We'll refresh. It already makes a lot more sense.

We still have that nasty zero, one, two, three rendering thing. The reason is because this genusScientistForm is actually an entire form full of many fields, and so it prints out a label for it, which is zero, one, two, three, and four, which is not helpful at all. What we're going to do instead is change that to form_errors so that it prints any errors that are global to that embedded form. Then we're just going to print out the two individual fields ourselves. So I mean, genusScientistForm.user and genusScientistForm.yearsStudied. Let's go back, refresh, and it's looking a lot better.

You know what we can't do? We can't actually remove this scientist from this collection and we can't add a new scientist. All we can do is edit information on the existing four scientists. That's not quite what we want, so we need to do a little bit more work.
