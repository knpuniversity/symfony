So if you want to be done you can basically your old code lives. And about all
of my new coach happy to see that over time you might decide to migrate all
these files into SIRC but if you want to do it all at once it's not as hard as
you think.

If you're using PGE store. So first right click app bundle right click on the
Apple namespace and go to refactor. Move move this to the app namespace.

Then down here you want to make sure your target destination directory is just
aquanauts sash SIRC. That same move on things and the app namespace into that
directory. So that's it. Refactor give me a big summary and let's just do it.
This finds all of places it can see where app is used. And updates those as
well. It's not going to be perfect but it's going to be easy to fix. Yeah check
this out. Everything got moved into app these are now all and d directories UI
file it's still yours fixes that YAML. That's from the house fixtures were new
fixtures and a different way in a few minutes. So let's meet at the.

That felt amazing while you here.

Let's also refactor our test directory. We only have one test which we got mine
faults but anyways l'esprit back to that as well. So let's open that class
right click on namespace. Go to refactor move and in this case namespace is
going to be slashed.

Tests.

Why that that's actually in your composed js on file under the onload.
Infantine directory. This is perfect for me Walk's Sase slashed controller.

In this case the app know the target directory.

You can actually press have to modify that a little strange. I'm still going to
tests slash controller so the app is going to be assumed the app slushed has
assumed that refactor and delete the app on the directory. I love.

All right so what Brooke.

And now that we've done this one more thing. Going to oppose that Jaison and in
one section removed the app on stuff. There is no more formal Directory Project
Project so well.

Let's find out.

Move over and refresh. The first error is something about the file SHC flash
happened not existing and it's coming from services. Yeah that makes sense. If
you go into config slash services that YAML we still have our old temporary
route service imports remove those and it doesn't matter but we can also remove
these bundle exclude from at above there's one other importance out of route
Statton YAML. We no longer need to load routes. Seems like happened to our code
is already loading routes from Sase slash controller and since our Controller
stuff lives there now it's automatically be loaded. And while I hearing routes
that YAML course we can change the name stays to be kept flashing troller and
even hover over it and hold command open that love it. Now back in services
slash YAML. You see that. Still a lot of app bundles in here the names of those
services are now all different. They're

all at slash something so very simply I'm going to do five for Wandle and
replace it with app replace all.

Now it's properly overriding all those services. So that's an example of
something the refactored didn't catch. But it's really easy to find because
it's super easy to look in your privacy for app bundle and then the last part
we have in our config is actually in config packages. Dr. dight YAML because
remember we temporarily added our mapping that's not needed anymore. So what do
we have. It's pretty easy to figure out because we can just run get out on the
app. No more an app. But close our project at all. And the list is actually not
that bad. And most of them are to get her heart rate which actually has a
workaround if you want.

So it starts security that YAML or replace app onto an app.

And of course you could do a more project wide find and replace that I'll be a
little more careful. We can't entirely delete the SNC file. And then we have
two controllers genius and controller and genius controller. In these cases I'm
not going to do a finer place to search for Apple on board. So the scale
repository because the Mabi is gone. That's not correct anymore. You could
technically change that to just ask or you could actually go into your doctor
and YAML and change the place to be at Blondell. If you did that everything
would just work or didn't go the hard way and change this to be genius. Call in
class. That's the way that I'm going do it. It's also do disingenious
controller I'll change always get her upholstering calls as quickly as I can.
Her fax and then the last ones are things inside of our inner cities themselves.

The next one's. Repository namespace and the relationship with Jobs is
shortened since it's in the same namespace genus no subfamily. User in the last
spot was actually inside of them. We had one in genus form type. Chain that a
new genus called on call and class syntax and the last one was inside of our
log logging form authenticator which all changed to just user and is gone. Come
we gone.

And the or advocation.

And when you refresh. Oh we actually get the error P2P incomplete class cannot
be converted to a string. This is actually due to the serialization of the user
so to just change that class name actually kills it in a session. You can fix
this by going to log out and it will clear that from the session. Now the only
warning is on production. Users won't get that air but they all end users are
want to get bought out. When you deploy this one time so let's log back in
password. I like turtles and it works. Trapaga is now fully on Flack's. You
have no references to Apple or the old project at all. Done it in a really safe
gradual way. So next let's talk about a couple of the extras a couple fun
things that were and to get things to upgrading.
