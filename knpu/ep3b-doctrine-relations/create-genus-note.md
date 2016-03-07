# Create Genus Note

Now that this Genus is actually dynamic, we need to make the Genus Notes dynamic.  This is where we’re going to start talking about database relationships because, clearly, we have one.  This Genus is related to these many Genus Notes, which right now are just hardcoded.

So, we’ll start first by making a Genus Note entity, and there isn’t bin/console command to do this, but I’ll start the same way I always do, by just creating a PHP class, Genus Note.  Then the only thing we need to grab is this use statement, or you can write it manually, and then use Cmd+N to bring up the Generate menu and add the Annotation class, and then just start adding some properties.

So, let’s see here. We are going to need a username, an avatar filename, a notes, and a created at.  So, private $username; private $userAvatarFilename; private $note; and private $createdAt.  Then Cmd+N again to add all of those annotations for me.  And always, just make sure they actually have the right type.  Let’s see.  The only thing I probably wanna change is $note to “text,” which is a bigger field in the database; it can hold more than just 255 characters.

And then, we’ll make the getters and the setters for all that stuff.  I don’t usually make a setter for the Id because you probably shouldn’t be setting the Id, but I will make a getter for the Id.  And you might not add getters and setters till you need them, but it’s a good idea if you wanna just kinda make your life simple.

All right, so this is a new entity.  It’s not related to Genus yet, but we already know that we need to go over here and generate a migration, doctrine:migrations:diff.  Copy the filename.  I’m gonna open that filename.  Remember, this just lives in the `app/doctrine/migrations` directory.  And yeah, great table.  That looks just fine.  So, go back to our ./bin/console doctrine:migrations:migrate, and there we go.

Next, just like with Genus, we need to set up some fixtures for these Genus Notes.  So, I’ll go into the same fixtures.yml file, and this time we’ll make the class name AppBundle\Entity\GenusNote, and then we’ll start a very similar way.  So, I’ll say, genus.note_, and let’s create 100, so we’ll use 1..100, and we’ll start filling the data.  So, username, and I’ll do, <username()>.  Remember, all these function things are coming from the Faker library, so I don’t know these by heart, but if you look through here in the Faker documentation, you’ll find all these shortcuts, and you can find ones that you want to use.

userAvatarFilename.  Now right, eventually, that users are probably gonna need to upload their own custom avatar, but for right now, it’s just a filename, and there are two filenames in the system, leanna.jpeg and ryan.jpeg.  So, I’m gonna use a really cool syntax here, and it looks like this: ‘50%? leanna.jpeg : ryan.jpeg’.  And you can just see how we’re reading that.  50 percent of the time, it’s going to be leanna; 50 percent of the time, it’s going to be ryan.

Okay, note: <paragraph()>, and then a, createdAt:, and we can use a cool thing called <dateTimeBetween>, and we’ll do things between -6 months and right now. And that should be it, so let’s go back and rerun our fixtures, doctrine:fixtures:load.  And we’re not showing those anywhere yet.  We can already go, doctrine:query:sql ‘SELECT * FROM genus_note’.  Awesome!  There they are.

So, two entities.  Let’s join these together.
