# The Mysterious "User Provider"

Let's see that error again: change `intercept_redirects` back to false.

Refresh and re-post the form. Oof, there it is again:

> There is no user provider for AppBundle\Entity\User

What the heck is a user provider and why do we need one?

## What is a User Provider?

A user provider is one of the most misunderstood parts of Symfony's security. It's
an object that does just a *few* small jobs for you. For example, the user provider
is responsible for loading the `User` from the session and making sure that it's
up to date. In Doctrine, we'll want our's to re-query for a fresh `User` object to
make sure all the data is still up-to-date.

The user provider is also responsible for a few other minor things, like handling
"remember me" functionality and a really cool feature we'll talk about later called
"impersonation".

Long story short: you need a user provider, but it's not all that important. And
if you're using Doctrine, it's super easy to setup.

## Setting up the Entity User Provider

In `security.yml`, you already have a `providers` section - as in "user providers".
Delete the `in_memory` stuff and replace it with `our_users`: that's a totally meaningless
machine name - it could be anything. But below that, say `entity` and set it to
`{ class: AppBundle\Entity\User, property: email }`.

The `property` part is *not* something we care about right now, but we will use
and talk about it later.

But yea, that's it! Go back to `/login`. Right now, I am *not* logged in. But try
logging in again.

It's alive!!! We can finally surf around the site and stay logged in. Cool.

## Custom User Provider

In your app, if you're *not* loading users from the database, then you'll need to
create a custom user provider class that implements `UserProviderInterface`. Check
out the official docs in this case. But if you have any questions, let me know.
