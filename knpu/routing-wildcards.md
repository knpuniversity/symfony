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
do you match `/genus/octopus`, do you match `/genus/octopus` and as soon as it finds one route in your system
that matches that URL, it's going to call that controller. 

Right now we only have one route in our system, but if we had a bunch of them it could get difficult to maintain
them and figure out what page is being rendered by what URL. Fortunately Symfony comes with an awesome debugging
tool called the console. You can execute this in the terminal by writing `php bin/console`. This gives you a big
list of commands that you can run against your application. Most of these help you with debugging, some of them
generate code, some clear caches, and the one that we're interested in right now is `debug:router`. 

Let's run that, `php bin/console debug:router`. Nice! This prints out all of the routes in our system. You can see
ours here at the bottom, `/genus/{genusName}`. All those other routes above there, those are just development and 
debugging routes that help with the web debug toolbar and we'll talk about those later. As we add more routes they'll
show up here in a nice list. 

Fun fact, that has nothing to do with sea creatures: you now know 50% of Symfony. Seriously? Was that really hard?
This routing, controller, response flow it's the first half of Symfony. It's the core of it. Now, let's dive into
the second half. 
