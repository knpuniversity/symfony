# Automatically Login after Registration!

If I submitted this form right now, it would register me, but it would *not*
actually log me in... which is lame. Let's fix that.

This is *always* pretty easy, but it's *especially* easy because we're using
Guard authentication. Inside of `UserController`, instead of redirecting to the
home page: do this: `return $this->get()` to find a service called
`security.authentication.guard_handler`. It has a method on it called
`authenticateUserAndHandleSuccess()`. I'll clear the arguments and use multiple lines:

[[[ code('535f000503') ]]]

The first argument is the `$user` and the second is `$request`:

[[[ code('0f40e4c137') ]]]

The third argument is the authenticator whose success behavior we want to mimic.
Open up `service.yml` and copy the service name for our authenticator:

[[[ code('a104f6beb8') ]]]

In the controller, use `$this->get()` and paste the service ID:

[[[ code('d428025e16') ]]]

Finally, the last argument is something called a "provider key". You'll see that
occasionally - it's a fancy term for the name of your firewall:

[[[ code('4f09d903a7') ]]]

This name is almost *never* important, but it actually is in this case. We'll say `main`:

[[[ code('1ed9f7d909') ]]]

And we're done!

## The Bonus Superpower

Now, this will log us in, but it *also* has a bonus super-power. Right now, we're
anonymous. So let's try to go to `/admin/genus`. Of course, it bounces us to the
login page. That's fine - click to register. Use `weaverryan+20@gmail.com`,
add a password and hit enter.

Check this out. Well, ignore the access denied screen.

First, it *did* log us in. And *second*, it redirected us back to the URL we were
trying to visit before we were sent to the login page. This is *really* great because
it means that if your user tries to access a secure page - like your checkout form -
they'll end up *back* on the checkout form after registration. Then they can
keep buying your cool stuff.

Of course, we see the access denied page because this user only has `ROLE_USER` and
the section requires `ROLE_MANAGE_GENUS`.

## Signing Off

Ok guys, that's it. Yes, you *can* get more complicated with security, especially
authentication. And if you need to check permissions that are *object* specific - like
I can edit only genuses that I created - then check out Symfony's awesome voter system.
Hey, we have a [course][1] on it!

But for the most part, you guys have the tools to do really incredible things. So
go out there, build something awesome and tell me about it.

Seeya next time!


[1]: https://knpuniversity.com/screencast/symfony-voters
