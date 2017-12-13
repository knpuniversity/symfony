With the deprecation is gone. Yeah it's time to upgrade some free for. This is
probably the easiest step. In composing that Jaison change symphony is simply
to care for point zero. There are a few other symphonies slash libraries. These
all file their own versioning scheme. They're not part of the main it's simply
package one that is that one that is actually simply a branch. So I'm going to
bump that also to 4.0.

And then turnover run composer update. Now probably there are going to be some
dependencies in our composer that Jaison file that are not compatible with
simply for yet.

And probably will need to actually upgrade those. Best way to find out is just
to try and upgrade. Whoa. It's the big explosion and if read closely toxo how
now meal Alice requires. Is not compatible with Symphonie for. Now. Actually
there is a new version of snail mail Alice that is compatible with something
however they made a ton of change to send them to Alice and I'm not a big fan
of all the changes so I'm actually just going to remove this library. This will
break our fixtures which use Alice Bhole fix those later.

So go back try and or update again.

And not surprisingly it explodes again. This time it's not to my unscented
composer parameter handler. And actually compose a parameter Handler is a
helper that helps with parameters doubt. Why am I not. Well guess what. And the
symphony for flex at that file is gone. So this package isn't even needed
anymore. Neither is the distribution bundle which also helped support the
current directory structure. And down at the bottom the generator bundle. Did
remove that as well and later we're going to install the new maker bundle.
Right. To the terminal and run. Update. And this time it actually dies because
of stock doctrine extensions bundle.

So you want to do is soon as you find this is Godbout libraries get hard and
try to figure out what's going on because they might already have support. For
sympathy for what might be in a new version. And actually in this case if you
look at the composer about Jaison it actually does allow Symphonie for however
if you look at the releases there hasn't been a release in a long time.

So basically support isn't there but it hasn't actually been tagged yet. I hope
that in this bundle it will happen very soon.

Another common thing is that it might not have Symphonie for support yet but
you'll find a whole request that adds Symphonie for support.

In both situations there is a work. You have three options. 1 you can wait
which is fine.

Or two you can too.

If there's a request you can actually use that fork of that request by adding a
repository is option and you can post that Jaison file for example. If we look
at the symphony for Paul request if you imagine that this was not merged yet we
can actually add this fork as a repository or compose a Jaison and then change
the brass to Deb dash master. Now this is because there's not a release yet.
All we need to do is change our target temporarily to Deb dasht master for this
repository. So when composing a Jaison I'm going to change it to Dad dash
master.

Not happy about that but I wanna keep upgrading.

Move over try composer update again. Whoa. It's actually working.

Say hello to your symphony for project before you pull over and refresh. It
doesn't fully work yet because we've removed a couple of dependencies that
we're using but our project is on Symphonie for now. One last thing up here and
see it's talking about this symphony swift Miller bridge is a band that you
should avoid using it. And actually I don't see that in my composer that Chase
on file composer. Why symphony SLAs bridge.

And he could see this dependency is because of the swift matter Bundall which
we have at two point three point eight.

So I'm just curious. Let's google for that one.

And you can see there's actually a new version 3 of that bundle and probably
that Abana package thing is fixed in that latest version.

So let's change it to carrot. Three point one. Obviously you should also look
at the change logs to make sure that nothing really important change for
version 3 strong composer. UPDATE One More Time. So that we can get a symphony
for a project without that old package. Hirvonen. Now comes the real we're
moving our project to the new Flex directory structure which is the most word.
Also really fun.
