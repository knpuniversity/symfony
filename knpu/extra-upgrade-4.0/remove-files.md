We're now in the home stretch for converting our application. Just need to look
in these final configuration files which are pretty easy starting to big
underscored. Why. First we created a real road cash type parameter which is now
defined in services that YAML.

The Devon environment. You can still do 74 by creating a new services for debit
and file in your config directory because about Rander over.

Now for the most part if you haven't touched the configuration in this file
then there's a good chance you don't need to do anything with a new
configuration because these are just the default founts. So if you'd dug a
little bit you'd see that this framework config can really be removed and easy
profile mentioned here and profiler mentioned there. This is referencing the
web profiler bundle which guess what we don't have installed so we don't even
the special config but we do need the composer require profiler. And that I
will delete this configuration. This does configure a recipe and it's actually
really cool.

Because this recipe actually adds Web profiler dev config which looks pretty
much exactly like what we just did. It also adds a test config. It adds new
routes automatically in the and buyer only. So just all taken care of.
Problematically. The last thing the convenience store data ammo file are is the
logging and we actually already do have monolog installed. And you can see that
there is a monologue model file. In the dev and prob directory so I actually
haven't customized my.

Monolog configuration in any way that I really care about. I did have this fire
but I am just going to remove that so I'm actually just going to delete my
config and escort them back yaml file and use the defaults in the project and
configured shorthand imo. Same saying that it's just Lalang cafe. I never
changed it so I'm just going to use the defaults. But you did make
modifications your want to move those into the new files to next config. Test
YAML. Again this is all just default configuration. The only gotcha is that you
do need to go on config packages. Test Slashfilm Radike YAML. And on coming out
the session config. So then you need to use sessions. Need. Uncomment them in
the main favorita. YAML. And also test Slashfilm YAML. So it use the mock file
storage and the test environments but other than that if you do some digging.

This is all there. Except for Sumail which were actually not used so I didn't
install next parameters I YAML you guys all know what the purpose of the
printers I am a file is in 74 it does not exist instead. We set environment
variables and in the data environment that means we use this dot EMV file. Now
the one piece is looking premières that. And we also represent YAML that disk
which has the same function as that and that D'Este. Since our premising
outfile just has database housen secret these things already live in our DOT
and file as app Secret and database Eurail. So I can actually just delete it
primers that yaml file. If you have other stuff in your parameters at yaml file
which you probably do you should add those as new environment variables in N.

And also that Deste. Then you'll need to go to where you reference them and
reference them a little bit differently instead of just referencing them as per
cent database that voters 48 percent. You use this percent in the database you
were out resolve part is probably optional you only need that if the value of
your if you actually try to use if you want to use parameters inside of your
environment variable value. In our case we can just delete premières YAML and
present YAML that D'Este except that I am going to go into my dot and file. And
customize my database name to root Colono password and database name 73
rescored.

Which this story me for the store a copy that and repeat it in my dist file so
that that is the default value.

So backed up and the only thing left to fail is routing from that file register
or annotation routes. It

also added one additional route. Copy those.

And then simplify things here a little bit. We can open routes that YAML and
paste that stuff there.

Now if you look at route's slash annotations dight YAML. This already loads
annotations writing directly from Brasseur C Directory but temporarily we still
need to load things from her app bundle.

However we even when we use our app bundle directory we're eventually going to
delete this app on the file. We

do not need bundles any sinkin for application so instead of referencing Miss's
at Apple a controller really has something similar. We're just going to say dot
dot slash as I see it happen no such control. And that's it not here for
underscore controller. We can say Apple don't flash controller flash and say
Apple slash controller slash main controller. CONAN Paul home page action. And
now we can remove around yaml in Australia. Browning underscore data because
all these things are being taken care of for us. In

fact when you remove the config directory. So now we're getting really really
close.

You can see that our application does work. We can run debug router. And we get
our list of routes.

Snax migrations where to migration's live and for while they live in insert c
section migrations directory which is automatically created for us when we
install the doctor migration's recipe. So cool. So

let's just copy those files and move them over into migration's.

Now let me do that.

You run Dyken migration's status. You know actually blow up it'll say something
about migration class Dr. migration's was not found. And the issue here is that
all or all migration classes have. A namespace. That starts with. Occasion.
Migration's.

But if you look in our Confed packages document square migrations Danieal file.
You can actually see the directory and the namespace is right here. So we can
actually change this for the easy thing is just to change the name phrase here
to application slash migration's.

And now life is good. It blew up. We don't have a direct database yet but of
course we'll work on that later.

So this point app has nothing but an app kernel app cache and onload and unless
you made some crazy customizations we do not need any of those. Delete the app
directory. And when you do that.

I also want you to go into Kapos that Jason and the Autoload section remove
those class maps. Those classes are gone. Now it's basically clean up close if
you files here and we decide to go down our directory structures and do stuff
so we do need Binn. Config. Public is the new documentary Essar C of course
templates is good test good translations tutorial this is actually something
that we're giving you we'll talk on the second now and var you can actually do
everything in sight except for cash and lock the logs directory written into
law by default in synchrony for and then when we go the Web directory at all
anymore let me just. Take my CSSA images and Jaz and vendor directory which has
some CSSA on it and move those up into public. And also move robots that text
into public. And that's it. Save icon was the default simply fav icon anyways.

If you made any custom changes that outcompetes you could move those index up
each B. But we don't need any of this stuff. You don't even need the HD access
file. If you want to use Apache there's a special Apache pack you can install
and flaps will build that file for you in the public directory to delete the
web directory. Say hello to your brand new sinfully lax application without
changing all of your old directory structure. We still have the app on the
prove it's working on console. But to really prove it's working. Let's turn up
our web server and get this guy rocking and take care of the last few details
we need to fully upgrade our owk. We'll do that next.
