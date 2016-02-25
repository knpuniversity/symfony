# Show 404

Now, our application’s starting to come alive. We have this list page.  We also have a show page, so let’s link these guys up here.

To link to the show page, we, of course, have to give this route a name, so I’ll add name=, how about ‘genus show’?  That sounds good to me.  And then in the list, turn this guy into a nice anchor tag.  Using the path function, we go ‘genus show’, and remember, we need to pass in genus Name, so here, I’ll do curly braces.  If you want, you can even break this onto multiple lines.  And you can say ‘genus Name’ is genus.name, and then for the text in the link, we’ll keep printing out the genus.name.

Okay, so, wonderful.  Refresh the list page.  Those turn into links.  And let’s click the first one.  So, it says Octopus66, but you can see that the Fun Fact is still the same hardcoded thing as before, and the Known Species is probably not right.

Remember, in show Action, all this stuff is still just hardcoded.  So, it’s time to grow up, guys, and actually fix this.  So, first, get rid of the fun Fact.  We need a query for a genus matching that genus Name, and remember, that always starts with the Entity Manager, $em = $this->getDoctrine()->getManager().  And then because we’re querying, we’re gonna go out to the repository class to get it, so $genus = $em->getRepository, and we can use our nice shortcut syntax that autocompletes.  

And then we need to find a method on here that can help us find this.  And the one we can use is findOneBy, and we pass it an array, ‘name’ => $genusName, so this will find one where the name is set to that genus Name.

Now temporarily, it’s gonna be kind of annoying to have all this caching inside of here since it slows things down, so let’s comment out the caching – we’ll add that back later – and then our template doesn’t need all the information to be passed individually anymore.  It just simplifies passing the entire genus object because, remember, Doctrine gives us back entire objects by default.

In show.html.twig, let’s update some stuff.  We can say genus.name, genus.name again, and then we can actually get rid of this hardcoded stuff and say genus.subFamily and genus.speciesCount and genus.funFact, and we get rid of the raw because we’re not rendering through markdown temporarily.  And then one more spot down here when we set up the JavaScript.  Change this to genus.name.  

Okay.  Let’s give this a try.  Refresh.  Awesome, looks good.  Known Species is the actual number of known species that there should be, and of course, we don’t have a Fun Fact, and we didn’t break our JavaScript down here.

So, what would happen, though, if somebody went to a genus name that did not exist, like FOOBARFAKENAMEILOVEOCTOPUS?  If we do that, okay, we get a bad error.  The error’s actually coming from Twig – cannot access attribute (“name”) on a null variable – because on Line 3 of genus is null, so the whole thing blows up.  We do not want that.  We want the user to see a nice 404 page.

So, whenever you query for one object, you’re gonna wanna check to see if that object does not exist – it will either be that object or null – and if it doesn’t exist, throw $this->createNotFoundException(‘No genus found’).  That message will only be shown to the developers.  That won’t be shown to your end user.

Head back, refresh, and there’s the proper 404 page.  It’s still the nice developer version for us, but you’re gonna be able to customize how all of your 404 pages look for your users.
