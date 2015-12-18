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

To create a page in Symfony, or really in any web framework, 
