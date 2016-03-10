# Inserting new Objects

Fearless aquanauts are constantly discovering and re-classifying deep-sea animals.
If a new genus needed to be added to the system, what would that look like? Well,
we would probably have a URL like `/genus/new`. The user would fill out a form,
hit submit, and the database fairies would insert a new record into the `genus`
table. 

Sounds good to me! In `GenusController`, create a `newAction()` with the URL
`/genus/new`. I won't give the route a name yet - that's not needed until we link
to it:

[[[ code('0b82d15001') ]]]

## Be Careful with Route Ordering!

Oh, and side-note: I put `newAction()` *above* `showAction()`. Does that matter? In this
case, absolutely. Remember, routes match from top to bottom. If I had put `newAction()`
*below* `showAction()`, going to `/genus/new` would have matched `showAction()` - passing
the word "new" as the `genusName()`. To avoid this, put your most generic-matching
routes near the bottom.

***SEEALSO
You can often also use [route requirements][1] to make a wildcard only match certain
patterns (instead of matching everything).
***

## Inserting a Genus

Ok, back to the database-world. Let's be *really* lazy and skip creating a form -
there's a *whole* series on forms later, and, I'd just hate to spoil the fun.

Instead, insert some hardcoded data. How? Simple: start with `$genus = new Genus()`,
put some data on that object, and tell Doctrine to save it:

[[[ code('b01ddec476') ]]]

Doctrine wants you to *stop* thinking about queries, and instead think about *objects*.

Right now... `name` is the only real field we have. And it's a private property, so
we *can't* actually put data on it. To make this mutable - to use a really fancy
term that means "changeable" - go to the bottom of the class and open the "Code"->"Generate"
menu. Select "Getters and Setters" - we'll need the getter function later:

[[[ code('6528706d00') ]]]

Great! Now use `$genus->setName()` and call it `Octopus` with a random ending to
make things more fun!

[[[ code('8046c8b629') ]]]

Object, check! Populated with data, check! The last step is to say:

> Hey Doctrine. I want you to save this to our genus table.

Remember how *everything* in Symfony is done with a service? Doctrine is no exception:
it has *one* magical service that saves *and* queries. It's called, the *entity manager*.
In fact, it's so hip that it has its own controller shortcut to get it:
`$em = $this->getDoctrine()->getManager()`. What a celebrity.

To save data, use two methods `$em->persist($genus)` and `$em->flush()`:

[[[ code('5085556bf6') ]]]

And yes, you need *both* lines. The first just tells Doctrine that you *want* to
save this. But the query isn't made until you call `flush()`. What's *really* cool
is that you'll use these *exact* two lines whether you're inserting a new Genus
or updating an existing one. Doctrine figures out the right query to use.

## Finishing the New Page

Ok, let's finish up! Do you remember what a controller must *always* return? Yep!
A `Response` object. Skip a template and just `return new Response()` - the one from
the `HttpFoundation` component - with `Genus Created`:

[[[ code('b91ff5eabe') ]]]

Deep breath. Head to `/genus/new`. Okay, okay - no errors. I *think* we're winning?

## Debugging with the Web Debug Toolbar

The web debug toolbar has a way to see the queries that were made... but huh, it's
missing! Why? Because we don't have a full, valid HTML page. That's a bummer - so
go back to the controller and hack in some HTML markup into the response:

[[[ code('0c03f5c103') ]]]

Try it again! Ah, there you are fancy web debug toolbar. There are actually *three*
database queries. Interesting. Click the icon to enter the profiler. Ah, there's
the insert query, hiding inside a transaction.

And by the way, how sweet is this for debugging? You can see a formatted query, a
runnable version, or run EXPLAIN on a slow query.

## Running SQL Queries in the Terminal

I still can't believe it's working - things never work on the first try! To
triple-check it, head to the terminal. To run a raw SQL query, use:

```bash
./bin/console doctrine:query:sql 'SELECT * FROM genus'
```

There they are. So inserting objects with Doctrine... pretty darn easy.


[1]: http://symfony.com/doc/current/book/routing.html#adding-requirements
