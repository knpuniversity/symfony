# The King of Relations: ManyToOne

Aquanauts *love* to share what they find - and they'll be able to do it on our site
by adding *notes* to each Genus. The notes are hardcoded right now. Time to change
that!

Forget about Doctrine: just think about the database. Imagine we have a `genus` table
and a `genus_note` table. Every `genus_note` belongs to exactly *one* `genus`.
How would you set that up? You'd probably add a `genus_id` column to the `genus_note`
table. Simple!

Actually if you think about it, this is the *only* way that two tables can be associated
in the database. Doctrine calls this a ManyToOne relation - many `genus_note` can
be associated with *one* `genus`. It's the *king* of relationships!



But, what about OneToOne, ManyToMany or OneToMany 

The *only* other is called a ManyToMany - like `product` and `tag` tables - where
each product has many tags *and* each tag is used on many products. 

type of relationship
that exists, which we'll talk about later, is a many to many relationship. So,
for example, think about products and tags, where a product has many tags, but
a tag is used for many products. And in a many to many relationship, that's
actually where you have a joined table. You have a product table, a tag table,
and then a middle joined table like product underscore tag. And if you think
about it even further, even that is just a many to one relationship in two
different directions. So when you set up relationships, the first thing you
need to ask yourself is is this a many to one relationship, the classic
relationship, or is it a many to many? And this is a classic simple many to one
relationship. And setting this up in doctrine is going to be very simple, but
this is sometimes where people get lost, so stay with me. In this set up, the
foreign key column in the database would go on the genus note table. That's
where we'd have the genus ID. So when we want to set the relationship, we're
going to actually modify the genus note entity, just like how we would modify
the genus note table on the database. Now the tricky thing is that instead of
adding a genus ID property, we're going to add just a genus property, and then
we're going to annotate that with a many to one annotation, and inside that
we're going to have a target entity key which points to genus. And I can just
put the word genus, not the full name space, because these happen to live in
the same name space. And that, guys, is it. That's all you need. Behind the
scenes in the database, this is going to create a genus underscore ID property,
but in PHP we're actually going to set a genus object on this property, and
I'll show you that. So let's generate our getters and setters, and just to
clarify, for set genus, I'm going to type in this with the genus class. We will
set objects on this property. All right, you guys know what's next. Generate
the migration. And let's check that out. Look at this. Alter table genus note
at genus underscore ID. So it does add genus underscore ID, and then there's
two lines here to actually set up the foreign key constraints. So it's exactly
how you would normally set it up in the database. No different at all. I'm
going to run that with doctrine migrations, migrate. So how did we actually
save this relationship? Well let's do this in PHP first. Go back to your
controller. In new action, let's just create a new genus note. Genus note
equals new genus note. So user name, aqua weaver. And so far this is just a
normal object. So how do we link them together? It's simple. We just link the
objects together using that new property. Genus note arrow set genus, pass the
genus object, and that is it. So we set an object on there, it's going to turn
that into an ID in the database for us. And then just don't forget to persist
that genus note. And the order those persist do not matter. Doctrine is going
to figure out that it needs to insert the genus first so that it can get the ID
and then insert the genus note afterwards. So go to your browser, go to slash
genus slash new, and an error. And we get an error, which is actually totally
not related to this. It says is publish cannot be null. Let's fix that. It's
actually coming from the genus table. When we created this is published, we did
not have null equals true or false. That's actually okay. We probably want to
default is published to false. So if you forget to set is published, then we'll
automatically get a false valued. Anyway there we go. This time it works. Check
out the queries down here, and look at two inserts. Insert into genus, and then
later insert into genus note, and ultimately it passes the genus ID at a value
of 46, which is the ID that was just put in there. So that's it. You've just go
tot link objects together, and it takes care of all the nitty gritty details of
turning that into an ID later. Now one of the few things that you can control
with this relationship, just like a column, is whether or not it's required.
And with normal columns, the default behavior is normal, so normal columns, you
must give them a value. And if you want to change that, you go nullable equals
true. For whatever reason, foreign key columns are the exact opposite. So right
here, the genus is actually optional on genus note, which is probably not what
we want. It does not make sense for a genus note to exist in the database
without a genus. So if you want to change this, we're going to do an at ORM
slash join column, say nullable equals false. And there are a few other things
that you can control about the relationship in the database here, like on
delate, and this would be like the actual on delete functionality in the
database if you want to do that. Once we have nullable equals false, we
generate another migration. This time I'm just going to trust it and run it.
And it actually explodes. Null value not allowed. So why? Alter table, genus
note changed, genus ID, it's not null. So if you think about what's happening
here, we already have a bunch of genus notes in the database that have a null
genus, and those are the ones that are actually coming from our fixtures. So
this migration is actually failing because of the data that's in the database.
And if we already had deployed things to production, we would actually have to
change our migration here to maybe give those genuses a default value for genus
note or something different. But since we haven't deployed to production yet,
this won't be a problem. So what I'm going to do is actually drop the database
completely, recreate it, and then re-migrate, and this will go through all of
the migrations we've ever created, and this time it works fine. So just be
careful. If a migration fails, sometimes you can ignore it, and sometimes you
can't ignore it. In this case, we can't. So finally we do need to fix our
fixtures, because right now if we load they're going to fail because the genus
note is not linked to a genus. And it turns out doing this is really really
easy. Ultimately Alice, behind the scenes, is just using these setter function.
So it's going set username, set user avatar filename, so all we want to do is
have it call set genus, so we'll put genus, and then here instead of passing at
a string, we want it to actually pass at these genus objects. So fortunately
Alice has a way to do that. You just use at, and then you use the name of the
reference that you want. So you could say something like at genus underscore
one, or way more cool than that, at genus underscore star, to get a random
genus. So now head back, go to bin console, doctrine fixtures load, no errors,
and now run doctrine query SQL slash star from genus note and check that out.
Every single one is a random genus. So this is a classic, beautiful many to one
relationship, and it's super easy to handle on doctrine.
