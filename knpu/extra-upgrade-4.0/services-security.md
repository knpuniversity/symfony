OK. Remember the goal is to move our code which mostly lives in the config
directory into the new directory structure.

Now the next bit of configuration is doctrine which we don't have anything
special here just our database configuration. And a bit more config Config
packages Dr. Di YAML you can actually see we basically have the exact same
config here. There are some slight differences which are actually improvements.

Basic it's the same in this case the actual instead of having multiple
different config for host port database Numery user and password. They're all
just done via the UL in this database. Is actually defined in our data and via
it has all the information right there. The of the config like naming strategy
in auto mapping is exactly the same. The only difference is the mappings in a
symphony for flux project. We expect your diesel Essar C entity but ours right
now live in Aspendale and SDE.

And yes we are going to eventually move them. But let's pretend like moving
them is too big of a thing right now. I want to make my DS work where they are.
So to do that I'm going to add a second mapping it says we also have things an
app bundle.

Which is directory SLAC app bundle entity prefix namespace prefixes app on the
slushed Wednesday and the alias is app bundle.

Now that we can remove all of this doctrine configuration. The last Cubanos
here are for Dokken cash and stock dock and extensions bundles both these
bundles are installed. We just need to move over that configuration when we
install the doctor and cache Mondal. You can see that it actually did not
create a configuration file which is fine. Not all packages have configuration
files. So let's create a new one called doctrine on the score Kashdan YAML and
then we all move all of the configuration into that all YAML configuration
files are automatically loaded so we don't need to register this anywhere. And
then for stop Dokken extensions. It does have a configuration file but we need
to add our configuration to the bottom of it.

You guys config YAML is gone. We'll look at the rest of these YAML files in
second let's celebrate. Delete config. Now I'm out.

Actually close.

All of these other files except for service has died. Yeah. Because that's the
one I wanna work on next. Open to our original services. Why I'm out here we
have the default the auto registration and then we have some aliases and some
specific wiring that we needed for our services. So again for now we're going
to keep our old code in app bundle which means that we still need to register
those. Classes as services.

In our new file to make things work. We specifically said not to register those
services because they don't have the app namespace prefix. So now. Copying
those two. Imports from your original services file.

And paste them into the new file. I'm going to have a little comment here. It
says we can remove this stuff later as soon as. Our app bundle stop is gone.
But this is going to continue. To load things from bundle. For move one level
of directory structure since we're not as deep as we were before.

So anything that Apple gets on a redshirt as a service correctly anything
directly an app also gets registered as a service frankly. Let's also make sure
that we move over all of our existing.

Aliases and service configuration. We'll put those down here at the bottom.
Gap. It's that easy. And now we can delete our services that yaml file. So
let's see where we're at right now because that was a big step. All of a
sudden. Most of our code is being used. We have actually just hooked our old
application into our new application. So the civil works let's run then consul.
And actually you get this big.

Class not found air that's coming from our long form authenticator abstract
form log authenticator. It comes from the simply security components mission
here is action. Don't have the security component installed.

So let's run composer require security. Another. Alias.

That stalls and then boom we have another air. This actually says beta class
log form authenticator contains one abstract method. So I think I may have
missed a deprecation on simply 3 which is now causing a fatal error on 74. So
let's go take a look. And see at Bundall security logon form authenticator.
Yeah. Class must implement authentication success. This is a deprecation that I
missed. So let me walk you through it. Remove the default success redirect you
or else they use to there. Instead of go to code generator or command and go to
implement methods and implement authentication success. Before this method is
done for you. Now we just have to do it yourself. To help with it. Go to the
top of the class. And use a trade called Target has a trait. That allows you to
do down in authentication success. You can say if Target Path. Equals this
arrow good target get target path. Then pass it. Request arrow get session. And
then the key made. Now let me talk about this in two pieces.

First of all this main key here is actually the name of our firewall which in
both the old both the new security configuration which was just installed for
us. It's called Maine and in the old security configuration which we're going
to use in a second is also called Maine. Now what this does is it looks to see
if the user tried to go to some well before they hit the log in page like they
want to slash admin and then more redirected to slash logging that happens want
to redirect them to the page they were trying to go to before.

So if there is a target path we can return new redirect response target path.
Else return new redirect response. And generate a mural to the home page route.
Which is highlighting is a real route in our application.

And that should be enough to make our application a little bit happier. Yes.

Of course I I'd dump before we move on. I do want to take our old security that
YAML configuration. And copy this over the default secure that YAML
configuration. Unfortunately not much really changed in security so that just
works and we can delete another file delete Security dot YAML the old secure
that YAML.

Guys at this point we're really close. We only have a couple more files to deal
with and then our application is in Flack's. Let's finish this.
