# Configuring the Encoder in security.yml

Let's set some plain passwords! Where? In our fixtures! Open up `fixtures.yml` and
scroll down. In theory, *all* we need to do is set the `plainPassword` property.
The rest should happen auto-magically.

Add `plainPassword: ` and we'll keep with `iliketurtles`, because I've gotten good
at typing that. And turtles are cool.

Change over to your terminal and load your fixtures:

```bash
bin/console doctrine:fixtures:load
```

Explosion!

> No encoder has been configured for AppBundle\Entity\User

This is basically Symfony's way of saying:

> Ryan, you didn't tell me *how* you want to encode the passwords. I can't
> read your mind - I'm just a PHP framework.

Remember how I kept saying we would encrpyt the passwords with bcrypt? Do you remember
actually configuring that anywhere? Nope! We need to do that.

Open `security.yml`. Add an `encoder` key, then `AppBundle\Entity\User: bcrypt`.
If you want, you can configure a few other options, but this is good enough.

*Now* Symfony knows how to encrypt our passwords. Try the fixtures again:

```bash
bin/console doctrine:fixtures:load
```

No errors! So, that *probably* worked. Let's use it!

## Checking the Encoded Password

In `LoginFormAuthenticator`, we can *finally* add some real password checking!
How? By using that same `UserPasswordEncoder` object.

Head back up to `__construct` and add a new `UserPasswordEncoder` argument. I'll
use my option+enter shortcut to setup that property for me. And because we're using
autowiring for this service, we don't need to change anything in `services.yml`.

Now, in `checkCredentials()`, replace the `if` statement with
`if ($this->passwordEncoder->isPasswordValid())` and pass that the `User` object
and the plain-text password. That'll take care of securely checking things.

Let's try it out: head to `/login`. Use `weaverryan+1@gmail.com` and `iliketurtles`.
We're in! Password system check.

Ok team, that's *it* for authentication. You can build your authenticator to behave
however you want, and you can *even* have multiple authenticators. Oh, and if you
*do* want to use any of the built-in authentication systems, like the `form_login`
key I mentioned earlier - that's totally fine. Guard authentication takes more work,
but has more flexibility. If you want another example, we created a cool JSON web
token authenticator in our Symfony REST series.

Now, let's start locking down the system.
