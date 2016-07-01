# The LoginFormAuthenticator

To use Guard - no matter *what* crazy authentication system you have - the first
step is always to create an authenticator class. Create a new directory called `Security`
and inside, a new class: how about `LoginFormAuthenticator`:

[[[ code('9efe721a03') ]]]

The only rule about an authenticator is that it needs to extend `AbstractGuardAuthenticator`.
Well, not totally true - if you're building some sort of login form, you can extend
a different class instead: `AbstractFormLoginAuthenticator` - it extends that other
class, but fills in some details for us.

Hit `Command`+`N` - or go to the "Code"->"Generate" menu - choose "Implement Methods" and
select the first three:

[[[ code('cb05cfd2f2') ]]]

Then, do it again, and choose the other two:

[[[ code('f4a4483a89') ]]]

That was just my way to get these methods in the order I want, but it doesn't matter.

## How Authenticators Work

When we're finished, Symfony will call our authenticator on *every single request*. Our
job is to:

1. See if the user is submitting the login form, or if this is just some random
   request for some random page.
2. Read the username and password from the request.
3. Load the User object from the database.

## getCredentials()

That all starts in `getCredentials()`. Since this method is called on *every* request,
we *first* need to see if the request is a login form submit. We setup our form so
that it POSTs right back to `/login`. So if the URL is `/login` and the HTTP method
is `POST`, our authenticator should spring into action. Otherwise, it should do nothing:
this is just a normal page.

Create a new variable called `$isLoginSubmit` Set that to `$request->getPathInfo()` -
that's the URL - `== '/login' && $request->isMethod('POST')`:

[[[ code('23e75d0cc3') ]]]

If both of those are true, the user has just submitted the login form.

So, `if (!$isLoginSubmit)`, just `return null`:

[[[ code('b0e43a9e18') ]]]

If you return `null` from `getCredentials()`, Symfony skips trying to authenticate the user
and the request continues on like normal.

### getCredentials(): Build the Form

If the user *is* trying to login, our *new* task is to fetch the username & password
and return them.

Since we built a form, let's let the form do the work for us.

Normally in a controller, we call `$this->createForm()` to build the form:

[[[ code('047e95cc70') ]]]

In reality, this grabs the `form.factory` service and calls `create()` on it.

## Dependency Inject form.factory (FormFactory)

So how can we create a form in the authenticator? Use dependency injection to inject
the `form.factory` service.

Add a `__construct()` method with a `$formFactory` argument:

[[[ code('4682ab61e1') ]]]

Now, I like to type-hint my arguments, so let's just guess at the service's class name
and see if there's one called `FormFactory`. Yep, there's even a `FormFactoryInterface`!

[[[ code('adb8cd4f44') ]]]

That's probably what we want. I'll press `Option`+`Enter` and select "Initialize Fields"
to set that property for me:

[[[ code('fa62866ad1') ]]]

If you're still getting used to dependency injection and that all happened too fast,
don't worry. We know we want to inject the `form.factory` service, so I guessed its
class for the type-hint, which is optional. You can always find your terminal and run:

```bash
./bin/console debug:container form.factory
```

to find out the *exact* class to use for the type-hint. We *will* also register this
as a service in `services.yml` in a minute.

## Return the Credentials

Back in `getCredentials()`, add `$form = $this->formFactory->create()` and pass it
`LoginForm::class`:

[[[ code('a5145e0478') ]]]

Then - just like always - use `$form->handleRequest($request)`:

[[[ code('5e576da69f') ]]]

Normally, we would check if `$form->isValid()`, but we'll do any password checking
or other validation manually in a moment. Instead, just skip to `$data = $form->getData()`
and `return $data`:

[[[ code('9c7e1e528b') ]]]

Since our form is not bound to a class, this returns an associative array with
`_username` and `_password`. And that's it for `getCredentials()`. If you return
*any* non-null value, authentication continues to the next step.
