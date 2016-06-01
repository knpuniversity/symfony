# The LoginFormAuthenticator

To use Guard - no matter *what* crazy authentication system you have - the first
step is always to create an authenticator class. Create a new directory called `Security`
and inside of it, a new class: how about `FormLoginAuthenticator`.

The only rule about an authenticator is that it needs to extend `AbstractGuardAuthenticator`.
Well, not totally true - if you're building some sort of login form, you can extend
a different class instead: `AbstractFormLoginAuthenticator` - it extends that other
class, but is a bit more helpful.

Hit Command+N - or go to the Code->Generate menu - choose "Implement Methods" and
select the first three. Then, do it again, and choose the other two. That was just
my way to get these methods in the order I want, even though that doesn't matter.

## How Authenticators Work

Once we're done, Symfony will call our authenticator on *every single request*. Our
job is to:

1. See if the user has just submitted the login form.
2. Read the username and password from the request.
3. Load the User object from the database.

## getCredentials()

That all starts in `getCredentials()`. Since this method is called on *every* request,
we *first* need to see if the request is a login form submit. We setup our form so
that it POSTs right back to `/login`. So if the URL is `/login` and the HTTP method
is `POST`, our authenticator should spring into action. Otherwise, it should do nothing:
this is just a normal page.

Create a new variable called `$isLoginSubmit` Set that to `$request->getPathInfo()` -
that's the URL - `== '/login' && $request->isMethod('POST')`. If both of those are
true, the user has just submitted the login form.

So, `if (!$isLoginSubmit)`, just `return null`. If you return `null` from `getCredentials()`,
Symfony skips trying to authenticate the user and the request continues on like normal.

### getCredentials(): Build the Form

If the user *is* trying to login, our *new* task is to fetch the username & password
and return them from this method.

Since we built a form, let's let the form do the work for us.

In a controller, we call `$this->createForm(): to build the form. In reality, this
grabs the `form.factory` service and calls `create()` on it.

So how can we create a form in the authenticator? Just use dependency injection.
Add a `__construct()` method and let's see if there's a `FormFactory` class. Yep,
there's even a `FormFactoryInterface`! That's probably what we want. I'll press
option+enter and select "Initialize Fields" to set that property for me.

If you're still getting used to dependency injection and that all happened too fast,
don't worry. We know we want to inject the `form.factory` service, so I guessed its
class for the optional type-hint. You can always find your temrinal and run:

```bash
bin/console debug:container form.factory
```

to find out the *exact* class to use for the type-hint. We *will* also register this
service in `services.yml` - but let's finish coding first.

Back in `getCredentials()`, add `$form = $this->formFactory->create()` and pass it
`LoginForm::class`. Then - just like always - use `$form->handleRequest($request)`.

Normally, we would check if `$form->isValid()`, but we'll do any password checking
or other validation manually in a moment. Instead, just skip to `$data = $form->getData()`
and `return $data`.

Since our form is not bound to a class, this returns an associative array with
`_username` and `_password`. And that's it for `getCredentials()`. If you return
*any* non-null value, authentication continues.
