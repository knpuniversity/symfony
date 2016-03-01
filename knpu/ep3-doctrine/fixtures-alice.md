# Delightful Dummy Data with Alice

Now
here's where things get really really fun. We also installed another bundle.
Google for Nelmio Alice and find their GitHub page. So here's what this library
is. This library allows you to write Nelmio files and create fixtures that way.
It has a really really expressive syntax, and it also has a bunch of built in
functions that generate random data. It actually uses another library called
faker for all of those random data functions. So in that same ORM directory
now, we're putting in a file called fixtures dot YML, and start with the class
name that we want to add. So, app bundle slash entity slash genus. Let's create
10 genuses. So we'll give each one an internal name. This doesn't matter. But
instead of doing 10 whole entries, we can actually use this cool syntax where
we say genus underscore one dot dot 10, and just by doing that it's actually
going to loop over and create 10 genus objects. And below that, we're going to
put the names of our properties. So name, colon, and it'll actually use a built
in faker function called name, and then sub family, use another built in faker
function called text 20, and the functions are denoted by having the less than
sign, the name of the function, and the greater than sign. And then species
count, we can use a function called number between 100 and 100,000, and then
fun fact, we'll have faker do a random sentence, and that's it. To use this
file, you can actually get rid of all our code inside this function and simply
say fixtures, auto complete that, load, and it'll pass it the files we want.
Which is underscore underscore DIR underscore underscore dot slash fixtures dot
YML and then past the entity manager is the second. And run fixtures is the
exact same command. So run that, but now refresh your list page, and viola, we
have 10 completely random genuses. Now the name of every genus is actually the
name of a person, which is pretty ridiculous, so we'll fix that in a second.
But real quick, in Nelmio's documentation, there's a lot of examples of crazy
things you can do inside of here. One of the biggest things that you're going
to want to look at is actually the faker library that it integrates, because
it's going to tell you all of these built in functions that we were just
creating, like a number between, random word sentence, and all of that. So a
lot of tools here built in automatically. Now if we can just make the genus
name a little more realistic.
