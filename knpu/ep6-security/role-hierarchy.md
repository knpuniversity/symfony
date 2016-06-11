# Role Hierarchy

Our site will eventually have many different sections that will need to be accessed
by many different *types* of aquanaut users.

Maybe the genus admin section should only be visible to marine biologists and super
admins, while only the "management aquanauts" can see some future edit user section.
Oh, and and of course, we programmers should be able to see everything... because
let's face it - we always give ourselves access.

What's the best way to organize this? When you protect a section, instead of checking
for something like `ROLE_ADMIN` or `ROLE_MANAGEMENT` - which describes the *type*
of person that will have access, you might instead use a role that describes *what*
is being accessed. In this case, we could use something like `ROLE_MANAGE_GENUS`.

Why? The advantage is that you can very quickly give this role to *any* user in the
database in order to allow them access to *this* section, but no others. If you plan
ahead and do this, it'll give you more flexibility in the future.

## A lot of Roles: A lot of Management

It's the perfect setup! Until you put it into practice. Because now, when you launch
a *new* section that requires a *new* role - `ROLE_OCTOPUS_PHOTO_MANAGE` - the super
admins and programmers *won't* have access to it until you manually add this role
to all of those users. That's lame.

Of course, you *can* solve this with that group system we talked about earlier, but
that's usually overkill. And, there's a simpler way.

## Role Hierarchy

In `security.yml`, let's take advantage of something called role hierarchies. It's
simple, it's awesome!. Add a new key called `role_hierarchy` and, below that, set
`ROLE_ADMIN: [ROLE_MANAGE_GENUS]`. In other words, if anybody has `ROLE_ADMIN`, automatically
give them `ROLE_MANAGE_GENUS`. Later, when you launch the new Octopus photo admin
area, just add `ROLE_OCTOPUS_PHOTO_MANAGE` here and be done with it.

To see it in action, comment it out temporarily. Now, head to `/admin/genus`. Access
denied! No surprise. Uncomment the role hierarchy and try it again. Access granted!

The strategy is this: first: lock down different sections using role names that describe
*what* it's protecting - like `ROLE_OCTOPUS_PHOTO_MANAGE`. Second, in `security.yml`,
create group-based roles here - like `ROLE_MARINE_BIOLOGIST` or `ROLE_MANAGEMENT` -
and assign each the permissions they should have. With this setup, you should be
able to give most users just *one* role in the database.

Of course, don't bother doing anything of this if your app is simple and will have
just one or two different types of users.

Ok, now that we know how to give each user the *exact* access they need, let's find
out how to *impersonate* them.
