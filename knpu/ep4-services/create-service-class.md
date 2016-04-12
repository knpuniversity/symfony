# Creating a Service Class

Ready to move a chunk of code *out* of the controller? Well good for you.

Step 1: create a new PHP class. In `AppBundle`, I'll create a new directory called
`Service` - but that could be called *anything*. Inside, add a new PHP class called
`MarkdownTransformer`:

[[[ code('95eb06ced4') ]]]

If you're keeping score at home, that could *also* be called anything.

Start this with one public function `parse()` with a `$str` argument:

[[[ code('58b705cfbc') ]]]

Eventually, this will do *all* the dirty work of markdown parsing and caching. But for now...
keep it simple and `return strtoupper($str)`. But use your imagination - pretend
like it totally *is* awesome and is parsing our markdown. In fact, it's so awesome
that we want to use it in our controller. How?

Find `GenusController`. First, create a new object with `$transformer = new MarkdownTransformer()`:

[[[ code('a6d14358cf') ]]]

Noooothing special here: the new method is *purposefully* not static, and this means
we need to instantiate the object first. Next, add `$funFact = $transformer->parse()`
and pass `$genus->getFunFact()`:

[[[ code('55ebc031f8') ]]]

And that's it! If you're feeling massively underwhelmed... you're right where I want
you! I want this to be boring and easy - there are fireworks and exciting stuff later.

Finish this by passing `$funFact` into the template so we can render the parsed version:

[[[ code('be1a088f41') ]]]

Then, open the template and replace `genus.funFact` with just `funFact`:

[[[ code('6953771998') ]]]

Try it out: open up `localhost:8000/genus` - then click one of the genuses. Yes!
The fun fact is *screaming* at us in upper case.

So believe it or not: you just saw one of the most important and commonly-confusing
object-oriented strategies that exist anywhere... in any language! And it's this:
you should take chunks of code that do things and move them into an outside function
in an outside class. That's it.

Oh, and guess what? `MarkdownTransform` is a *service*. Because remember, a service
is just a class that does work for us. And when you isolate a *lot* of your code
into these service classes, you start to build what's called a "service-oriented architecture".
OooOOoooOOOo. That basically means that instead of having *all* of your code in big
controllers, you organize them into nice little services that each do one job. 

Of course, the `MarkdownTransformer` service isn't *actually* transforming... any...
markdown - so let's fix that.
