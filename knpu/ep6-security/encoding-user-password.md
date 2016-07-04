# Doctrine Listener: Encode the User's Password

In `AppBundle`, create a new directory called `Doctrine` and a new class called
`HashPasswordListener`:

[[[ code('083ffd614b') ]]]

If this is your first Doctrine listener, welcome! They're pretty friendly. Here's the idea:
we'll create a function that Doctrine will call whenever *any* entity is inserted or updated.
That'll let us to do some work before that happens.

Implement an `EventSubscriber` interface and then use `Command`+`N` or the "Code"->"Generate"
menu, select "Implement Methods" and choose the one method: `getSubscribedEvents()`:

[[[ code('5e4cedcdec') ]]]

In here, return an array with `prePersist` and `preUpdate`:

[[[ code('d77fcd63e2') ]]]

These are two event names that Doctrine makes available. `prePersist` is called
right before an entity is originally *inserted*. `preUpdate` is called right before
an entity is updated.

Next, add `public function prePersist()`:

[[[ code('1a2c23b827') ]]]

When Doctrine calls this, it will pass you an object called `LifecycleEventArgs`,
from the ORM namespace.

This method will be called before *any* entity is inserted. How do we know *what*
entity is being saved? With `$entity = $args->getEntity()`. Now, if this is *not*
an `instanceof User`, just return and do nothing:

[[[ code('57e62a6e67') ]]]

## Encoding the Password

Now, on to encoding that password.

Symfony comes with a built-in service that's really good at encoding passwords. It's
called `security.password_encoder` and if you looked it up on `debug:container`, its
class is `UserPasswordEncoder`. We'll need that, so add a `__construct()` function
and type-hint a single argument with `UserPasswordEncoder $passwordEncoder`. I'll hit
`Option`+`Enter` and select "Initialize Fields" to save me some time:

[[[ code('cb2df53b4b') ]]]

In a minute, we'll register this as a service.

Down below, add `$encoded = $this->passwordEncoder->encodePassword()` and pass it
the User - which is `$entity` - and the plain-text password: `$entity->getPlainPassword()`.
Finish it with `$entity->setPassword($encoded)`:

[[[ code('e7c2ff488f') ]]]

That's it: we are encoded!

## Encoding on Update

So now also handle update, in case a User's password is changed! The two lines that
actually do the encoding can be re-used, so let's refactor those into a private method.
To shortcut that, highlight them, press `Command`+`T` - or go to the "Refactor"->"Refactor this"
menu - and select "Method". Call it `encodePassword()` with one argument that's a
`User` object:

[[[ code('6e4f0a49d4') ]]]

***TIP
I didn't mention it, but you also need to prevent the user's password from being
encoded if plainPassword is blank. This would mean that the User is being updated,
but their password isn't being changed.
***

Super nice!

Now that we have that, copy `prePersist`, paste it, and call it `preUpdate`. You
might *think* that these methods would be identical... but not quite. Due to a quirk
in Doctrine, you have to tell it that you just updated the password field, or it
won't save.

The way you do this is a little nuts, and not that important: so I'll paste it in:

[[[ code('b73e87cf82') ]]]

## Registering the Subscriber as a Service

Ok, the event subscriber is perfect! To hook it up - you guessed it - we'll register
it as a service. Open `app/config/services.yml` and add a new service called
`app.doctrine.hash_password_listener`. Set the class. And you guys know by now that
I love to autowire things. It doesn't always work, but it's great when it does:

[[[ code('4e77c2928b') ]]]

Finally, to tell Doctrine about our event subscriber, we'll add a tag. This is something
we talked about in our services course: it's a way to tell the system that your service
should be used for some special purpose. Set the tag to `doctrine.event_subscriber`:

[[[ code('c822580824') ]]]

The system is complete. Before creating or updating any entities, Doctrine will
call our listener.

Let's update our fixtures to try it.
