# Authenticator: getUser, checkCredentials & Success/Failure

Here's the deal: if you return `null` from `getCredentials()`, authentication is
skipped. But if you return *anything* else, Symfony calls `getUser()`. And see that
`$credentials` argument? That's equal to what we return in `getCredentials()`.
In other words, add `$username = $credentials['_username]`.

I *do* continue to call this *username*, but in our case, it's an email address.
And for you, it could be anything - don't let that throw you off.

## Hello getUser()

Our job in `getUser()` is... surprise! To get the user! What I mean is - to *somehow*
return a `User` object. Since our Users are stored in the database, we'll query for
them via the entity manager. To get that, add a second constructor argument:
`EntityManager $em`. And once again, I'll use my option+enter shortcut to create
and set that property.

Now, it's real simple: return `$this->em->getRepository('AppBundle:User')->findOneBy()`
with `email => $email`.

Easy. If this returns `null`, guard authentication will fail and the user will see
an error. But if we *do* return a `User` object, then on we march! Guard calls
`checkCredentials()`.

## Enter checkCredentials()

This is our chance to verify the user's password if they have one or do any other
last-second validation. Return `true` if you're happy and the user should be logged
in.

For us, add `$password = $credentials['_password']`. Our users don't have a password
yet, but let's add something simple: pretend every user shares a global password.
So, `if ($password == 'iliketurtles')`, then return true.

Otherwise, return `false`: authentication will fail.

## When Authentication Fails? getLoginUrl()

That's it! Authenticators are always these three methods.

But, what happens if authentication fails? Where should we send the user? And what
about when the login is successful?

When authentication fails, we need to redirect the user back to the login form. That
will happen automatically - we just need to fill in `getLoginUrl()` so the system
knows where that is.

But to do that, we'll need the `router` service. Once again, go back to the top and
add another constructor argument for the router. To be super cool, you can type-hint
with the `RouterInterface`. Use the option+enter shortcut again to set up that property.

Down in `getLoginUrl()`, return `$this->router->generate('security_login')`.

## When Authentication is Successful? 

So what happens when authentication is successful? It's awesome: the user is automatically
redirected back to the last page they tried to visit before being forced to login.
In other words, if the user tried to go to `/checkout` and was redirected to `/login`,
then they'll automatically be sent back to `/checkout` so they can continue buying
your awesome stuff.

But, in case they go *directly* to `/login` and there is no previous URL to send
them to, we need a backup plan. That's the purpose of `getDefaultSuccessRedirectUrl()`.

Send them to the homepage: `return $this->router->generate('homepage')`.

The authenticator is *done*. If you need even more control over what happens on error
or success, there are a few other methods you can override. Or check out our Guard
tutorial. Let's finally hook this thing up.

## Registering the Service

To do that, open up `app/config/services.yml` and register the authenticator as a
service. Let's call it `app.security.login_form_authenticator`. Set the class to
`LoginFormAuthenticator` and because I'm feeling super lazy, autowire the arguments.
We can do that because we type-hinted all the constructor arguments.

## Configuring in security.yml

Finally, copy the service name and open `security.yml`. To activate the authenticator,
add a new key under your firewall called `guard`. Add `authenticators` below that,
new line, dash and paste the service name.

As *soon* as we do that, `getCredentials()` will be called on every request and our
whole system should start singing.

Let's try it! Try logging in with `weaverryan+1@gmail.com`, but with the wrong password.

Beautiful! Now try the right password: `iliketurtles`.

## Debugging with intercept_redirects

Ah! Woh! It *did* redirect to the homepage as *if* it worked, but with a *nasty* error.
In fact, authentication *did* work, but there's a problem with fetching the User
from the session. Let me prove it by showing you an awesome, hidden debugging tool.

Open up `config_dev.yml` and set `intercept_redirects` to true. Now, whenever the
app is about to redirect us, Symfony will stop instead, and show us the web debug
toolbar for that request.

Go to `/login` again and login in with `weaverryan+1@gmail.com` and `iliketurtles`.
Check this out: we're *still* at `/login`: the request finished, but it did *not*
redirect us yet. And in the web debug toolbar, we *are* logged in as
`weaverryan+1@gmail.com`.

So authentication works, but there's some issue with storing our User in the session.
Fortunately, that's going to be really easy to fix.
