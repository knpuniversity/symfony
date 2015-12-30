# Loading CSS & Js Assets

We have an HTML layout.  It’s just a little boring, so let’s spice it up.  If you downloaded the code for this project, in the start directory, you’ll find a tutorial directory.  I’ve already copied it into our project here.  This has some files that we’ll use in our project just to help get things looking a little bit better.

First thing, in the web directory, copy the four directories into web.  We’re not doing anything fancy with front-end assets in this screencast.  We just have css, images, js, and then some vendor files for bootstrap and fontawesome.  Now, we’re moving those into the web directory because the web directory is the public root.  Anything in web can be visible to the public.  If you’re not in web, then you’re not visible to the public.

Once you’ve done that, go into the app directory and grab a new base layout.  Let’s paste that, overwrite the original, and open it up and take a look.

So, obviously, we wanna include some of the CSS and JS files that we just put inside of our web directory.  And, out of the box, Symfony doesn’t care about your assets.  It just wants you to take care of them yourselves.  However, I want to show you two things.  First of all, notice that the CSS files are inside a block stylesheets.  Really, technically, that does nothing.  You don’t have to do that.  But, as you’ll see later, if we wanna add page-specific CSS files, by putting the main ones inside this block stylesheets, we’re gonna be able to override the block and add our stylesheets below.

So, if that doesn’t make sense yet, it’s cool.  That’s okay.  Just know that it’s a good practice to put CSS inside of your stylesheets.  And then at the bottom, I have my JavaScript inside of a JavaScript block.  It just gives you a little bit more flexibility.

Second thing.  When we refer to any static asset in the system, we use a special twig function called asset.  And asset is one of the most underwhelming things you’ll ever hear of in Symfony.  So, basically, instead of just hardcoding the URL, we use asset, and then we put the path to the CSS or JS or image file, relative to the web directory.  So, vendor/bootstrap/css/boostrap.min.css, and that’s it.

Now, what does that do?  Well, out of the box, really, nothing.  It does have a little magic behind the scenes in case your project is deployed to not the root of your domain, like mycoolsite.com/symfony, that’s where your project is located.  But the most important thing the asset function does, it allows you later to configure a CDN.  So, if you use the asset function, you can go to one configuration spot in your code, tell Symfony that you have this awesome CDN over here, superfast.cdn.com, and it will automatically prefix all of these with the host name to your CDN.  So, asset function is really not important, but we use it when you refer to static files.

Other than that, this is exactly like before.  We have the block title, we have our block body down the middle, we have block javascripts.  We just filled it in with some cool stuff.

Last thing, grab the show.html.twig and use that to overwrite ours.  And same thing, it’s just like before.  It extends base.html.twig.  We’re still printing out the genus name.  We’re still looping over the notes and printing them out, but we have a little extra markup here to spice things up.  And notice, once again, when I’m referring to a image this time, I’m using the asset function.

All right, so, let’s check that out.  Refresh.  Boom!  A lot prettier.

We talk more about asset handling in other screencasts, but for now, that’s all you need to know.  Simple.

