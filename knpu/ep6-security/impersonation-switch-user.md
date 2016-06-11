# Impersonation (Login as Someone Else)

Have you ever had a bug you couldn't reproduce? Nope, me either. Of course we have!
The worst is when a user reports a bug in their account... which would be *really*
easy to verify and debug... if *only* we could log and see what they're seeing.

Look, we've got too much work to do to debug this the hard way. We need to be able
switch to that user's account: we need to impersonate them.

## Activating switch_user

Setting up impersonation is super easy. In `security.yml`, under your firewall,
add a new key called `switch_user` set to `~` to activate the system.

## Back to the User Provider

Now, on any URL, you can add `?_switch_user=`  and then the username of whoever
you want to log in as. In our case, we want to login as weaverryan+5@gmail.com. Why
is that the email address in our case? This actually goes back to your user provider.

We're using the built-in `entity` user provider, *and* we told it that we want to
identify by the `email`. Before now, this setting was meaningless. If we changed that
to some other field, then we would actually identify ourselves by that up in the URL.

## Not Everyone Can Impersonate!

Hit enter to try switching users. OMG - access denied!

That makes sense - we can't just let *anybody* do this impersonation trick. Internally,
this feature checks for a very specific role called `ROLE_ALLOWED_TO_SWITCH`. But,
we don't have that.

Hey, no problem! Let's give this role to `ROLE_ADMIN` under `role_hierarchy`.

Cool! Try it out. It works! I mean, it doesn't work! Hmm, but it's *not* that security
error anymore - it just can't find the user: `weaverryan 5@gmail.com` You know what?
This is the because of the `+` sign in the email addresses - which represents a
space in URLs. Change that to the url-encoded plus sign: `%2B`.

Boom! Now we're surfing as `weaverryan+5@gmail.com`. Pretty awesome. Once you're
done, go back by adding `?_switch_user=_exit` to any URL. That's it! We're back
as our original user.

Switching users... yea, it's my favorite.
