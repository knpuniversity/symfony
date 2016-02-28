# Using a Service

Ok! Let's see if we can use this new service. First, some setup: in the template,
remove the fun fact text and move it into `GenusController` by creating a new `$funFact`
variable:

[[[ code('e2e900623f') ]]]

Let's make things interesting by adding some asterisks around three-tenths -
Markdown should eventually turn that into italics.

Pass `funFact` into the template:

[[[ code('88f95695ac') ]]]

And render it with the normal `{{ funFact }}`:

[[[ code('7f862d068f') ]]]

When we refresh the browser, we have the exact same text, but with the unparsed
asterisks.

Now, how the heck can we use the new `markdown.parser` service to turn those
asterisks into italics?

## Fetch the Service and Use it!

Remember: we have access to the container from inside a controller. Start with
`$funFact = $this->container->get('markdown.parser')`. Now we have that parser
object and can call a method on it. The one we want is `->transform()` - pass that
the string to parse:

[[[ code('5ed51a7da2') ]]]

So.... how did I know this object has a `transform()` method? Well, a few ways.
First, PhpStorm knows what the `markdown.parser` object is, so it gives me autocompletion.
But you can always read the documentation of the bundle: it'll tell you *how* to
use any services it gives us.

Ok team - time to try this out. Refresh! And hey, it's working! Ok, it's not *exactly*
working. Open the page source: it looks like the parser is working its magic, but
the HTML tags are being escaped into HTML entities.

This is Twig at work! One of the *best* features of Twig is that it automatically
escapes any HTML that you render. That gives you *free* security from XSS attacks.
And for those few times when you *do* want to print HTML, just add the `|raw` filter:

[[[ code('15d882d247') ]]]

Refresh again: it's rending in some lovely italics. 

## Fetching Services the Lazy Way

One more thing! We can actually do all of this with *less* code. In the controller,
replace `$this->container->get()` with just `$this->get()`:

[[[ code('f5d19a0078') ]]]

This does the same thing as before.

Ok: here's the *big*, giant important takeaway so far: why do we add bundles to
our app? Because bundles put more services in our container. And services are tools.

So my question now is: how can we configure these services so that they do *exactly*
what we need them to?
