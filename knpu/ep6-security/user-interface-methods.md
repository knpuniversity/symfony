# The UserInterface Methods (Keep some Blank!)

The `UserInterface` forces us to implement *5* methods. But check this out - I'm
going rogue - I'm only going to implement *2* of them: `getUsername()` and `getRoles()`.

## getUsername()

First `getUsername()`... is super-unimportant. Just return *any* unique user string
you want - a username, an email, a uuid - whatever. This is only used to help show
you *who* is logged in when you're debugging.

In our app, we users won't have a username - but they *will* have an email. Add a
`private $email` property then just use that in `getUsername()`: `return $this->username`.

Add a setter for that method - we'll need that eventually to create users.

## getRoles()

Cool: half-way done! Now: `getRoles()`. We'll talk roles later with authorization,
but these are basically permissions we want to give the user. For now, just return
one: `ROLE_USER`.

### What about getPassword(), getSalt() and eraseCredentials()?

So what about getPassword(), getSalt() and eraseCredentials()? Keep them blank.
Why? Because you *only* need these if your app is personally responsible for storing
and checking user passwords. In our app - to start - we're *not* going to have passwords:
we're just going to let anyone login with a single, central, hardcoded password.
But there are also real-world situations where your app doesn't manage passwords.
If you have one of these, feel ok leaving these blank.

## Setting up the User Entity

Now, in our application, we want to store users in the database. So let's set this
class up with Doctrine. Copy the `use` statement from `SubFamily` and paste it here.
Next, I'll put my cursor inside the class, press Command+N - or use the Code->Generate
method, and select "ORM class"

Now, add a `private $id` property and press command+N one more time. This time, select
"ORM annotation" and choose both fields.

Oh, and while we're here, let's add `unique=true` for the email field.

Perfect: we have a fully functional `User` class. Sure, it only has an `id` and
`email`, but that's plenty!

Since we just added a new entity, let's generate a migration for it:

```bash
./bin/console doctrine:migrations:diff
```

I'll copy the class, open it up quickly, and just make sure it looks right.

Yep, `CREATE user`: it looks awesome.

## Adding User Fixtures

The last step is to add some users to the database. Open our trusty `fixtures.yml`.
I'll copy the `SubFamily` section, change the class to `User` and give these keys
`user_1..10`. Then the only field is email. Set it to `weaverryan+<current()>@gmail.com`.

The `current()` function will return 1 through 10 as Alice loops through our set.
That'll give us weaverryan+1@gmail.com up to weaverryan+10@gmail.com. And if you
didn't know, Gmail ignores everything after a `+` sign, so these will all be delivered
to `weaverryan@gmail.com`. There's your Internet hack for the day.

Ok, let's roll! Don't forget to run the migration first:

```bash
./bin/console doctrine:migrations:migrate
```

And then load the fixtures:

```bash
./bin/console doctrine:fixtures:load
```

Hey hey: you've got users in the database. So let them login.
