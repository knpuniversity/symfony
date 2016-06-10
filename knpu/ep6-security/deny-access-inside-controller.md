# Denying Access in a Controller

I *do* use access controls to lock down big parts of my site, but, mostly, I handle
authorization inside my controllers.

## Deny Access (the long way)!

Comment out the `access_control`, and open up `GenusAdminController` so we can play
with this. To check if the current user has a role, you'll always use the same service:
the authorization checker. It looks like this:
`if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')`. So,
if we do *not* have `ROLE_ADMIN`, then `throw $this->createAccessDeniedException()`.
That message is just for us developers.

Head back and refresh the page. Access denied!

So what's up with that `createAccessDeniedException()` method? Be curious: hold command
to see that method. Ah, it *literally* just throws an special exception called
`AccessDeniedException`. It turns out - no matter *where* you are - if you want
to deny access for any reason, just throw this exception. Symfony will handle everything
else.

## Deny Access (the short way)!

But that was *way* too much typing. So, you'll probably just do this instead:
`$this->denyAccessUnlessGranted('ROLE_ADMIN')`. Ah, much better - and that's just
a shortcut for those same 3 lines.

## Denying Access with Annotations

Or, I have another idea! If you're loving annotations, you can use *them* to deny
access. Above the controller, add `@Security()` then type a little expression:
`is_granted('ROLE_ADMIN')`.

This has the *exact* same effect - it just shows a different message.

## Locking down and Entire Controller

But not matter how easy we make it, what we *really* want to do is lock down this
*entire* controller. Right now, we could still go to `/admin/genus/new` and have
access. We *could* repeat the security check in every controler... or we could do
something cooler.

Add the annotation *above* the class itself. As soon as you do that, all of these
endpoints are locked down.
