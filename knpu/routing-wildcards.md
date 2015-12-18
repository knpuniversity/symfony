# Routing Wildcards

We've got our first page, but it's got a really boring hardcoded URL. What our aquanauts deserve is
a dynamic URL, something that can handle `/genus/` name of the genus. Like `/genus/octopus` or `/genus/hippocampus`
which is the genus that sea horses belong to. Oh man, sea horses are cute. 

All modern frameworks, including Symfony, can handle this. The way it's done is by adding `{genusName}`. This
`genusName` part could be named anything, the important part is that it is surrounded by curly braces. As soon
as you do that you are allowed to have a `$genusName` argument to your controller. When we go to `/genus/octopus`
this variable is going to be set to octopus. The important thing is that the routing wildcard matches the variable
name.

To test if this is working let's change our message in the response to `'The genus: '.$genusName`. Head back to the
browser and refresh. Hey look a 404, that's because our URL is no longer `/genus`, it's now `/genus/something`. We
have to have something on the other side of the URL. So let's throw octopus on the end of that and there we go
our new message is showing. And of course we could change this to whatever we want. 

Let's see what happens if we change the wildcard or the variable so that they don't match up. Back to the browser
and refresh, ooo look at this error. It's a pretty common one that says "Controller showAction requires that you
provide a value for $genusName argument". What Symfony is trying to tell you here is: "Hey fellow ocean explorer,
I'm trying to call your showAction, but I can't figure out what value to pass to `genusName` because I don't see
a `{genusName}`. Just make sure those always perfectly match so that eveything will work as expected.

When you refreshed the page here, Symfony goes across all of the routes in your system, look at each one and say
do you match `/genus/octopus`, do you match `/genus/octopus` and as soon as it finds one route
