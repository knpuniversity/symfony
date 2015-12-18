# First Page

To work on our project I'm going to use PHPStorm as my IDE. This is by far the best editory for working
Symfony. I'm not even getting paid to say this, but I would still highly recommend that you try it. Which
is too bad, because it's not free. But there is a free trial for you to enjoy. Download it and follow along
with me.

To use PHPStorm and really have fun with Symfony, you'll need the Symfony plugin. Go into preferences, search
for Symfony and click on the plugins option. From there click the 'browse repositories` button, and that will
bring up a window where you can find the Symfony Plugin. You'll recognize it as the one with over 1.3 million
downloads. I already have this installed, but if you don't you'll see an `install plugin` button up here,
click that and then restart PHPStorm to get the plugin. 

Once that's all finished head back into preferences, search for Symfony again, and now there's a Symfony Plugin
option in the list. Click that and make sure the box next to "Enable Plugin for this Project" is checked. You
only need to do this once per project and you'll get all kinds of great Symfony IDE magic. 

Oh and also make sure that these paths say `var/cache` instead of `app`. If you're interested in more PHPStorm
tricks we have an entire screencast on it for you to enjoy.

On the left we have our project directory structure, before I dive into that let's get a git repository going.
In the terminal this tab is running our built in PHP web server so I'll open up a new tab, run `git init`, and then
run `git add .`. Symfony comes with a `.gitignore` file which already ignores all of the files that you can ignore
at first. Let's commit, give it a message and there we go!

The task is to build our first real page inside of Symfony. Stick with me, because we'll be building this and
little by little figure out how Symfony actually works behind the scenes. 

Earlier we saw this page which is coming from our application. It's coming from this default controller right here.
Just delete that. Now we're starting from scratch! Now if we refresh, boom! No route found for /. That's
Symfony's way of saying "Yo! There's no page here.". 

To create a page in Symfony, or really in any web framework, it's two steps. Create a route, which is the URL for
your page, and then a controller which actually builds that page. Our project is called AquaNote, it's a research
database for Aquanauts. These cool underwater explorers log their discoveries of different sea creatures to this
riveting site.

Our first page will be showing us details about a specific genus, for example, the octopus genus. To get this
started we'll need to create a route. This may seem weird but we'll start by creating a controller class in the
`AppBundle/Controller` directory. Let's call this `GenusController`. Clearly, this is for a page that will be 
showing us genus information. Notice that the namespace here is empty, hit escape, right click on `src` and hit
"mark directory as sources route". What that does is when I go back here next time, and type `GenusController`
it automatically fills in the namespace of that class for me. If namespaces are new for you take a quick
break here and go watch our tutorial that explains them in only 120 seconds. 

The most important thing to know here is that your namespace must match your directory structure. Without
this Symfony won't be able to find this class. 

Ok back to our first page, we need to create a route. To do that, create a new `public function showAction()`.
The name of this method is not important. To create the actual route I'll use annotations which are comments
above the actual function. `@Route` and I'll let the IDE autocomplete this from the `FrameworkExtraBundle` by
hitting tab. This adds the use statement for me at the top of the file for this annotation. That is very important.
to the route annotation add `"/genus"`. Beautiful, that's our route. 

Step 1: create the route, which is the URL, check! Step 2: create teh controller. The controller is a fancy
word for the function you build that creates the page. And in this case the controller function is the function
that is below the annotation. This can be named whatever you want. The only rule of a controller function is
that you need to return a Symfony response object. Let's step back a second, our only job as a developer is to
understand an incoming request and send back a response which would be HTML, JSON or whatever you want. Let's
keep things simple here, `return new Response` and the response class you want is from `HttpFoundation`, once 
you're highlighted on that one hit tab to get our use statment added for us. And for our response let's return
`'Under the Sea!'`. That's it!

We've created one file with one function, we have our route, our controller and lots of sea floor to discover.
Let's go try this out! If we refresh this page, which is the homepage, it's not going to work yet. But if we
navigate to `/genus`, boom! Congratulations, that's your first page in Symfony done in about 10 lines of code. 

In the IDE we can see that there's nothing special about this controller. We're not extending some Symfony based
controller, it's very simple. We just need to return a Symfony response object. Obviously as this site progresses
we'll get a lot fancier with how we do things. 

This is even a really simple url `/genus` but what I really want is to go to `/genus/` and then the name of
the genus, like octopus and then we can dynamically load information based off of that. 

Now, this is just a hardcoded URL let's see if we can get a little bit fancier.
