# Twig

Let's dive into Twig. Unless you're building just an API Twig is going to be your best friend. It really is
that awesome to work with and really really easy. Let me give you a very intro to it. 

Twig has two syntaxes. First we have `{{ }}` which is the same something tag and `{% %}` which is the do something
tag. Ultimately if what you want to do is print something, you'll use `{{  }}` and in the middle it will be
either a variable name or quotes around a string. If you want to do something like an if statment, a for tag
 or setting a veriable we'll use `{% %}`. 
 
 Head over to Twig's website at twig.sensiolabs.org, click into the documentation and if you scroll down a bit
 you'll find a list of everything that Twig does. The first thing I want to check out is this Tags column. 
 This is the finite list of do someting tags. Click on `if` and we'll see that we would use `{% if %}`. Also
 check out `set` which is writen `{% set %}`. And check out `for`, as you may have guesse dthat one is `{% for %}`.
 For your project you'll probably end up only using 5 or 6 of these do something tags. 
 
 Twig also has other things like functions, there's the dump function which we'll use in a moment. These look
 like normal functions. And there are these filters which look like fancy functions. For example the 
 `lower` filter where you can echo something, | and then you pipe it into the filter. 
 
 Let's make some things happen in this Twig template. One of the things that our Aquanauts will be able to do
 is write notes about a specific genus which we will then render. 
 
 Create this cool `$notes` variable with some hardcoded text and then pass it into our Twig template. Before we 
 loop over that in our template I want to show you the `dump` function. The same way that you `var_dump` in PHP
 to learn more about a variable, in Twig you `dump`. But you can do this without any arguments. And back in the
 browser when we refresh we get all the information about all of the variables available. Here we can see our
 name variable, notes variable and the app variable that Symfony added which gives you access to some really 
 important information like who's currently logged in. Interesting right? We'll get more into that later.
 
 Inside notes we can expand this, and what we're seeing is the Symfony `var dumper` component which allows us to
 print out really nice variables like this. Always remember that you have access to this nice `dump` function. 
 To print out the notes let's put them in a `<ul>` and we'll need the `for` tag which will look like this,
 `{% for note in notes %}`. `notes` being our variable, and on the other side add an `{% endfor %}` tag. Very simply
 we can now print out each of those notes which is a string.
 
 Back to the browser to see what we've got. Refresh! Well, it's not pretty but it is working. View source on our
 page here, it's still just this html and no base layout, which is the next thing that we're going to want. 
 
 Back in the IDE to get a baselayout add a new first line in `show.html.twig` with the do something tag, 
 called `extends` and we'll use `base.html.twig`. This says that we want `base.html.twig` to be our base template.
 Where does that template live? Remember, all templates live in `App/Resources/views` and look there's our 
 `base.html.twig`. This is a little file that actually came with Symfony and it's yours to customize. 
 
 Let's refresh the browser after just this small change, Nice a huge error! A template that extends another one
 can't have a body... so what does that mean? 
 
 In Twig, layouts work via template inheritance. In `base.html.twig` there's a bunch of blocks. The job of the
 child template is to define content that should go into each of these blocks. For example, if you wanted your
 child template to put content right here, then you'll override the body block. If you want to override content
 up here, then you'll override the title block. 
 
 Right now our `show.html.twig` file is just throwing up content. So Twig is confused because we're telling it
 we want to use `base.html.twig` but it doesn't know where it should put this content inside of base. We want it
 to be right here in the block body, so that is the one that we'll override. Do that by writing `{% block body %}`
 before all of our content and `{% endblock %}` at the end. By the way, the names of these blocks are not important
 at all. You can change them to whatever you want and add as many as you want. 
 
 Now that we've got our template inheritance cleaned up, head back to the browser and refresh. Cool! It's the same
 page, but now it's will the full html source. Once you have a full valid html page the web debug toolbar makes
 an appearance. This includes information about which route was matched, which controller is being executed,
 how fast the page loaded. We'll get into this detail later, for now just know that you can click any of those icons
 and get even more detailed information in the profiler including this amazing timeline that shows you exactly
 how long each part of your application took to render. This is really wonderful for debugging. And we've got details
 in here on Twig, security, routes and other cool stuff. 
 
 Back in our browser we can see that the title on this page is just this boring "welcome". That's because that's the
 title in our base layout. Since it's wrapped in a block called `title` we can override that. How? The same way
 we overrode the body block in `show.html.twig`. The order doesn't matter, I could have put this below the 
 block body tag. Update this to `{% block title %}Genus {{ name }}{% endblock %}`. Back to the browser and refresh!
 Ah ha! There's our new title -- not too shabby. That's it for Twig -- what's not to love?
