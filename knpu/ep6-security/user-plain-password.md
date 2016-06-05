# Users Need Passwords (plainPassword)

I just found out that giving everyone the same password - `iliketurtles` - is apparently
*not* a great security system. Let's give each user their own password. Again, in
*your* security setup, you might not be responsible for storing and checking passwords.
Skip this if it doesn't apply to you.

In `User`, add a `private $password` that will eventually store the encoded password.
Give it the `@ORM\Column` annotation.

Now, remember the three methods from `UserInterface` that we left blank? It's finally
their time to shine. In `getPassword()`, return `$this->password`.

But keep `getSalt()` blank: we're going to use the bcrypt algorithm, which has a
built-in mechanism to salt passwords.

Use the Code->Generate menu to generate the setter for `password`. And next, go make
that migration:

```bash
bin/console doctrine:migrations:diff
```

I *should* check that file, but let's go for it:


```bash
bin/console doctrine:migrations:migrate
```

Perfect.

## Handling the Plain Password

Here's the plan: we'll start with a plain text password, encrypt it through the
bcrypt algorithm and store that on the `password` property.

How? The best way is to set the plain-text password on the User and encode it automatically
via a Doctrine listener when it saves.

To do that, add a new property on `User` called `plainPassword`. But wait! *Don't*
persist this with Doctrine: we will of course *never* store plain-text passwords.
This is just a temporary-storage place during a single request.

Next, at the bottom, use Command+N or the Code->Generate menu to generate the getters
and setters for `plainPassword`.

## Forcing User to look Dirty?

Inside `setPlainPassword()`, do one more thing: `$this->password = null`.

What?! Yep, this is important. Soon, we'll use a Doctrine listener to read the
`plainPassword` property, encode it, and update `password`. That means that `password`
*will* be set to a value before it actually saves: it won't remain `null`.

So why add this weird line if it basically does nothing? Because Doctrine listeners
are *not* called if Doctrine thinks that an object has *not* been updated. If you
eventually create a "change password" form, then the *only* property that will be
updated is `plainPassword`. Since this is *not* persisted, Doctrine will think the
object is "un-changed", or "clean". In that case, the listeners will *not* be called,
and the password will not be changed.

But by adding this line, the object will *always* look like it has been changed,
and life will go on like normal.

Anyways, it's a necessary little evil.

Finally, in `eraseCredentials()`, add `$this->plainPassword = null`. Symfony calls
this after logging in, and it's just a minor security measure to prevent the plain-text
password from being accidentally saved anywhere.

The `User` object is perfect. Let's add the listener.
