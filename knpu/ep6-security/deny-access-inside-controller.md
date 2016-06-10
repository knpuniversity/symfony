# Denying Access in a Controller

I *do* use access controls to lock down big sections, but, mostly, I handle authorization
inside my controllers.

## Deny Access (the long way)!

Let's play around: comment out the `access_control`, and open up `GenusAdminController`.
To check if the current user has a role, you'll always use one service:
the authorization checker. It looks like this:
`if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')`. So,
if we do *not* have `ROLE_ADMIN`, then `throw $this->createAccessDeniedException()`.
That message is just for us developers.

Head back and refresh. Access denied!

So what's the magic behind that `createAccessDeniedException()` method? Find out:
hold command and click to open it. Ah, it *literally* just throws a special exception
called `AccessDeniedException`. It turns out - no matter *where* you are - if you need
to deny access for any reason, just throw this exception. Symfony handles everything
else.

## Deny Access (the short way)!

Simple, but that was too much work. So, you'll probably just do this instead:
`$this->denyAccessUnlessGranted('ROLE_ADMIN')`. Much better: that does the same
thing as before.

## Denying Access with Annotations

And, I have another idea! If you love annotations, you can use *those* to deny
access. Above the controller, add `@Security()` then type a little expression:
`is_granted('ROLE_ADMIN')`.

This has the *exact* same effect - it just shows us a different message.

## Locking down and Entire Controller

But no matter how easy we make it, what we *really* want to do is lock down this
*entire* controller. Right now, we could still go to `/admin/genus/new` and have
access. We *could* repeat the security check in every controller... or we could do
something cooler.

Add the annotation *above* the class itself. As soon as you do that, all of these
endpoints are locked down.

Sweet!
