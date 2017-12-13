On the home page you only have these two strange whining deprecation left. So
one of the best things that changes 54 is on wiring the logic. We talked about
this in our symphony 343 started. In fact one of the biggest steps towards
upgrading the symphony for the new Flex directory structure is upgrading your
services down. Why now file to use the news services. Seventy three point three
auto registration and all the wiring stuff. So we haven't done this. First I
want to actually stop go through our seventy three point three upgrade tutorial
and get your product set up first. To have this stuff. Once you're done with
that step. You're actually much closer to upgrading system before and flock's.
Now X in symphony 3. The way our wiring worked. Is that you typing classes or
interfaces. And then you would basically go through the container and try to
find any services that use that class or implement that interface.

Similarly with first look to see if there's a service that exact class Horak
interface a service or an alias but then it would fall back to looking through
the entire container one by one and looking to see if any services implement
that class. Extend that class or implement that interface. Is sufficient for
the logic is much simpler. All right and worst by looking at the TypePad and
looking to see if there is a service in the container with exactly that name
and that is it. Is there's no magic it's super simple. So certainly three point
four if you've been using wiring some of your deprecation messages are actually
going to be related to. Using our wiring via the old logic. Honestly the best
way to fix this is to go and your candidate can figure out why I'll file in 100
predators.

Add. Container dot auto wiring that strict underscoring truth. That basically
says use it only these Seventy-Four are wiring logic right now. That means that
if you're using the outer wiring logic. Then you're going to get a huge
exception. This is a great way to find it where you're using those. It's even
more obvious than using deprecation. And also these two deprecates notices are
actually false positives. There is nothing to fix. It's just due to an issue
with House Symphonie tries to wire controller arguments. Otherwise. As soon as
you set that parameter and refresh. Our true definition notice has completely
disappeared. And if you were relying on any of the or all wiring logic then you
would actually see an exception.

We've already upgraded our app not to use the old auto wiring logic. Okay. So
at this point we're in great shape. Let's step around a little bit and see what
other deprivations we can find. No deprecation on this page. So long as we ride
plus you Malakar password. Turtles. And they go to flash genius. Can look at a
genus.

Finally we have one of the deputation.

Interesting. Check this out. The Locker's service is private getting out from
the containers deprecated since 73 to fail point. Oh you should either make the
service public or stop using the container directly. And this is coming from
arguin as the controller 184. Souls quote a few files. And then go into Jenas
controller. And it does not apply with this line here. So this is a really
important thing. You remember from seventy three point three. That we're
actually now meeting all of our oldness services private so public. False.
Which means when we do this it allows us to optimize the container and really
cool waste but it means we can't say this aero container aero get this aero get
that service ID in before that's been extended to a lot of horse services.
Basically we want you to stop getting things out of the container anywhere.
What's the solution. The same with everything else auto wiring. So here we can
just add a longer interface. Type patch or controller.

And then say our aero info. It's that easy. As soon as we refresh that page.
The. Deprecation is gone.

Somewhere else. Already using container air. Get. A grant. Corrugate grant for.
The get method. Smy. Find some other uses of it that aren't container and your
project in mind just shows B.S to have a security controller and user
controller.

Says open security controller. And here it is right here. Security
authentication Utos. So what can we replace that with. The easiest way is to
use the brand new debug wiring command. This is. Awesome. It gives you a big
list of all of the type that you can use in your application. For all wiring.
And. Research for authentication.

There it is.

This is the type that we can use Persichetti the authentication tools which we
probably could have guessed. So means we can go back and just delete this line
and say authentication Eutelsat authentication utils. And then the last spot
isn't that a user controller.

And it's instead of here we're using the security authentication. Gardner
handler. It was the same thing. Up here folks asked guard. Authentication
handler. Gahr handler. This time I just guess what it was. You could have also
looked it up. And then use that down there. Now in some cases especially. In
some third party Bongo's that. It's possible that there might not be. It's.
Possible there might not be an all wire able.

Class or interface for something yet. If that's the case it's no problem. Just
remember how our wiring works. You just need to create an alias.

To the service. So. This guy didn't exist. So we wanted to we you very simply
go into our services file. That's the bottom. We can create an alias from that
class name or interface. To the target service. With apps and then the name of
that service.

I'm going to comment that out because that's redundant that's already been done
in the court for us. But you always have control over what classes are all
wired. Kovak. Refreshed. And at this point you just need to surf around on your
site and figure out who you are any more deprecation. It's not exactly a
science. In fact I know my registration page there is one last application.

User called form is valid with the onset of form is deprecated use form is
submitted instead. And this is coming from our user controller. So does that
user controller. You can search for is a valid ID. There's actually 2 movies in
74 percent Boskoff form is submitted first and that is valid. I find it again.
So you can also get that up and register action. And. I. Guess. That's the
deprecation. Are Gone.

If you have a big project it might take more time but it's a relatively easy
thing to do. This means we are ready already to upgrade to symphonies 4. Which
by the way is the fastest symphony version ever.
