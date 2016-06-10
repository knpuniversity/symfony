# Dynamic Roles

Denying access is great... but we still have a `User` class that gives *every* user
the same, hardcoded role: `ROLE_USER`. And maybe that's enough for you. But, if you
*do* need the ability to assign different permissions to different users, then we've
gotta go a little further.

Let's say that in *our* system, we're going to give different users different roles.
How do we do that? Simple! Just create a `private $roles` property that's an array.
Give it the `@ORM\Column` annotation and set its type to `json_array`.

This is *really* cool because the `$roles` property will hold an *array* of roles,
but when we save, Doctrine will automatically `json_encode` that array and store
it in a *single* field. When we query, it'll `json_decode` that back to the array.
What this means is that we can store an array inside a single column, without ever
worrying about the JSON encode stuff.

## Returning the Dynamic Roles

In `getRoles()`, we can get dynamic. First, set `$roles = $this->roles`. Second,
there's just *one* rule that we need to follow about roles: every user must have
at least *one* role. Otherwise, weird stuff happens.

That's no problem - just make sure that *everyone* at least has `ROLE_USER` by saying:
`if (!in_array('ROLE_USER', $roles))`, then add that to `$roles`. Finally, `return $roles`.

Oh, and don't forget to add a `setRoles()` method!

## Migration & Fixtures

Generate the migration for the new field:

```bash
bin/console doctrine:migrations:diff
```

We should double-check that migration, but let's just run it:

```bash
bin/console doctrine:migrations:migrate
```

Finally, give some roles to our fixture users! For now, we'll give everyone the same
role: `ROLE_ADMIN`.

Reload the fixtures!

```bash
bin/console doctrine:fixtures:load
```

Ok,  let's go see if we have access! Ah, we got logged out! Don't panic: that's because
our user - identified by its id - was just deleted from the database. Just log
back in.

So nice - it sends us *back* to the original URL, we have *two* roles and we have
access. Oh, and in a few minutes - we'll talk about another tool to really make
your system flexible: role hierarchy.


## So, how do I Set the Roles?

But now, you might be asking me?

> How would I actually change the roles of a user?

I'm not sure though... because I can't actually hear you. But if you *are* asking
me this, here's what I would say:

`$roles` is just a field on your User, and so you'll edit it like *any* other field:
via a form. This will probably live in some "user admin area", and you'll use the
`ChoiceType` field to allow the admin to choose the roles for every user:

```php
$builder->add('roles', ChoiceType::class, [
    'multiple' => true,
    'expanded' => true, // render check-boxes
    'choices' => [
        'Admin' => 'ROLE_ADMIN',
        'Human Resources' => 'ROLE_HR',
        // ...
    ],
]);
```

If you have trouble, let me know.

## What about Groups?

Oh, and I think I just heard one of you ask me:

> What about groups? Can you create something where Users belong to Groups, and
> those groups have roles?

Totally! And FOSUserBundle has code for this - so check it out. But really, it's
nothing crazy: Symfony just calls `getRoles()`, and you can create that array however
you want: like by looping over a relation or just giving people roles at random.
