# Saving Inverse Side Collection

Adding check boxes so we could modify the users who are studying this genus was super easy. Let's do the same thing but from the other direction.

If you're clicking on one of the genuses, then click into one of the users, there's a little edit button next to this. A very simple user form.

Let's do the same thing. Let's add check boxes here so I can go to this user and check off which genuses are being studied by this user. This is done by user controller. In user controller you can see that the edit action uses a user edit form.

Let's open up a user edit form. Down below here we'll add a new field called Studied Genuses, because in our user entity class that's the name of the property that we want to modify.

Everything else is basically going to look like the other class. Entity type is the type. We'll pass a few options like class. This time set to Genus::class so that we get a check-boxes of the genuses in the database.

Then multiple true, expanded true, so we get check-boxes. We'll set the choice label to name. All of the items in the check-boxes will each show the name of the genus.

Perfect. Next we'll open the edit.html with that twig template. In the user directory, at the bottom, we'll call form_row userform.studied genuses. That's it.

Go back, refresh, and it looks good. These are the five genuses that are being studied by this user. Let's uncheck one, check a new one, hit update, and check this out. That didn't work and this is the most important thing to understand about doctrine relationships.

As we said earlier, every relationship has two directions. You can start with genus and talk about the genus scientists or you can talk about user and talk about the studied genuses.

One of these side, in this case the genus, is known as the owning side. This is the only side that's required, meaning you can only have this side mapped. It's also the only side that you can change. What I mean is, if you have a user object and you add or remove genuses to the studied genuses property and save, doctrine will do nothing.

Doctrine's built this way on purpose. This relationship is modeled in two places, so doctrine needs to use only one of them when it saves.

In the case of a many-to-many relationship, we choose which side is the owning side when we set the mapped-by in the inversed-by stuff. The owning side will always be the side that has the join table. If you have one and you have both sides mapped you will also have the inversed-by. This is a long way of saying if you want to update this relationship, we must add and remove user from genus scientists. Adding and removing genuses from the user property will do nothing.

How do we fix that? It ends up being fairly simple but the ideas behind it can be a little bit complex. Before I show you how we're going to fix it, look back at our form. We have a field called studied genuses. Now, the way the form component works is because all of our properties are private here, it uses the setter methods to set the values. When we submit the form, it takes the email that was submitted and it calls set email on our user class to set the email on it.

Check this out. Even though we have a field called studied genuses, we do not have a set studied genuses. That should give us a huge error, but it doesn't. Why?

Turns out, the form is being a little bit smart. We have a get studied genuses and this returns an array collection object. It's an object, but it acts like an array. What the form system does is it calls get studied genuses and then it actually modifies that array collection and then never sets it back on our object, because it doesn't need to. An array collection is an object so it modifies it by reference.

If that doesn't quite make sense to you, that's okay. Watch what I do next. To prevent this behavior, and you'll see why we need to prevent it in a second, set by reference on your form field to false. Then, go refresh your form and submit.

Boom. Now we get the error I would have expected before. Neither the property studied genuses nor one of the methods, and then it lists a large number of methods including set studied genuses, exist and have public access in the user class. In other words, the form system saying, I'm trying a number of different ways to set the genuses on your class, and I can't find them. The by-reference false says, Stop being fancy and calling the getter in modifying the object by-reference, act normal and actually try to call the setter.

This means that we now need a set studied genuses method. Or do we? Instead of the set studied genuses method, we can alternatively have an adder and a remover. Why we do that is going to be obvious in a second.

Add public function add studied genus, a genus arguments. Here, we'll do something very similar to what we did inside of our genus class, which is we're going to say, If this =>studied genuses=> contains genus, then do nothing, otherwise this =>studied genuses[ = genus.

Then down below, I make another public function called remove studied genus. We'll say this=>studied genuses=> remove element genus. Perfect.

Now when we go back here and we submit, because we have these ... I can uncheck one of the boxes and check a new one and what will happen is it will call add studied genus and pass it this new genus. It will call remove studied genus and pass it to one that I've unchecked. The form system keeps track of which ones were added and which ones were removed.

When you hit update this time, we get a nice message, but it still doesn't work, and that's expected. Notice I've set up a cool system where I have an add studied genus and a remove studied genus and our form is working nicely with that, but we are still not setting the owning side of the relationship. Somehow we still need to update the genus scientists property on genus, but now it's really easy.

At the bottom of add studied genus, just add genus=>add genus scientist this. That actually sets the owning side of the relationship so that it will save. Remove studied genus do the same thing. Genus=>remove genus scientist this.

This time, when we go back, I'll uncheck the same genus, check the new genus, hit update, and it saves. This little trick here has caused many developers, including myself, countless hours to figure out how to do this correctly, but setting the inverse side of the relationship is not that hard. You just need to set by-reference to false in your form, do an adder and a remover, and make sure you set the owning side of the relationship. That is it.

As far as saving correctly to doctrine, we don't need to do anything else, but there is one teeny tiny detail that I am going to take care of. Because we have ... the array of genuses and users that are joined together stored on two different properties. In Genus, when we call add genus scientist, it would be nice if we updated this user to know that this genus is now a part of it. In other words, it would be nice if we called user=>add studied genus this.

Now, as I'm about to note here, this is not needed for persistence. This is just a convenience thing. If, during this same request, we were working with this user object and we called get genus scientists, we would probably want it to reflect the fact that this user and this genus scientist are now linked. By calling this method down here, we make sure we keep these two sides of the relationship in sync for the rest of the request. On future requests, we don't need to worry about it, it will query everything fresh from the database and it will be taken care of.

This is a nice extra that you don't need to worry about because we don't need to set the inverse side for persistence. I'll do the same thing down in remove genus scientist. User=>remove studied genus this.

The only other tiny little problem is with remove, you'll notice that if we call remove studied genus, this calls remove genus scientist and this calls remove studied genus, this is actually going to create an infinite recursive loop. We actually also want to add an if statement in the remove functions that's similar to the add functions.

In other words, when I say if not this => studied genuses => contains genus, then just return.

In other words, if the genus is not in the studied genuses array, there's no reason to try to remove it, just finish with this function. An inside genus will do the exact same thing. If not this => genus scientist => contains user, then return. That should take care of things.

Now we'll go back, I'll uncheck a couple of genuses, check a few more, hit save, and it works perfectly.

When you need to set the inverse side, because you don't always need to set the inverse side, make sure you have it set up in this way and things will work perfectly.
