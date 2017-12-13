Were upgraded to sympathy for him and you could stop right now. You still have
a functional application. Well actually we removed a few bundles like the
distribution bundle and the generator bundle. So you might need to add those
back or remove them from here. But basically we still have a functional
application but we are going to go ahead and change our application teams flex.
Flex as a composer plug in. That is pretty simple when you install. Packages.
It executes a recipe. Which helps to add configuration or enable the bundles
automatically for you. But in order for flex to work. You need to have a
specific flex directory structure.

So here's what we're going to do.

And it's going to be really interesting and take us down and show us how flux
works. We're going to basically bootstrap a flex application right inside of
our project and then move our configuration of files into it. First. Make sure
that composer is on the latest version. This is really important because they
released a fix recently that helps flex. Now we just need to make sure that
first install requires symphonies flashbacks first make sure you get that
composer plugin. Because as soon as we install this. It's going to whenever we
are installing a new package it's going to install the recipe for that package.

And in fact you can see that actually installed a recipe for Symphonie slash
plex stuff which is not that important but it's already doing its job.

This of course updated our composer file and did two other changes. The recipe
actually gives us a dot and b dot disk file which is going to be important for
Symphonie flux and also create a symphony dot logfile zip file. We don't need
to worry about flex manager that keeps track of what recipes it's installed.
You should commit it's your choice. So at this point we have already have a
bunch of libraries installed in our application and a lot of these have
recipes. But because we have these already Fleck's hasn't installed the recipes
for these yet so I actually want to give flaks an opportunity to install the
recipes for all these bundles. To do that I'm just going to remove the vendor
directory and run composer install. Flexors smart enough to only install a
recipe once when we do when we run this composer install.

It's going to realize that none of these recipes have been executed before and
it's going to start executing that. Yep you can see 11 recipes are going to be
installed. And one of them from stock Dacogen extensions bundle actually comes
from the contrib repository. Which just means that the. Quality of it is not as
guaranteed as the main repository. So it asks us if we are okay with installing
it. I'm going to say yes permanently by typing.

This time when you run get status. It's got even more stuff. Look it's got a
config directory in Hesser C Directory. It's actually starting to scaffold the
project around us the bundles file where it's automatically enabling the
bundles. It's building a new symphony structure right around us and we are
going to start moving our files into this directory structure. It's really
really cool.

Now when you start a new project in symphony Fleck's you actually clone from
her story called Symphony skeleton which is literally just one file. Opposer
that Jaison. Croser not Jaison. I'm actually going to go to releases. Find the
latest release. In him browse files so I can make sure that I'm looking into
Kapos that Jaison for the last stable release. So this is what a new symphony
project looks like. And then thanks to flex when you install this it actually
builds the directory structure around you. Now one of the really important. So
we want to basically make our composer that Jaison look like this composer
Jaison because it has several important things in it. One of the most important
is the fact that in symphony 4 you no longer depend on symphony symphony.
Instead of requiring all of the Sefi packages were going to require just the
specific symphony packages that we need. So I a copy all the required things.
Moving our composer the dates on and replace Paech in symphony with those two.
And also remove Fleck's from the bottom because that is now. Ta.

The most important one is it requires symphonies slash framework bundle which
is actually the core of Symphony itself.

All right let's keep going. There's also a symphony da n for required dev.
Let's go at. And we're also going to grab the config section which we you
probably don't have the application.

Look at Aloran second and then for onload. When

a copy each of these two rules and FEG grab scripts conflict an extra and we
will replace our scripts.

An extra section with it. Will fix my indentation here.

Perfect.

Now the only one that I skipped last was actually Autoload which is really
important and a symphony 3 application instead of SIRC. We had app bundle in
all of our names space's had Aspendale in them and 74 everything is going live
directly in source.

There is no app bundle and even though we don't have any classier yet when we
do have classes the namespace is actually going to be added. Now eventually I'm
going to move all of the stuff in app bundle into SIRC directly but since
that's a big step I want to do it in little pieces.

Because not everyone not every giant project can just move all their files that
quickly. So I want to give you a more gentle way to use the symphony flex
structure but eventually will move everything into it. Instead of our Autoload
mode section you can see that we're looking for all of the names spaces in our
seat and actually we can make that a little bit more specific saying I really
want to do is look for app bundle namespace and Assar C slashed app bundle and
we can do the same thing down in tests. We

can say we're going for tests slashed at Bundall to have an S to have an SRS
driven test slash cap on the now we can actually move in the new config which
says look for everything.

But for out in SIRC and then under Autoload dev look for app slash tests in
tests.

This is going to allow our application to simultaneously auto load things from
app bundle an app at the same time which will allow us to migrate our files
more gently.

Okay that was a big step.

So let's now move over to a terminal and run composer.

UPDATE The biggest change is that we're not relying on symphony symphony
anymore just rely on specific packages. You can see remove simply slash
Symphony and start adding individual stuff. Yes it totally explodes. And that's
something that we're going to Deba up next. But check this out. It actually
configured three new recipes and downloaded new packages. This is more evidence
of the project being scaffolded around us at this point. We actually have a
fully functional new empty Symphony Project sitting right next to us public is
actually the document room config has a config packages and all of her files
are in SIRC including a new kernel. So we have our old application which has
our stuff in it and we have our new application which is basically empty and
waiting for our stuff to be moved into it. But the new application uses the new
supply flux structure.

Now before we go on I'm actually going to to our vendor symphony class symphony
hall Gnomon suite now actually going to open that Inbee that D'Este and move
this framework bundle configuration the top.

We don't need to do this but because of the order that we installed things.

This was on the bottom an app and an app Secret or a very important config so
it makes a bit more sense to actually have those right on top.

All right. Our application is still totally broken.

So now we need to fix it.

We'll talk about why it's broken next. Actually before we continue we're on a
composer require symphony slash flex. One more time. This is actually a little
trick.

One of the new parts of our composer that Jaison file is something that says we
should Stuart our packages so whenever we run compose require it will make all
of our packages alphabetical. We are to have simply slash flex but just by
running that package it actually rewarded all of our dependencies in
alphabetical order. We start the big air that we need to debug next.

We still have this air about class not found. Tempted to load security bundle
from app kernel. This happens because composers trying to run in console and
that's exploding.

So I keep telling you that flex is actually lose strap in a functional project
around us but our project doesn't work. Well here's the problem. Normally when
you start a new project when you install Symphonie console it actually runs a
recipe which creates a bin slash console file. However our project already had
a been council files that recipe could do its job. Kept our old admin counsel
file for our old directory structure. So I'm the go to. Get him that comes less
tympani slash recipe's which is the official recipe or positon. And. Never look
for Symphonie.

Cons.. And then. I'm actually going to go steal. The console. Contents. And
paste them into my file.

This'll boot our new application which lives in the SIAC directory. Now when
you're a been consul we get a different air so we're closer. This says the
autoloader expects.

App Bundle app flash app Bundle app bundle to be defined in this file the file
was found.

And it's being typed in services dight YAML. So remember our code is not being
used at all right now but if you look at a new config service dynamic file it
has the same auto registration code that we have in our project. And here's the
problem right here. It's basically saying that I want you to auto register all
services in the SIRC directory and you should expect each one to have an app
namespace. Remember our stuff still has an app bundle namespace for. So for
right now I actually want to completely ignore the app bundle. Let's just get
our new project working and then we will move the old project into the new
directory structure. And as soon as we do this. We have a brand new Symphonie
for FLACs directory structure.

Project. So now let's get our code into it.
