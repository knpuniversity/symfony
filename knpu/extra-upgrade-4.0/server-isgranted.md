# The Server & New IsGranted

Time to try our app! First, in `.env`, change the database name to `symfony3_tutorial`,
or whatever the database name was called when you *first* setup the project. Now
when we run `doctrine:migrations:status`... yes! We have a full database!

## Installing the Server

Let's start the built-in web server:

```terminal
./bin/console server:run
```

Surprise!

> There are no commands defined in the "server" namespace.

Remember: with Flex, you opt *in* to features. Run:

```terminal
composer require server
```

When it finishes, run:

```terminal
./bin/console server:run
```

Interesting - it started on `localhost:8001`. Ah, that's because the *old* server
is still running and hogging port 8000! And woh! It's *super* broken: we've removed
a *ton* of files it was using. Hit Ctrl+C to stop the server. Ah! It's so broken
it doesn't want to stop! It's taking over! Close the angry terminal!

Start the server again:

```terminal
./bin/console server:run
```

It still starts on port 8001, but that's fine! Go back to your browser and load
`http://localhost:8001`. Ha! It works! Check it out: Symfony 4.0.1.

Surf around to see if everything works: go to `/genus`. Looks great! Now
`/admin/genus`. Ah! Looks terrible!

> To use the @Security tag, you need to use the Security component and the
> ExpressionLanguage component.

## The New @IsGranted

Hmm. Let's do some digging! Open `src/AppBundle/Controller/Admin/GenusAdminController.php`.
Yep! Here is the `@Security` annotation from FrameworkExtraBundle. The string we're
passing to it is an *expression*, so we need to install the ExpressionLanguage.

But wait! I have a better idea. Google for SensioFrameworkExtraBundle and find its
[GitHub page](https://github.com/sensiolabs/SensioFrameworkExtraBundle). Click on
releases: the latest is 5.1.3. What version do we have? Open `composer.json`: woh!
We're using version *3*! Ancient!

Let's update this to `^5.0`. Then, run:

```terminal
composer update sensio/framework-extra-bundle
```

to update *just* this library. Like with any major upgrade, look for a CHANGELOG
to make sure there aren't any insane changes that will break your app.

So... why are we upgrading? So glad you asked: because the new version has a feature
I *really* like! As soon as Composer finishes, go back to `GenusAdminController`.
Instead of using `@Security`, use `@IsGranted`.

This is *similar*, but *simpler*. For the value, you *only* need to say: `ROLE_MANAGE_GENUS`.

Try it - refresh! Yes! We're sent to the login page - that's good! Sign in with
password `iliketurtles`.

At this point... we're done! Unless... you want to move all of your classes from
`AppBundle` directly into `src/`. I do! And it's much easier than you might think.
