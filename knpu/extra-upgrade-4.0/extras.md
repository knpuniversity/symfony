# Flex Extras

Now around 74 Fleck's there's so many awesome things I want to show you just a
few that you get automatically first check out asters the controller genius
controller and fine list action. This is a pretty normal action we get it's the
manager so that we can get the repository and call collect method on that
repository.

Right well in 74 it's simpler.

Find the genus repository one of the annoying things is that historically
repositories aren't actually services they're not in the service container
which means you can't use dependency injection on them to get the entity
manager first and then get the pastor. Well that's not true anymore. If you
want your repository to be a service all you need to do is two things. First
extend a new base class call service entity repository.

And second and second override that can start function and inside call parent.

We have just one argument the manager registry and then for the SD class has
just on call a class. That's it. Thanks to our service configuration. This
class will automatically be registered as a service and this is a constructor
that can be all wired.

So with those four lines of code your repository is now a service which means
instead of just action we can only get a manager type ingenious repository and
do this all on one line.

Treatment works.

I'll go over to slash genus and there is a functional page.

All right next thing fixtures are fixtures are totally broken because we
weren't using Alex Alice but I actually removed it right now from run doctrine
fixtures load and actually explodes because palaces available but we will not
show that so the fixture system is totally different. New version of fixtures
closed on totally different composer Jason File and Underdark and fixtures
changed it to be charAt 3.0 weird and awkward in this package. And

then I will long composer update that Sir doctrine flashed architecture's
bundle.

Previously fixtures typically they had live in and in an exact directory if you
want to access your services you needed to send a container aware fixture and
he things out of the service container container directly but it simply we
don't do that anymore. We use dependency injection so that caused a problem. So
the new version of a fixture bundle your fixtures are services and you can put
down wherever you want as soon as a although finishes. Dollery also run
composer required. F. Zenin slash Fakher. We're also going to install the fator
library because I'm going to use that in my new fixture class now to save some
time. If you downloaded the course code you should note Torrio graduate with an
all fixtures class in it. Copy that and put it directly into the data fixtures
directory not for and I should put this anywhere.

And then delete that old orange directory. This is our new fixture class. I
need to do is extend the fixture class from the fixtures bundle and everything
else hop and then it just works. Symphonies automatically get find this extra
class or any other fixture classes I'm not using it here but fix your classes.
Also EA's service which means if you get access to services you could just add
a constructor and type and those like anything else.

Once faker finishes.

You also see that in this case it's nothing special but I'm making use of the
Fakher library to give me a really nice random values so I'm doing a lot of the
same stuff we were doing in-house before manually inside this file. Point is
this is a service.

Now you run then council Dockerty fixtures load it on mapping files are all
fixtures class and it works.

Okay one last thing I want to show you. Run composer require maker this install
syntheses new generator bundle maker bundle and this is my take on a bigger
role and set up system for because we want to make develop faster. So we need
to do something. Does that go to class you can build my hand of course. There's
probably a major command for it when it finishes bad consul list make you see
said it about 10 commands there's going to be more and more in the future and
be more and more sophisticated.

So China will make it custom security and council make the let's call this the
random access order because it's going to randomly grant access. Increased
bribery.

And that's actually the only change it makes your app.

It's the only change it needs to make sure our it's open Random Access voter
films of logic basically say if someone uses is granted random access that it
will use this voter ID for our logic will say return random events tweet zero
time is greater than five.

So you and I access half the time.

And we don't touch any configuration files. This voters automatically
registered and has already been used in the system.

Prove it. We can go back to Jenas controller. Let's go to our new action.

This app is granted we'll say random access that it uses that over now the
browser.

Go to Slovakians slash new and you can see it actually Kinnaman on the long
page that actually proves it.

It's our Random Access.

Let's log in. You've just created refreshed credit fresh access denied. So are
anyone command. We are in a class we already had a class that was created ofd
into our system and that's going to be the workflow symphony. All right guys.

According to the Fleck's directory structure is actually a pretty good amount
of work but this one is Flexeril really deeply and it's going to make it's
going to pay off future. Now if you really want to have fun with flock's join
us in our Symphonie upcoming in our symphony series. We're going to start a
flex project from scratch from scratch and really do things right.

All right guys. See you next time.
