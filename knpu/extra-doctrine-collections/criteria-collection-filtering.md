# Criteria Collection Filtering

 Back in the /genus page, because there is one last amazing thing I'm going to show you with working with collections. But first, two little things of homework that I messed up along the way that I want to make sure we fix before we finish.

 First, you'll notice I have this little red tag down here. If you click into this you'll see it's actually giving me a mapping warning that says the user study genuses is on the inverse side of a bidirectional relationship but the specified association on blah-blah-blah does not contain the required inversed by equal study genus attribute.
 
 What this is telling me is that my user correctly has a study genuses property with a mapped by but on genus scientists we're missing the inversed by pointing back to study genuses. I don't know why [doctorine 00:00:57] requires you to have that, it doesn't seem to need it, but that will get rid of that warning.

 The second thing I need to fix is this years study field. When we created it I set it as type=string that was incorrect. Let's change it to type=integer. It hasn't caused a problem yet because we haven't tried to do any type of number operations with it, but we're about to in a second so let's get that fixed.

 Of course we need to run a new end console doctrine migrations diff and bin console doctrine migrations migrate. Great. Now, back to our /genus page.

 Right now we're printing out the number of scientists on this page and thanks to a query we made inside of the genus repository, we're actually left joining on this query from genus over to genus scientist and collecting the genus scientists fields.

 What this means is we're able to build this entire table of genuses including counting the number of genus scientists entirely with one query. If you skip past the query that's used by the security system from the user table you'll see that everything is done with this one query. Which is awesome! But at the same time we are selecting a lot of extra data since we're only trying to count the scientists.

 We talked about this earlier, whether or not joining over like this is the best thing performance wise, just depends on your application. Anyway I want to show you something different so I'm actually going to comment this stuff out for the time being.

 Then we'll go back and refresh and you'll see that this is now replaced by one query for every row which does a really efficient count query over to count those genus scientists.

 Now the new idea here is that some scientists are considered experts. Those are scientists that have studied the genus for longer than 20 years. In addition to the number of scientists I want to print the number of expert scientists right next to it.

 If you look inside of the list that [H2M 00:03:15] twig template, the way that we're printing this number now is saying genus.genusscientist.pipelink. In other words call, get genus scientists, get all of that and then count on it. How can we actually filter that down to only genus scientists that have studied the genus for longer than 20 years?

 The easiest way is create a new public function called get expert scientists and just loop over all of the genus scientists and filter that down to a smaller collection. We can actually do that very easily by saying this, get genus scientist arrow filter, which is a method on the array collection object and you can pass that in a function of a genus scientist argument and then in the function we can say return genus scientist get years studied greater than 20. It will loop over all of the genus scientists and then give us a smaller array with only the genus scientists that have more than 20 years study.

 To print this out in the list template I'll create a new line left parenthesis, then curly curly genus dot expert scientists pipe length and I'll say experts closing parenthesis. When we refresh we get zero ... or before we refresh go back to genus and make sure you have a return statement from that filter. Perfect.

 Now go back, refresh, and that looks probably about right. Awesome. Check out the queries down here. Click now it's still doing a count query for every single row but it's also querying for all of the genus scientists for a specific genus. The reason it's doing that is as soon as we loop over the genus scientists, doctrine realizes that it needs to go and query for all of the genus scientist for this genus so it can loop over them and we can see which ones have the years study.

 This may or may not be a huge performance problem. If every genus always has just a few scientists no big deal, but if a genus has hundreds of scientists this page will grind to a halt while it queries for and hydrates all of those extra genus expert objects just so that we can ultimately get a count.

 Filtering a collection like this from inside of your entity is really convenient but unless you have a small set it's not going to be a good solution.

 I'm going to show you a better way. It's using doctrine's criteria system. It looks like this. Credit [card 00:07:48] criteria variable set to criteria::create. Off of this we're going to build something that looks a lot like doctrine's query builder. We can say and where, then criteria::expr and then gt for greater than. There are lots of other methods on this object for equals in other situations. We'll pass gt, we'll pass years studied comma 20. Then just to show off we can even do an order by pass that array with the years studied set to descending.

 Now that we have a criteria that describes how we want to filter, we can return this arrow get genus scientists arrow matching and pass it that criteria. Now check this out, when we go back and refresh we get all the same results, but look at the queries, they're vastly different. It still does the original count for all of the scientists, but now instead of querying for all of the genus scientists it actually has a where clause with our year studied greater than 20 and it actually is smart enough to count them.

 If in our template we really did want to loop over and print the names of all of the expert scientists, it would be smart enough to query for the genus scientists using this where statement here. Criteria system is a way for us to filter a collection from inside of our entity but do it by actually changing the query instead of fetching all of the data and then filtering it down in php. It is an amazing system.

 Now to keep my code organized I don't like to have query logic inside of my entity. I like to have all of my query logic inside of my repository classes. Let's go to genus repository, create a new static public function, create expert criteria. I'll copy the criteria line from genus, past it here and return that directly. Make sure you type the a on criteria and hit tab so that we can auto complete the use statement.

 Now the reason this is static is because I need to be able to access it from my genus class and I'm only going to be able to do that if it's a status. This is a rare time when I say it's okay to have a static method inside of your repository class.

 Outside of the genus we can simplify things by saying this arrow get genus scientists, arrow matching, genus repository, create expert criteria. Hit refresh, that works exactly the same as before.

 Another advantage of having this inside of your genus repository is you can actually use this in query builder. Imagine that we needed to query for all of the experts in the system. To do that we can create a new public function find all experts. Now this is a really simple query to write it's just where years study is great than 20 but I'd rather not duplicate the logic that we have down here.

 We can say return this arrow create query builder, genus, add criteria self::create expert criteria then the normal get query and execute. That will return an array of genus objects like normal with that spot on there, so criteria is super awesome because we can use those for new queries and also for filtering down existing things.

 All right guys, that is it. This tutorial attacked the stuff that people really get frustrated with in doctrine and in symphony. Collections are hard. If you understand the mapping and the inverse side and you're able to set up things so that you're setting the mapping side on the inverse side and you have the sensible things that you need like orphan removal and cascade, your system is going to be airtight. I kind of wish doctrine generated more of this stuff for you, but it's hard because doctrine is very hands off. Now you guys know what to do so go forth, don't be afraid of collections, attack them and do amazing things with them.

 All right guys, see you next time.
