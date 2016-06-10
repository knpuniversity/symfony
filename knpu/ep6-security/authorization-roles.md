# Authorization: access_control and Roles

Authentication is *done*. So how about we tackle the second half of security: authorization.
This is all about figuring out whether or not the user has access to do something.
For example, right now we have a fancy admin section, but probably not *everyone*
should have access to it.

## Denying with access_control

There are 2 main ways to deny access, and the simplest is right inside of `security.yml`.
It's called "access control". Move in 4 spaces - so that you're
at the same level as the `firewalls` key, but not inside of it. Add `access_control`,
new line, go out 4 more spaces and add `- { path: ^/admin, roles: ROLE_USER }`.

That path is a regular expression. So, if anyone goes to a URL that starts with
`/admin`, the system will kick them out *unless* they have `ROLE_USER`.

Let see it in action.  First, make sure you're logged out. Now, go to `/admin/genus`.
Boom! That was it! Anonymous users don't have *any* roles, so the system kicked us
to the login page.

***TIP
Our `FormLoginAuthenticator` is actually responsible for sending us to `/login`.
You can customize and override this behavior if you need to. If you use a built-in
authentication system, like `form_login`, then *it* may be responsible for this.
This functionality is called an "entry point".
***

Now, login. It redirects us back to `/admin/genus` and we *do* have access. Our
user *does* have `ROLE_USER` - you can see that if you click the security icon in
the web debug toolbar. Remember, that's happening because - in our `User` class -
we've hardcoded the roles: *every* user has a role that I made up: `ROLE_USER`.

## Many access_control

And at first, that's as complex as Symfony's authorization system gets: you give
each user some roles, then check to see if they have those roles. In a minute, we'll
make it so each user can have different roles.

But we're not *quite* done yet with `access_control`. We only have one rule, but
you can have *many*: just create another line below this and secure a different section
of your site. For example, maybe `^/checkout` requires `ROLE_ALLOWED_TO_BUY`.

There is one gotcha: Symfony looks for a matching `access_control` from top to bottom,
and stops as soon as it finds the *first* match. We won't talk about it here, but
you can use that fact to lock down *every* page with an `access_control`, and then
white-list the few public pages with `access_control` entries *above* that.

You can also do a few other cool things, like force the user to visit a part of your
site via `https`. If they come via `http`, they'll be redirected to `https`.

## When you Don't Have Access :(

Change the role to something we don't have, how about `ROLE_ADMIN`. Head back and
refresh!

Access denied! Ok, two important things.

First, roles can be anything: I didn't have to configure `ROLE_ADMIN` before using
it - I just made that up. The only rule about roles is that they must start with
`ROLE_`. There's a reason for that, and I'll mention it later.

Second, notice this is an access denied screen: 403, forbidden. *We* see this because
we're in development mode. But your users will see a different error page, which
you can customize. In fact, you can have a different error page for 403 errors, 404
errors and 500 errors. It's easy to setup - so just check the docs.

Access controls are *super* easy to use... but they're a bit inflexible, unless
you *love* writing complex, unreadable regular expressions. Next, let's look
at a more precise way to control access: in your controller.
