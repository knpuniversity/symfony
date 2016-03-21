# Query for a List of Genuses

Woh guys, we can *already* create new tables, add columns *and* insert or update
data. There's just one big piece left: querying. 

Let's create a new page that will show off *all* the genuses. Create
`public function listAction()` and give it a route path of `/genus`:

[[[ code('d463515129') ]]]

## Querying? Get the Entity Manager

Remember, *everything* in Doctrine starts with the all-powerful entity manager. Just
like before, get it with `$em = $this->getDoctrine()->getManager()`:

[[[ code('77472e8ff0') ]]]

To make a query, you'll always start the same way: `$genuses = $em->getRepository()`.
Pass this the *class* name - not the table name - that you want to query from:
`AppBundle\Entity\Genus`. This gives us a repository object, and hey! He's *really*
good at querying from the `genus` table. In fact, it's got a bunch of useful methods
on it like `findAll()` and `findOneBy`. Use `findAll()`:

[[[ code('ef8beb97b9') ]]]

What does this return exactly? Um... I don't know - so let's find out! Dump `$genuses`
to see what it looks like:

[[[ code('b799fe907f') ]]]

Back to the browser! Go to `/genus`... and there's the dump! Ah, it's an array of
`Genus` objects. That makes sense - Doctrine is obsessed with always using objects.
And sure, you *can* make queries that only return *some* columns, but that's for
later.

## The AppBundle:Genus Alias

Back to the controller! Now change the `Genus` class name to just `AppBundle:Genus`:

[[[ code('47b7aa4f85') ]]]

Wait, what? Didn't I say this should be the *class* name? What is this garbage?
It's cool - this is just a shortcut. Internally, Doctrine converts this to
`AppBundle\Entity\Genus`. You can use either form, but usually you'll see the shorter
one.... ya know, because programmers are efficient... or maybe lazy.
