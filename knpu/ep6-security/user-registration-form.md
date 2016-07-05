# Registration Form

That's it for security! We covered authentication and authorization. So, I'm not
really sure why I'm still recording.

Oh yea, I remember: let's create a registration form! Actually, this has nothing
to do with security: registration is all about creating and saving a User entity.
But, there are a few interesting things - call it a bonus round.

## Controller, Form, Check!

Start like normal: create a new controller class called `UserController` - for stuff
like registration and maybe future things like reset password:

[[[ code('6ea5f05842') ]]]

Inside, add `registerAction()` with the URL `/register`. Let's call the route `user_register`:

[[[ code('00f57a2749') ]]]

Make sure you have your `use` statement for `@Route`.

Next, this will be a nice, normal form situation. So click the `Form` directory,
open the new menu, and create a new Symfony Form. Call it `UserRegistrationForm`:

[[[ code('7dff78444f') ]]]

Brilliant! Delete the extra `getName()` method that's *super* not needed in Symfony 3.

Now, bind the form to `User`, with `$resolver->setDefaults()` and a `data_class`
option to set `User::class`:

[[[ code('2b16359eac') ]]]

Next, the fields! And we need two: first an `email` field set to `EmailType::class`:

[[[ code('5a4f2662e4') ]]]

Then, we *do* need a password field, but think about it: the property we want to
set on `User` is *not* actually the `password` property. We need to set `plainPassword`.
Add this. It'll be a password type. But, if you want the user to type the password
twice, use a `RepeatedType`. Then, in the third argument, pass the real type with
`type` set to `PasswordType::class`:

[[[ code('668b81dc20') ]]]

That'll render *two* password boxes. And if the values don't match, validation will
automatically fail.

## Rendering the Form

Form done! In the controller, start with `$form = $this->createForm()`. And of course,
make sure you're extending the Symfony base Controller! Then, pass this
`UserRegistrationForm::class`:

[[[ code('9bf133244d') ]]]

Go straight to the template: `return $this->render('user/register.html.twig')`
and pass it `$form->createView()`:

[[[ code('20a8dd32dd') ]]]

Ok, all standard!

As a short cut, I'll hover over the template, press `Option`+`Enter` and select
"Create Template".

You guys know the drill: `extends 'base.html.twig'` then override the `block body`.
I'll give us just a little bit of markup to get things rolling:

[[[ code('31483d83b4') ]]]

Rendering the form is exactly how it always is: `form_start(form)`, `form_end(form)`,
and inside, `form_row(form.email)`:

[[[ code('d9e7c30ae6') ]]]

Then `form_row(form.plainPassword)` - but because we used the `RepeatedType`, this will
render as *two* fields - so use `form.plainPassword.first` and `form_row(form.plainPassword.second)`:

[[[ code('ad71744bd6') ]]]

Cool, right?

Finally show off your styling skills by adding a `<button type="submit">` with some
fancy Bootstrap classes. Don't forget the `formnovalidate` to disable HTML5 validation.
And finally say, register:

[[[ code('60104222cf') ]]]

That oughta do it! Finish things by adding a link to this from the login page.
After the button, add a link to `path('user_register')`:

[[[ code('29ee43edc2') ]]]

Done! Refresh. Click "Register", and we're rendered.

### Fixing the Password fields

Ooh - except for the labels: "First" and "Second": those are terrible! We can fix
those real quick: pass a variables array to `first` with `label` set to `Password`.
For the second one: `Repeat Password`:

[[[ code('0afc7d595c') ]]]

Refresh. Looking good.

## Saving the User

Since the registration form has nothing to do with security, let's just finish this!
Type-hint the `Request` argument, and then do the normal `$form->handleRequest($request)`:

[[[ code('bd70c94ee0') ]]]

Then, `if($form->isValid())` - to make sure that validation is passed:

[[[ code('8b6b8bdc03') ]]]

In the forms tutorial, we also added `$form->isSubmitted()` in the `if` statement,
but you technically don't need that: `isValid()` checks that internally.

Inside the `isValid()`, set `$user = $form->getData()`:

[[[ code('d94bf05f33') ]]]

We know this will be a `User` object, so I'll plan ahead and add some inline PHP documentation
so I get auto-completion later. Add the `$em = $this->getDoctrine()->getManager()`,
`$em->persist($user)`, `$em->flush()`:

[[[ code('3a961c34d9') ]]]

Now, what do we *always* do after a successful form submit? We set a flash:
`$this->addFlash('success')` with `'Welcome '.$user->getEmail()`:

[[[ code('7d7c92e95c') ]]]

Finally, redirect - at least for right now - to the `homepage` route:

[[[ code('0baf5e14e1') ]]]

That's it.

Try the whole thing out: `weaverryan+15@gmail.com`, Password `foo`. Whoops, and if
we just fix my typo, and refresh again:

[[[ code('2f844f18fb') ]]]

It's alive!

But notice it did *not* automatically log me in. That's something we'll fix in a
second. But hey, registration. It's a form. It's easy! It's done.
