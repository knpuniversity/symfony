# Entity Type Check Boxes

Now that we've seen how to add items to our many-to-many relationship in fixtures and in PHP, I want to look at how to do it through Symphony's form system. This is where things get really interesting. Go to genus/admin/genus we have a little genus admin section here. Just logon with weaverrun+1@gmail.com, password iliketurtles to check it out.

We'll just edit one of the genuses. Right now there's no way from this form to actually select new users that are studying this genus and that's what we want to change.

Let's think about it. With the many-to-many relationship, how would this be shown in a form? Well it would probably be shown with check boxes. You would have check boxes for all of the users in the system and then you just check those boxes, hit save, and that would create the relationship inside of the system. If you had a ton of users in the system that would scale, but I'm going to let that be for another topic.

The controller behind this pages is called genus admin controller and it uses a form called genus form type, which is in our form directory. Step one we just need to add a new field down here and since we're updating the genus scientist property on genus that's what we're going to call it here. Genus scientists. The type will be an entity type, which should be used anytime you're dealing with a relationship.

You can see earlier we used it with subfamily. There's only one subfamily for each genus but this is a many-to-one relationship so we use the entity type there as well. The only different down here we will have a class set to user::class and then the only difference is we're going to set multiple to true so that this entity type expects an array. And also set expanded to true. What that will do is it'll list all the users as check boxes.

Next, I'm under app resources views, admin genus_form template for this page and then at the bottom we'll just call it form_row genus form.genus scientists. Let's check it out.

Refresh the page and oh, error, catchable fatal error object of class entity could not be converted to string. So what's happened here, and the error tells you a little bit of information, is it's trying to build those check boxes for each user class but it doesn't know what field in user class it should use for the display name.

There's a few ways to fix this but the way that I like to do it is by adding a choice label option to my form and I'll say email. So it says use the email property on the user class in the check boxes.

This time, there we go.

It's that easy. It already has the first three checked that's our relevance. I can uncheck AquaNote 3, check AquaNote 2, hit save and it makes those changes in the database deleting one of the records in the joint table and inserting a new record for AquaNote 2.

Now another feature in our system is that we actually have two types of users. Some users are just plain users and other users are scientists that have this is scientist [inaudible 00:04:24] property set to true. Technically we only really need to list those users here because these other users aren't really meant to be able to set as genus scientists.

In other words we want to filter this query down to just show some users in the system. The way to do this is pretty simple. I'm going to open up the user repository and we're going to create a new public function. Create is scientist query builder. Very simply this will return this arrow create [creo 00:05:30] builder, user and where user.is scientist = to :is scientist and then set parameter is scientist set to true. That doesn't make the query it just returns the query builder.

Then in genus form type we can set a query builder option set to a function. This will be passed the user repository object and we can return repo arrow create is scientist query builder.

Now if you refresh we should just have that subset. Again, this is really simple because the entity type is smart enough you can query for entity objects and set them on our genus and that's all we need.

Now in a second we're going to do this in the other direction. Meaning we're going to go to a user form and try to add genuses to it. That's where things are going to go a little bit crazy.
