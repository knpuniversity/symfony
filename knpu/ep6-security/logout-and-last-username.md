# Logging out & Pre-filling the Email on Failure

Check this out: let's fail authentication with a bad password.

Ok: I noticed two things. First, we have an error. Great! But second, the form is *not*
pre-filled with the `email` address I just used. Hmm.

Behind the scenes, the authenticator communicates to your `SecurityController` by
storing things in the session. That's what the `security.authentication_utils` helps
us with. Hold command and open `getLastAuthenticationError()`. Ultimately, this reads
a `Security::AUTHENTICATION_ERROR` string key from the session.

And the same is true for fetching the last username, or email in our case: it reads
a key from the session.

Here's the deal: the login form is automatically setting the authentication error
to the session for us. But, it is *not* setting the last username on the session...
because it doesn't really know where to look for it.

No worries, fix this with `$request->getSession()->set()` and pass it the constant -
`Security::LAST_USERNAME` - and `$data['_username']`.

Now, try it again. Good-to-go!

## Can I Logout?

Next challenge! Can we logout? Um... right now? Nope! But that seems important! So,
let's do it.

Start like normal: In `SecurityController`, create a `logoutAction`, set its route
to `/logout` and call the route `security_logout`. 

Now, here's the fun part. Don't put *any* code in the method. In fact, throw a
`new \Exception` that says, "this should not be reached".

## Adding the logout Key

Whaaaat? Yep, our controller will do nothing. Instead, Symfony will intercept any
requests to `/logout` and take care of everything for us. To activate it, open `security.yml`
and add a new key under your firewall: `logout`. Below that, add `path: /logout`.

Now, if the user goes to `/logout`, Symfony will automatically take care of logging
them out. That's super magical, almost creepy - but it works pretty darn well.

So, why did I make you create a route and controller if Symfony wasn't going to use
it? Am I trying to drive you crazy!

Come on, I'm looking out for you! It turns out, if you don't have a route that matches
`/logout`, then the 404 page is triggered *before* Symfony has a chance to log
the user out. That's why you need this.

It should work already, but let's add a friendly logout link. In `base.html.twig`,
how can we figure out if the user is logged in? We're *about* to talk about that...
but what the heck - let's get a preview. Use `{% if is_granted('ROLE_USER') %}`.
Remember this role? We returned it from `getRoles()` in User - so *all* authenticated
users have this.

If they don't have this, show the login link. But if they do, show the logout link:
`path('security_logout')`.

Perfect!

Try the *whole* thing out: head to the homepage. We're anonymous right now.. so let's
login! Cool! And there's the logout link. Click it! Ok, back to anonymous. If you
need to control what happens after logging out, check the official docs on the logout
stuff.

Alright. Now, as much as I like turtles, we should *probably* give our users a real
password.
