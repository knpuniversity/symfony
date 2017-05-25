# Autowiring Deprecations

Aliases are a very, very powerful way for you to choose what service gets wired
for which type hint. Now down at the bottom, you see a little yellow thing here
that says 10 deprecation warnings. I'm actually going to click that then go to
deprecations. These are all the ways in which my code is using deprecated
functionality, and things I need to fix before I upgrade it to the Symfony 4.0.
There's a couple of these that are really important to us, specifically this
one here, "Autowiring services based on the types they implement is deprecated
since Symfony 3.3 and won't be supported in version 4.0. You should rename or
alias security.user_password_encoder.generic to long class UserPasswordEncoder
instead." Woah, so what is that saying?

It's saying that somewhere we are type hinting user_password_encoder, and
there's no service that exists inside of the container with that exact ID. So
autowiring looked across all of the services in the container and found one
service, this one right here, that has that class name and it wired that one
for us. That is deprecated, that's a little more magic than we wanted in
Symfony, so we've removed it. So it says, "Fine, that's great. You can use the
UserPasswordEndcoder type hint going forward, but we want you to alias it
explicitly to this service instead of relying on this magic."

So this case you can do that or the other thing we can do, is we can actually
change this to the proper type hint. Here's what I mean, you're already
familiar with Vim console, debug container, which shows you all the public
services inside of the container and it shows you their service IDs. But guess
what, service IDs are much less important in Symfony 3.3 because we are always
autowiring things by their type. We introduce a new option called --types and
this gives you a list of all of the valid type hints that you can use in the
system to autowire things. This is awesome. If you search for encoder, you'll
actually find there's one called UserPasswordEncoderInterface. So we are
apparently type writing user_password_encoder if we just change that to
UserPasswordEncoderInterface, we are good.

So I'm going to git grep for UserPasswordEncoder and you can see that it's used
in two places, HashPasswordListener and LoginFormAuthenticator. So here I'll
change this to interface, and down here change that to interface, and I will do
the same things inside security, LoginFormAuthenticator. I'll add the interface
at the end of the use statement, and on the argument. Just by doing that, you
see there's 10 deprecations. If we refresh right now we go down to eight
deprecations.

Now there's still one in here that's interesting to me. It's the same thing, it
says, "Autowiring services based on the types the implement has deprecated,"
because somewhere we are typing hinting EntityManager and apparently that is
not the right type hint to use. Let's check it out. Let's go back to our
debug:container::types, tab, --types. I'll search this for EntityManager. There
it is, it's actually EntityManagerInterface, this is no accident. Symfony's
core is trying to encourage you to type entity interface. So again we have two
options here. We can find everywhere in our code that type hints entity manager
and change those to entity manager interface, or we can say, "You know what
it's fine, I want entity manager to automatically map to this service so let's
just add that as an alias," and that's what we're going to do.

So I'm going to copy the class name here, flip over to our services.yml and
we're just going to add that as an alias and I'll copy the
doctrine.orm.default_entity_manager service and we'll paste that. And now it is
legal to type hint with EntityManager, and when we refresh, that eight goes
down to seven.
