# ManyToMany Relationship

Let's talk about the famous, ManyToMany relationship. We already have a `Genus` entity
and also a `User` entity. Before this tutorial, I updated the fixtures file.
It still loads genuses, but it now loads *two* groups of users:

[[[ code('9f048e4a1e') ]]]

The first group consists of normal users, but the second group has an `isScientist`
boolean field set to true. In other words, our site will have many users, and some
of those users happen to be scientists.

That's not really important for the relationship we're about to setup, the point is
just that many users are scientists. And on the site, we want to keep track of which
genuses are being studied by which scientists, or really, users. So, each `User`
may study *many* genuses. And each `Genus`, may be studied by *many* Users. 

This is a ManyToMany relationship. In a database, to link the `genus` table and
`user` table, we'll need to add a new, *middle*, or *join* table, with `genus_id`
and `user_id` foreign keys. That isn't a Doctrine thing, that's just how it's done.

## Mapping a ManyToMany in Doctrine

So how do we setup this relationship in Doctrine? It's really nice! First, choose
either entity: `Genus` or `User`, I don't care. I'll tell you soon why you might
choose one over the other, but for now, it doesn't matter. Let's open `Genus`. Then,
add a new private property: let's call it `$genusScientists`:

This could also be called `users` or anything else. The important thing is that
it will hold the array of `User` objects that are linked to this `Genus`:

[[[ code('0ba280e398') ]]]

Above, add the annotation: `@ORM\ManyToMany` with `targetEntity="User"`.

[[[ code('8aed99a12c') ]]]

### Doctrine ArrayCollection

Finally, whenever you have a Doctrine relationship where your property is an *array*
of items, so, `ManyToMany` and `OneToMany`, you need to initialize that property
in the `__construct()` method. Set `$this->genusScientists` to a `new ArrayCollection()`:

[[[ code('2d4f24275a') ]]]

## Creating the Join Table

Next... do nothing! Or maybe, high-five a stranger in celebration... because that
is *all* you need. This is enough for Doctrine to create that middle, join table
and start inserting and removing records for you.

It *can* be a bit confusing, because until now, *every* table in the database has
needed a corresponding entity class. But the ManyToMany relationship is special.
Doctrine says:

> You know what? I'm not going to require you to create an entity for that join table.
> Just map a ManyToMany relationship and I will create and manage that table for you.

That's freaking awesome! To prove it, go to your terminal, and run:

```bash
./bin/console doctrine:schema:update --dump-sql
```

Boom! Thanks to that *one* little `ManyToMany` annotation, Doctrine now wants to
create a `genus_user` table with `genus_id` and `user_id` foreign keys. Pretty dang
cool.

## JoinTable to control the... join table

But before we generate the migration for this, you can also control the name of
that join table. Instead of `genus_user`, let's call ours `genus_scientists` - it's
a bit more descriptive. To do that, add another annotation: `@ORM\JoinTable`. This
optional annotation has just one job: to let you control how things are named in
the database for this relationship. The most important is `name="genus_scientist"`:

[[[ code('8e24ff5c78') ]]]

With that, find your terminal again and run:

```bash
./bin/console doctrine:migrations:diff
```

Ok, go find and open that file!

[[[ code('b496ea06cc') ]]]

Woohoo!

*Now* it creates a `genus_scientist` table with those foreign keys. Execute the
migration:

```bash
./bin/console doctrine:migrations:migrate
```

Guys: with about 5 lines of code, we just setup a `ManyToMany` relationship. Next
question: how do we add stuff to it? Or, read from it?
