# Registration Form

Now we've covered authentication and, believe it or not, we've covered
authorization, so there's really nothing that you guys can't do now in
security. I do want to talk about one more thing and that is registration.
Registration technically has nothing to do with security. It's just about
creating a new user object and saving it to the database, but there are a few
interesting things, so I'm going to show it anyways.

Let's start like normal. I'm going to create a new control class called User
Controller. This will contain things like registration and if we know any other
stuff like reset password. Inside, I'll add a new register action URL/register.
Let's call this user_register. Make sure you have your [U ph 00:01:08]
statement or your at route.

This is going to be a normal form situation, so we're going to go into our form
directory, do command N, create a new symphony form. We'll call it user
registration form. Perfect. Delete kit name since we don't need that in
Symphony 3.

We'll start by calling resolver error set defaults. We're gong to pass in the
data class option, set to user, our user [inaudible 00:01:45] class, ::class.
Remember, we always bind our forms to classes. The only time we didn't do this
was with the login form, and that's just kind of it's own separate system.
[inaudible 00:02:01] and we actually only need two of them. We're going to have
an email field, which you will set to an email type, and then we're going to
have password field. Think about this. The property we actually want to set on
the user is not the password property but the plain password property. This is
going to be a password type, but actually in most registration situations, you
have the password twice. You don't have to do that. If you don't want to have
password type twice, we're going to use the repeated type. In the third
argument we're going to pass in another type option, and this is going to be
password type, ::class.

This will render two password boxes, and those two password boxes have to match
each other or else validation will automatically fail.

Cool. Form done. Our controller will say, form equals this, create form. Make
sure your extending symphonies base controller. You just use your registration
form, ::class. Return this, error render. You will render
user/register.html.twig. We'll pass in form, create, review.

As a short cut, I'll hover over the template here, option enter, create that
template, you guys know the drill. Extends base.html.twig over at the block
body. I'll give us just a little bit of mark up to get us started. Rendering
the form is exactly how it always is. Form, start, form. Form, end, form.
Inside, form, row, form.email. Then form_row,form.plain password. Because we
used the repeated type, this is actually going to render as two fields, form
plain password.first, and form plain password.second. That's something that's
special to that repeated type. It's pretty cool actually. Finally we'll add a
button, type equals submits. Give it a couple classes. Add my form, no validate
to disable [inaudible 00:04:52] validation and finally say, register.

That should do it. The last thing is that to get to the registration page,
let's add a little link right here on log in. Open up security log in at
html.twig and after our button let's add a little link for our user register.
Perfect. Refresh. Click register. There it is.

Again, just to prove that even though registration feels like security has
nothing to do with it, we can actually finish this. Except the label's first
and second, those are terrible. We have to fix those real quick. Remember, we
know how to do this. Second argument to form this row are variables, and we can
just customize the variable right there. The password and plain password.
Repeat password. Refresh. Looking better.

Finishing this again is the same as every form, but this has nothing to do with
security. Make sure you have the request argument, type hinted, and then do
your normal form arrow handle request, pass the request, and the immediately we
can say form, if form arrow is valid. Make sure that validation is passed. Also
make sure that the form is actually submitted. In other words, if this was a
post-request.

If you watched my form tutorial, you may have seen me also do another thing
there where I say, if form is submitted, but is valid, it takes care of that
automatically. Inside it says user equals form get data. We know this is going
to be a user object, so I'll add a little in line documentation to help
[inaudible 00:07:25]and then we'll get the EM equals this get document get
manager. Then EM arrow equal user. And EM arrow flush.

Finally what do we always do after a successful form registration? We set up
flash, this arrow.flash. That success key that we already set up in a previous
course to render in our base layout. We'll say, welcome user.get email.
Finally, let's redirect, at least for right now, the home page route. That's it.

Try this out. Weaver Ryan+15@gmail.com. Password foo. And other than my typo,
you submit. It works. Notice it didn't automatically log me in as a user.
That's something we're going to handle in a second, but hey, registration. It's
a form. It's pretty easy.
