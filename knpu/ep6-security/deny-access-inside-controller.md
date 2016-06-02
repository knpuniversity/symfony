# Denying Access in a Controller

I *do* use access controls to lock down big sections of my site, but I handle most
of my authorization inside my controllers.

Comment out the `access_control`, and open up `GenusAdminController` so we can play
with things. When you need to check if current user has a role, it's as simple as
this: `if (!$this->get('')`, we're gong to be at series called
Security.authorizationchecker. It has exactly one method on it which is called,
is granted. We'll pass it, role_admin. If we do not have this role, then we're
going to throw this arrow, create access denied exception. You can give it any
message there. That's only going to be shown to us developers.

If you go back now and refresh this page, there it is. A couple of key things
here. The security authorization checker is the way you check security. If you
need to check security outside of the controller in the future, now you know
how to do it. The second thing is, this great access denied exception if I hold
command and click into it, it just literally throws a class called access
denied exception. If you ever needed the denied access anywhere in your system,
you can just throw that exception and it simply will take care of everything
else. You don't need to worry about whether or not the user is logged in or
not. If the user is not logged in, it will redirect them to the login page
instead of showing them that 403 page.

In reality, you won't type those 3 lines because you're going to be lazy and
you just type deny access unless granted role_admin and that does the exact
same thing. Or if you like annotations, you can get a little fancier than this.
Up above your controller, you can say at security and then you can type in an
expression. Is_granted is one of the most important functions you have inside
of expression. Role_at admin. That will work the exact same way. You just
re-message name changes here.

Of course the problem here is that we really want our entire controller locked
down, and right now we can still go to /admin and /genus/new so we need to
repeat this annotation or that line in the controller on every single
controller inside of here. You now the situation. Direct what I'm doing. If you
like the annotations is just putting above your class. As soon as you do that,
it locks down everything inside of that controller.

This is great, but we still have a user class which just still has a single,
hard coded role in it. If you're security system is that simple, that's fine.
Just make sure your user has at least one role at all times, but other than
that, it doesn't matter. Let's say in our system we're going to give different
users different roles. How do we do that? Very simple. Just create a private
roles property. We're going to persist this to doctrines, give it @RM/com and
we're going to have a JSON ready type. It's going to allow us to actually store
an array on this and it will turn into a JSON string database. We'll never know
that happens because doctrines will always make sure we are just dealing with
an array here. When I give roles, say roles equals this arrow roles. Remember I
said just make sure your user always has at least one role. If you have a user
with zero roles, weird thing s happen. I recommend always making sure you have
the role user. If not, in array, role_user, roles then pop that on there.
Return. Roles. Of course, we'll also need set roles function.

Lets generate the migration for this. Command console, doctrine, migration
diff, doctrines migration migrate. You can double check migration first before
running it if you want to. Finally we can update our fixtures with roles. Right
now we'll just give everyone the same role, role admin. Reload the fixtures. It
will log us out because we just deleted the user. Now we log back in. It
bounces us back to that URL and we have access because we have both roles.