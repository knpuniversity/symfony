Let's look at our project. Most of our old code was an app config and also
asters the app Andeel. We'll talk about this later. It's actually easier. Those
are just ph classes. Most of what we need to migrate is our old configuration.
It's a bit slow and tedious but the end result is totally worth it.

Start and can figure out why.

So the premise of those parameters we've done and then were to go into the new
directory structure which is going to be config slashed services that YAML.
That's where your parameters and services should live in space. Those there we
can actually move the container our Wangchuk mode because that's on by default
and since 24 perfect.

Let's keep going. Backing can figure out why out. We're going to go through
through the framework first which is by far the most complicated one. Now in a
symphony like structure each package has its own configuration. So

actually the file that we are going to be moving this to is config packages
framework.

Yemen.

So first BSI we can just remove because inside Brehmer dynamic it's also
commented out. The secret is set to app is set to the end v app on the secret.
This is a relatively new syntax that reads from environment variables. So
McNevin Bayamon. This is reading from the dot and b file where we have an app
Secret set to this value so we don't need to read it from a parameter anymore
so we can just delete that. That's basically already taken care of for us up
here. Now the next one is translater. So the question is should we copy this
config and move it into Frerichs YAML. Because there is no translator and
actually not exactly a lot of the features under framework actually represent.

Symphonie components that you are activating. There is actually a symphony
translator component and guess what it is actually not installed right now. So
the first thing we need to do.

Is install your terminal and run opposer require translator. Now if that looks
funny to you it should. There is no package called translater. However as you
can see that I actually added a new Symphonie slash translation line into are
composed at a Jaison. This is one of the superpowers of flex.

If you go to Symphonie dot sh you'll see the symphony recipe server. This

is a long list of all of the packages and bundles out too that have simply
recipes your search for translation you'll see the simply means less
translation. It actually has a couple aliases which basically means we can
report we can refer to this Agonistes translation of translations or translator
and simply Boisseau figure out what we mean. Now as you're adding things with
Symphonie flaps it's a really good idea to commit first actually committed
before I started recording this specific video. The reason is is that after it
runs your recipe. It's pretty fun to be able to say good status and see what it
actually modified. In this case it actually created a new translation that yaml
file a translation's directory which is where translations live and Symphonia
for. So even though in 73 the config lives in a framework. This actually has
its own configuration file called translation dot YAML. And you can see exactly
why translations live at the root of your project. It's just in your config.

So do we need to move over our transit or stop. Actually no because all of it
is already here so we can just remove that and actually now that we know our
translations should live at the root of our project and a flex application.

I actually do have a couple of translations and app resources translations. I'm
going to move this validators that unit Y amount down into translation's room
and then delete that translation's directory.

Yes progress all right let's keep going.

What about the robbers stuff. This was basically conveyor belt said load it
rodding down YAML. While the routing stuff is already set up for you to
Symphonie for application you can see it as a route's dight YAML. There's
actually even a route's subdirectory for other packages can load other routes.

The point is that there's even as far as routing config configuration of the
routes there is a routing that yaml file and even an environment specific
routing that yaml file which changes that strict requirements. The point is
routing is one of those things that is all set up for you so we can just delete
that. All right let's keep going.

It forms our application is using similes form components so that means we do
need the form and like the translator It's actually something we didn't stop.
We're also using the validation system which is also its own components. So I'm
going to move to my terminal.

And composer require form in validator which as you can tell are also aliases
and a lot of the time you can just guess what the alias is. Perfect. So install
those components. So the question is do we need these two lines I can think the
answer is actually no. And the reason I know that is because we can run pin
console debug config framework and this will show us the current the current
configuration under the framework key and you can search for form.

You'll see that the form is enabled which means we do not need to add extra
configuration to enable it. This is a really common thing in symphony 4. As
soon as a component is installed it's automatically enable. Don't need extra
configuration to go and enable it.

Validation is actually even cooler search for validation. You can see it is
also enabled and it has enabled annotations set to your so we do not need this
validation config either. In fact the reason that they now enable annotations
is automatically set to true.

Is that the doctrine annotations packages already installed so you can see it's
turning on and just automatically as things are installed.

All right it might not look like it but this went. We're almost done. If you
search for a default locale that actually defaults that's already set to end.
So I'm actually going to just remove this config here. I don't need to move it
over here at all because it's the default value. If you want to change it.

Or set it to your locale parameter. That's totally fine but it's not necessary.

I'll close a couple of files because I want to keep comparing. I can figure out
why Bill and my framework that YAML so you can figure out why until we have
SEUS our protection activated. So infirmaries I am LEDs uncomment out SEUS RF
production.

And then we can remove it from here.

Let's also remove serializer. I'm not using serializer but if I were I would
want to composer repliers serializer. Driving's now.

Been consul. They are so broken CSR support cannot be labeled as the C security
c s as our opponent is not install.

So this shouldn't be too surprising because as we've seen most features under
framework actually need to be installed. So if you move over to.

Submitted age in search wiseass or Eichten you can see a security dasht CSR
package. Let's go and run composer require baggage. And actually.

This configuration inside of framework that YAML shouldn't be necessary.
There's a small bug in symphony in the future just by having the CSR.
Protection. Package install the feature will automatically be enabled. Right
now we need that config.

Dowds package and. Another air C as our eye protection needs sessions enabled
which makes sense. With Fleck's everything is opt in.

So if you want sessions this case is actually a little bit weird. Unlike some
of the other features it's not a separate package it's just some configuration
that you need to comment out. So I'm not uncommon. This section here. Now
notice in simply three point three we had slightly different config because we
recommended storing the sessions in the VAR session directory. You can still do
that but it's no longer the default config. Instead. The new config allows ph
to store it in whatever place it thinks is best.

Or remove our old session configuration. We don't need it anymore. And now.
Let's try and console. S. Everything works.

So the next thing on this list is templating Ms activity symphonies template
and components which still exists but it's not recommended anymore. Instead you
should just use Twitter directory. So I'm going to remove. All of this template
configuration but our application does use tweak. So I'm going to move over to
my terminal and run composer required twitt. So. I'm. Gonna move over to my
channel. Before I run this I'm actually going to commit.

And then run composer require tway. Now I'm doing that so that we can see what
changes this recipe makes.

Now by removing the templating component just means you can't use the
templating service explicitly which you're probably not anyways. Cool.

And you can see this install the tweak bundle and install the twig bundle
recipe. If we do get status data did a couple of really cool things. First like
Flagstar as. It automatically enabled the bundle in bundled up each week. So we
don't need to worry about Navalny Nippon. It also added a twig dot yaml file
with the tweet configuration. This is almost the same. Now you see right here
that by default inflects. Cumquats are actually stored at the root of the
project and hey it even created a templates directory forests which is awesome.
Now this config is almost the same as our tweak config. Except for these last
few lines here so I'll copy those we deal tweak configuration. And paste them
at the bot. Another cool thing the rest we did in this case was it actually
installed.

Some routes that are only accessible in the dev environment and these are the
routes that help you debug what your error pages look like. So all this stuff
just taken care out of the box. Now since our templates live in a template
directory wots move them there. So go to app resources views. And copy of all
the contents in their. Hastened down in the templates. We do want to override
the base that each time locked away with our own. Perfect. Them and go up and
completely remove my app resource use directory which actually means I'm going
to remove the resource directory. So Appian big directory is getting really
small. All right. Last things here to think that why now.

Trust that holds fragments and AC method override. You can remove all those.
Because if you look in debug config framework. Actually.

You know what.

You can remove all of these within a framework diameter. We're going to
uncomment out fragments. If you look if you're in debug config framework you
would actually see. That the other values are actually the defaults e.g. method
override is already set true and trusted host is already set to empty. Array.

That leaves us with just one last line in config that Y which is assets. Guess
what. This is actually enabling the asset component. So the first step is to
run. Because if you look right now the asset component is enabled false inside
of our framework. But if you run a composer require asset. When it finishes. It
installs the asset components. This case there is no recipe generated. But when
you run debug config framework again. And search for asset now it is enabled
trews automatically enable itself. Once it was their genes we can remove
brainwork assets. That is the biggest worry right there for converting to the
Flex frameworks structure. Next we need to continue it for the individual
bundles but this ends up being actually pretty easy.
