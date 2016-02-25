# Alice Faker Function

I’m missing the Faker name function, which is literally giving me the name of people for my genus name.  And this is fake data, but I need it to be more realistic than that.  So, here’s what I want to do.  I want to just be able to type genus here, and that actually returns to me a random genus name.  Now, of course, that does not work because Faker does not have a built-in method or formatter for genus, but that’s okay because we can create our own.  And here’s how it works.

In our Load Fixtures class, break that load call onto multiple lines, just for space, and now add a third argument, which is sort of an options array.  And we’re gonna add a new key called ‘providers’, which are basically things that provide those custom functions.  We’ll pass an array with $this, so now it’s that this class is able to provide custom formatter functions for Faker.  And then, because we’re using a function called Faker, let’s make public function genus().

And in here, I’ve already prepared a nice list of real genus names for our favorite animals that live in the ocean.  So, we’ll finish this off with $key = array_rand($genera), and then return $genera, which is this array I just created, [$key].  This should return one of these random genuses.  So, that was easy.  Let’s try it out.

No errors.  Refresh the list page.  Ah, so much better.

Now wait a second!  We’re gonna need the ability to have published and unpublished genuses, and the idea is that we might need to create a new genus in the system, but we’re still working on its information, so we don’t want it to actually be a published list site yet.  So, this is gonna touch on migrations and fixtures, and it’s gonna be so, so smooth and easy to do.

So, Step 1 to creating a new column is to go into our Entity and create a new private property, and we’ll call it $isPublished.  And remember our generate trick, which is Ctrl+Enter on a Mac, and we’ll go down to Annotation and select isPublished.  And this is really cool.  Because we started it with “is,” it guessed correctly that this is a Boolean column, so hey, thanks, Doctrine.  And then down at the bottom, let’s add actually just the setter function.  We’ll add the getter function later, if we need a getter function for this new isPublished column.

Now finally, we wanna update our fixtures so that we have some published and some unpublished genuses.  But first, since we just added that new column, we’re going to need a migration.  So, go to the command line.  This is easy, doctrine:migrations:diff.  Check out the new migration.  That looks perfect.  And then I’m gonna want, doctrine:migrations:migrate.

Okay.  Now finally, we want to make sure that we get a few unpublished genuses in our random data set.  If you look at the Faker documentation and search for “boolean”… perfect!  There’s actually a built-in Boolean function, and we can pass it the $chanceOfGettingTrue.  So at the end here, we’ll say isPublished, and set that to boolean(75), so that most genuses are published.

Let’s rerun our fixtures to make sure that worked.  And no errors.  We’re not printing that out yet, but we’ll use it in a second.
