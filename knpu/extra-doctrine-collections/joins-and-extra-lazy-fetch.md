# Joins and Extra Lazy Fetch

Back on the genus page here I want to add a new column that says number of scientist. It will just tell us whether or not this genus has two scientists or ten scientists. Which at this point is so simple.

Let's open the genus/list at [inaudible 00:00:16] templates. Add a new TH for number of scientists. Then down below we'll just say TD{{genus.genusscietistspipelink}}. In other words go out and get my array of genus scientists and count them.

When you refresh it works. Every genus has exactly three genus scientists because of our fixtures. You can even delete one of the genus scientists if you want, go back and refresh and now it says two. Great!

Click the profiler, [inaudible 00:00:54] toolbar at the bottom, to look at what the queries look like for this. This is really interesting. You can say we have a number of almost duplicated queries here that are selecting all of the fields from user inter-joined over to genus scientist where genus said to equals 29 then 25 then 26 and then 27.

See what's happening is when we print every single row, when we print every single genus the moment that we try to count the scientists, doctor needs to make a query to go over and fetch all of the scientists for that specific genus just so he can count them.

Now you shouldn't go into your application looking for ways to worry about performance when you're developing an application, but this is a potential cause for concern. That's a lot of wasted effort. It would be better if we could just make a simple count query instead of fetching all of these user data for each of the genuses.

There's a really incredibly awesome way to do this. Go to genus find your genus scientist property, and at the end of the many-to-many add fetch=extralazy. That's it.

If you go back and refresh we have the same number of queries, but now check them out. Every time it renders a row all it needs to do now is do a count query for that specific genus to figure out how many there are. That is awesome.

It knows to do that because it realizes that all you are doing is counting the scientist. If we were to actually loop over the scientists and start printing them out, like we do on each individual genus page, then it would go and make the full query for all of the user data. So doctors really smart and figures out which one to do.

Now the only other potential problem is that this still making a lot of extra queries. It has to account for every single row, which is probably not a problem, but technically we could do this whole thing in just one query. What I mean is when we originally queried for the genus what if we joined over to the genus scientist table and over to the user table right there and just fetched all of the data at once.

It actually might be slower because we'll be fetching more data, but I want to show you how to join across a many-to-many relationship. In genus controller scroll to the top and find our list action. Right now this page gets all the genuses by calling this find all publish ordered by recently active function. That lives in our genus repository.

Inside of here we're going to pretend that we want to avoid those extra queries. How can we do it? And that means that we basically want to join to the middle genus scientist table and over to the user table and select all of that data. Now remember when you work with many-to-many relationships you need to pretend that like that middle join table doesn't exist at all.

What I mean is when you do your left join here you actually left join from genus on genus.genusscientists now alias that is genus scientist. You just reference the genus scientist property on genus. Doctrine will take care of joining across the middle table and over to the user table automatically.

Then to select that data you can say add select genus scientist. Again, depending on what you want to do this may or may not be better for performance.

if you go back and refresh now, check that out. One query. In that query it is left joining across genus scientists and left joining across the user. So you just joined directly over to user, it takes care of all that middle table stuff.

If you want to know more about doing joins and avoiding queries like this, check out our doctrine queries tutorial.
