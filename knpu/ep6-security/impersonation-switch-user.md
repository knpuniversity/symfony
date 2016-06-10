# Impersonation (Login as Someone Else)

Picture this: you're rapidly working away on something *really* cool - using all
kinds of new tech and shiny, organized code. Suddenly - interruption! You get a message
from a user about a bug: something *that* should be in their account area is missing.
But when you log into your account, it looks fine!

This a crossroads: either you dismiss this as user error - which it probably is - 
and continue working on your awesome feature - that they will *love* - *or* you
stop, start hunting for a mysterious bug that you can't see, and aren't convinced
actually exists.

This sucks. If you could *just* log in to their account, you could see what's *really*
going on. So, let's do that and fix this bug fast. This trick is called impersonation.

## How Impersonation Works

Here's the idea. You get a message that say a certain user is seeing a bug on
the site in their account area, or they're not seeing a link that you're
looking to. What you really want to do is just log in as that user, and see
what they're seeing. That's absolutely possible. Go onto your firewall, and add
a new key called Switch_User, and set it to tilde to activate that system.

Now, on any page, you can say ?_Switch_User= and then the username of whoever
you want to log into. In our case, weaverryan+5@gmail.com. Why is that the
email address in our case? This actually goes back to your user provider
system. We're using the built in entity user provider, and we told it that we
want to identify by the email. This is the first time that this is actually
coming into play. If we change that to something else, then we would actually
identify ourselves by that up here.

If we hit enter though, access denied, because of course we can't let anybody
in the system do this. Internally, this feature checks for a very specific role
called Role Allowed To Switch. Our user needs to have that role in order to do
this. That's no problem, because we have this role hierarchy, Role_Admin should
be able to do anything. Role_Allowed_To_Switch. Then go back, refresh, and it
almost works. Notice it's not a security problem anymore, it just says
weaverryan space 5@gmail.com not found. This is just because I have the silly
pluses inside of my email addresses, so this is looking like a space. I need to
URL encode that, which is %3B. %3B is the URL encoded version of the plus
symbol.

If we change that plus to %2B, boom, that switches us. We are now surfing
around as weaverryan+5@gmail.com. Pretty awesome. Once you're done, you can go
back with _Switch_User=_Exit . It's a special username, and then we're back as
our user. Role_Allow_To_Switch, one of my favorite things.
