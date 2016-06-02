# The All-Important User Class

Yo guys! You finally made it to the security course: you brave, brave souls. Whatever,
these days, security isn't scary - it's super fun! You've got traditional login forms,
Facebook authentication, GitHub authentication, and API authentication with JSON web
tokens, just to name a few. When you're doing something with security these days,
it's usually pretty darn fun. And we're going to learn enough so that you can implement
whatever crazy, insane security system you want.

But, the only way to secure your new security skills it to feel secure in my recommendation
that you *code along with me*. You guys know the drill: download the course code
unzip it and look for the `start/` directory. That'll have the same code that I have
here. Open up the README file to find all the setup details. At the end, you'll
open up a new tab and run:

```bash
bin/console server:run
```

to start the built-in web server.

## Authentication vs Authorization (Fight!)

Aquanauts assemble... to talk about security!

Security has two big parts. The first is *authentication* - this is all about
*who you are* - and we'll cover it first. Authentication is the tough stuff, and there's
*a lot* of variation - login forms, social media auth, API stuff - you get it.

The second big piece is *authorization*, and this doesn't care about who you are,
just whether or not you have fins. I mean, whether or not you have permission to
take an action. Authorization comes later.

## What about FOSUserBundle?

Before swim there, let's talk about a super-famous bundle: FOSUserBundle.
You might be wondering, should I use this? What does it do? Or, did I turn the
oven off?

First, we will *not* use this bundle, but it *is* great and you *did* turn the oven
off... probably.

It gives you a lot of free features that we will build by hand. But FOSUserBundle
does *not* give you any special "security" system - it's much less interesting than
that, in a good way! The bundle gives you just *two* things: (A) a User entity in
case you need to store users in the database and (B) a bunch of routes and controllers
for things like your login form, registration and reset password. Those are all
things you can easily build yourself... but if you need them, why not use the bundle?

Anyways, we *won't* use it, and that'll be the best path to learn how the security
system works. But when you finish, you might save yourself some time using FOSUserBundle.

## Create that User Class

Now, back to authentication. Here's our first goal: create a login form where the
user can sign in with their email and password. In this app, we'll load user info
from the database.

No matter *how* your users will authenticate, the first step is always the same:
create a `User` class.

In your `Entity` directory - create a new class called `User`. The *only* rule is
that this must implement a `UserInterface`. Add that.

I'll use Command+N - or the Code->Generate menu - and select "Implement Methods".
Select all the new methods. Oh, and let's move `getUsername()` to the top: it makes
more sense up there.

### Is User an Entity?

Notice I *did* put my `User` class inside of the `Entity` directory because eventually
we *will* store users in the database. But, that's not required: sometimes user details
are stored somewhere else - like a central authentication server. In those cases,
you *will* still have a `User` class, you just won't store it with Doctrine.

More on that as we go along.

Ok, we've got the empty user class: let's fill it in!
