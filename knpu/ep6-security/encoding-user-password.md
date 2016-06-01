# Doctrine Listener: Encode the User's Password

In `AppBundle`, create a new directory called `Doctrine` and a new class there called
`HashPasswordListener`. If this is your first Doctrine listener, welcome! They're
pretty friendly. Here's the idea: we'll create a function that Doctrine will call
whenever *any* entity is inserted or updated. That'll allow us to do some work before
that happens.

Implement an `EventSubscriber` interface and then use Command+N or the Code->Generate
menu, select "Implement Methods" and choose the one method: `getSubscribedEvents()`.

In here, return an array with `prePersist` and `preUpdate`: these are two event names
that are available with Symfony. `prePersist` is called right before an entity is
originally *inserted*. `preUpdate` is called right before an entity is updated.

Next, add `public function prePersist`. When Doctrine calls this, it will pass you
an object called `LifecycleEventArgs`, from the ORM namespace.

This method will be called before *any* entity is inserted. How do we know *what*
entity is being saved? Wit h`$entity = $args->getEntity()`. Now, if this is *not*
and `instanceof User`, just return and do nothing.

## Encoding the Password

Symfony comes with a built-in service that's really good at encoding passwords.





In order to encode the password, Symfony gives us a built in service to take
care of that called User Password Encoder. We're eventually going to register
this to the service. I'll make the constructor, use this user password encoder,
and then I'll hit option enter to initialize that field and save me a little
bit of time. Here, we'll say encoded equals this arrow password encoder arrow
encode password. Then we're going to pass it to the user, which is actually
entity, and then we're going to pass it the plain password, which we know is
going to be entity arrow get plain password. Perfect. Then, ultimately, we'll
say entity arrow set password. That's it. Encoded.

The document will continue saving, and it will save that password. Cool. This
is all we need for this, but let's also take care of free update. Free update's
going to be almost the same thing, so I'm going to select these two lines here,
go to command T for the Refactor This menu, put on the menu, and we're going to
have this create a new, private function called Encode Password. I get one
argument that is [type printed 00:07:58] the user class. You can see it's just
going to take those two lines and create a nice private function down here on
the bottom. You could have also done that by hand if you're not using [Page
restore 00:08:07].

Now we have that, copy prePersist, preUpdate, and they're almost the same. The
beginning's the same, the encode password's the same. There's just one little
hack you need in preUpdate which is due to a little doctrine port, what you
actually need to tell doctrine "I have updated this entity, so I need you to
actually look and notice the changes." This is only needed in preUpdate, and it
looks like this craziness. EM equals args get entity manager. Meta equals EM
arrow get class metadata, get class entity. Then, EM arrow get unit of work
arrow recompute single entity change set. Pass that to meta, and you pass that
the entity.

What that does is it tells doctrine to notice that you just changed the
password field so it'll save it. You leave out those last 3 lines, then your
new, encoded password won't actually get saved.

Event subscriber's perfect. The last step is to register this as a service and
hook it up so doctrine notices it. In AppConfig services.yml, we'll create a
new service called app.doctrine.hashpasswordlistener. Set up the class, of
course you guys know at this point I like to autowire things. Doesn't always
work, but it works in most cases, as you can see. Then, to tell doctrine about
our event subscriber, we're going to add a tag. I'm just using a little
shortcut I have set up for that. You'll say doctrine.event_subscriber, not
listener. We've set ours up as a subscriber, and that's it. The system's
complete.

Now that we have this happening automatically, we can go to our fixtures.yml
file and down where I have our users, we can just add one for plain password.
We'll keep using Iliketurtles. If all goes well, when we load our fixtures, it
should automatically create an encoded password and save it on the password
field for that password.

Let's flip over. We're on bin console doctrine fixtures load. This will not
work yet. Check this out. No encoder has been configured for AppBundle Entity
User. What this is basically saying is, "Ryan, you didn't tell me how you want
to encode the passwords." I keep saying we're going to use bcrypt, but there
are many ways to encode passwords, and something that you need to configure
with Symfony so it knows how to do it. This is really simple. It's in
security.yml. You just need to add an encoder scheme, followed by full name
space to your user class, and then which algorithm you want to use. If you
want, there are a couple other options you can pass to that, but that's good
enough.

I'll switch back, load the fixtures again. This time, no errors. That probably
worked, so let's try it. In login form authenticator, we can finally get rid of
our simple password checking. In order to ... What we want to do is compare
these submitted plain text password, encode it in the same way, and see if it
matches the value we have in the database. Fortunately, that same user password
encoder can check the password too.

Go back up to construct, type in user password encoder, I'll hold option enter
to initialize that field. Down here, we can replace this if statement with if
this arrow password encoder arrow is password valid, we'll pass it the user
object that will use it to fetch off the encoded password. Then, we pass it the
plain text password, and that will take care of everything else for us.

Let's try it out. Go to login. Get our user. Iliketurtles. There is is.
Password system check.
