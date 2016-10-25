# Embedded Validation

 ... Back to  /editor/genus.  Editor Genus, and then leave the Years Studied field blank for one your genus scientists, and BOOM. Huge error. Update Years Genus Scientist, set Years Studied to Null, and it says,  Years Studied cannot be null.  That's not an accident. In the Genus Scientist, you'll notice there's no  nullable = true,  so Years Studied is a required field in our database, but we're missing validation on our form for it.

 No problem, right? We'll just go into our genus class, I'll copy the as assert use statement, paste this in Genus Scientist. Then above Years Studied, we can say,  at not blank,  and that's it. Now, the Years Studied field should be required. Let's refresh the page, I'll empty that out again, enter, and ... Whoa. It still doesn't work.

 It's as if Symphony doesn't see the new assert validation constraint I've added to Genus Scientist. Why? Well, it turns out that our form is actually bound to a genus object, that's our top level object. By default, Symphony reads all of the annotations for validation from this class, but when it sees an embedded object, or a collection of embedded objects, it doesn't recursively go deeper and read the annotations off of Genus Scientist. It just stops.

 How can we tell Symphony,  I want you to also read the validation rules off of Genus Scientist?  The answer is a very unique annotation called at valid. That's it. Go back, refresh, and this time, we do get the validation error. Just make sure that you have that when you're using embedded forms or the collection type like we are.

 There's one other problem though. Let's say that we set this to aquanaut 3. Well, that's actually a duplicate of this one, and it doesn't really make sense for to have the same user listed as two different scientists, but if you save right now, it's all good. Aquanaut 3. Aquanaut 3. I want to add some validation to prevent that.

 This is actually pretty easy. On Genus Scientist, we're going to add a new annotation above the class, a rare constraint that goes above the class called unique entity. This takes a couple of options, like, fields equals, curly brace, then double quotes, genus, then user surrounded by double quotes. This says,  Don't allow there to be two records in the database that have the same genus and same user.  We'll give it a little message like,  This user is already studying this genus.  Perfect.

 Now, head back. They both still have Aquanaut 3, Aquanaut 3. Hit save, and it sends us back with the validation error, but the interesting thing is is that it has two validation errors, and there actually both at the top of the form, not down here in the bottom of the form where they'd be more useful. The reasons for this are honestly a little bit complicated. They have to do with our collection type and something called error bubbling. The fix for it is pretty easy, and that is after message to add another field called error path = user.

 Now, normally with the unique entity, if you were using ... If you had form for Genus Scientist that wasn't embedded, this error would show at the top of the form, and that would actually be okay, because we maybe were creating a new genus and were set to the right user. This says,  When this error occurs, I want you to attach it to the user field instead.

 When we refresh now, this actually fixes it and you can see the errors shows up in both places here to tell us that this is already a problem. If I change it to a different one, like Aquanaut 8, and save ... I'm going to change the other one, too, because we're actually in a weird state where this was already allowed to save to the database, so weird things happened. We changed both of them, it saves perfectly. If we try to change one of them back to a duplicate, now we get the one error. Awesome.
 
