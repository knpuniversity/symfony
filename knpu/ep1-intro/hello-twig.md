# Twig: For a Good time with Templates

Unless you're building a pure API, Twig is your new best friend. Rarely do you find
a library that's this much fun to use. It's also really easy, so let me just give
you a quick intro.

## {{ SaySomething }}, {% doSomething %}

Twig has two syntaxes: `{{ }}` - which is the "say something" tag - and `{% %}` -
which is the "do something" tag. If you're printing something, you aways write `{{`
then a variable name, a string or any expression: Twig looks a lot like JavaScript.

But if you're writing code that *won't* print something - like an `if` statement
a `for` loop, or setting a variable, you'll use `{% %}`. 
 
Head over to Twig's website at [twig.sensiolabs.org][1], click Documentation and
scroll down. Ah, this is a list of *everything* Twig does.

Look at the Tags column first: this is the short list of *all* "do something" tags.
Click on `if` to see some usage. Do something tags are always `{%` and then `if`
or `set` or one of these "tags". The `for` tag - used as `{% for %}` is for looping.
You'll probably end up only using 5 or 6 of these commonly.

Twig also has other things like functions... which are exactly like functions in
every language ever. Filters are a bit more interesting: check out `lower`. Really,
these are functions, but with a trendier syntax: just print something, then use the
pipe (`|`) to pass that value into a filter. You can have filter after filter. And,
you can create your own.

## The dump() Function

Let's make some magic happen in our Twig template. Our Aquanauts will take notes
about each genus, and those will render on this page. Create a cool `$notes` variable
with some hardcoded text and pass it into our Twig template:

[[[ code('9b556285f8') ]]]

But before we loop over this, I want to show you a small piece of awesome: the
`dump()` function:

[[[ code('9688c01ce3') ]]]

This is like `var_dump()` in PHP, but better, *and* you can use it without *any*
arguments to print details about *every* available variable.

Refresh the browser! There's the `name` variable, `notes` and a bonus: `app` - a
global variable that Symfony adds to every template. More on that in the future.
With the `dump()` function, you can expand the variables in really cool ways. Oh,
and bonus time: you can also use `dump()` in PHP code: Symfony gives us that function.

***SEEALSO
See more usage examples of the `dump()` function in [The dump Function for Debugging][2]
of the separate Twig screencast.
chapter.
***

## The for Tag

To print out the notes, add a `<ul>` and open up a `for` tag with `{% for note in notes %}`.
Close it with an `{% endfor %}` tag. Now, it's simple: print out each note, which
is a string:

[[[ code('b0d9573c83') ]]]

Back to the browser to see what we've got. Refresh! Well, it's not pretty yet, but
it is working. Open the source: it's still *just* this html, there's no HTML layout.
Time to fix that.


[1]: http://twig.sensiolabs.org
[2]: https://knpuniversity.com/screencast/twig/functions-filters#the-dump-function-for-debugging
