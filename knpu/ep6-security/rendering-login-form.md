# Rendering that Login Form

Time to build a login form. And guess what? This page is *no* different than every
other page: we'll create a route, a controller and render a template.

For organization, create a new class called `SecurityController`. Extend the normal
Symfony base `Controller` and add a `public function loginAction`. Setup the URL
to be `/login` and call the route `security_login`. Make sure to auto-complete
the `@Route` annotation so you get the `use` statement up top.

Cool!

Every login form looks about the same, so let's go steal some code. Google for
"Symfony security form login" and Find a page called
[How to Build a Traditional Login Form](http://symfony.com/doc/current/cookbook/security/form_login_setup.html).

## Adding the Login Controller

Find their `loginAction`, copy its code and paste it into ours. Notice, one thing
is immediately weird: there's no form processing code inside of here. Welcome to
the strangest part of Symfony's security. We will build the login form here, but
some *other* magic layer will actually handle the form submit. We'll build that
layer next.

But thanks to this handy `security.authentication_utils` service, we can at least
grab any authentication error that may have just happened in that magic layer as
well as the last username that was typed in, which will actually be an email address
for us.

## The Login Controller

To create the template, hit Option+enter on a Mac and select the option to create
the template. Or you can go create this by hand.

You guys know what to do: add `{% extends 'base.html.twig' %}`. Then, override
`{% block body %}` and add `{% endblock %}`. I'll setup some markup to get us started.

Great! This template *also* has a bunch of boilerplate code, so copy that from the
docs too. Paste it here. Update the form action route to `security_login`.

Well, it ain't fancy, but let's try it out: go to `/login`. There it is, in all its
ugly glory.

## What, No Form Class?

Now, I bet you've noticed something else weird: we are *not* using the form system:
we're building the HTML form by hand. And this is *totally* ok. Security is strange
because we will *not* handle the form submit in the normal way. Because of that,
most people simply build the form by hand: you can do it either way.

But... our form is *ugly*. And *I* know from our forms course, that the form system
is already setup to render using Bootstrap-friendly markup. So if we *did* use a
real form... this would instantly be less ugly.

## Ok, Ok: Let's add a Form Class

So let's do that: in the `Form` directory, create a new form class called `LoginForm`.
Remove `getName()` - that's not needed in Symfony 3 - and `configureOptions()`. This
is a rare time when I *won't* bother binding my form to a class.

***TIP
If you're building a login form that will be used with Symfony's native `form_login`
system, override `getBlockPrefix()` and make it return an empty string. This will
put the POST data in the proper place so the `form_login` system can find it.
***

In `buildForm()`, let's add two things, `_username` and `_password`, which should be
a `PasswordType`. You can name these fields anything, but `_username` and `_password`
are common in the Symfony world. Again, we're calling this `_username`, but for us,
it's an email.

Next, open `SecurityController` and add `$form = $this->createForm(LoginForm::class)`.
*And*, if the user *just* failed login, we need to pre-populate their `_username`
field. To pass the form default data, add a second argument: an array with `_username`
set to `$lastUsername`.

Finally, skip the form processing: that will live somewhere else. Pass the form
into the template, replacing `$lastUsername` with `'form' => $form->createView()`.

## Rendering the Form in the Template

Open up the template, Before we get to rendering, make sure our eventual error message
looks nice. Add `alert alert-danger`.

Now, kill the *entire* form and replace it with our normal form stuff: `form_start(form)`,
`from_end(form)`, `form_row(form._username)` and `form_row(form._password)`.

Don't forget your button! `type="submit"`, add a few classes, say `Login` and get
fancy with a lock icon.

We did this *purely* so that Ryan could get his form looking less ugly. Let's see
if it worked. So much better!

Oh, while we're here, let's hook up the `Login` button on the upper right. This lives
in `base.html.twig`. The login form is just a normal route, so add `path('security_login')`.

Refresh, click that link, and here we are.

Login form complete. It's finally time for the *meat* of authentication: it's time
to build an *authenticator*.
