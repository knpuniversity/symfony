# Start Project

Welcome! I'm really excited that you are learning Symfony, it's the hardest framework you'll
ever use! Just kidding! Symfony has a reputation for being really hard, and part of what I want
to show you is how that is not the case. Symfony can be incredibly simple. But, when it does get
a bit more difficult it's because you're learning best practices and object oriented stuff. In this
series we'll ease you into those topics. Our first goal is to get you productive with Symfony as quickly
as possible. 

What is Symfony anyways? It's just a set of components, which just means 30 small PHP libraries. That means
that you could use Symfony in your project today by using one of its little libraries. One of my favorites
is called Finder, it's really good at locating files within a directory structure. 

Symfony is also a framework which means we've taken all of those components and glued them together for
you so that you can get things done faster. This series is all about doing *amazing* things with the
Symfony framework. 

In the background one of the things you'll notice is that Symfony is all about standards and best practices.
As you're building your dream project you're also becoming a better developer in the process. 

Let's get our first Symfony project going. Head over to Symfony.com, click 'download'. Our first task here
is to get the `Symfony Installer`. Depending on your system it's just going to be a couple of commands.
I'm running on a mac so I'll copy this `curl` command, paste it into the terminal and then grab the
second command here to adjust some permissions. 

This now gives us the Symfony executable. Let's be clear, this is not Symfony, it's the Symfony Installer. 
This installer is a small utility that makes it really easy to start new Symfony projects. 

Let's start one! How about `symfony new` and then the  name of our project. For this series that is
`aqua_note`. In the background this is downloading a new Symfony project, unzipping it, making sure
your system is ready to go, warning you of any problems that have and then dropping it into this `aqua_note`
directory. Not bad!

Move into it to check it out. If you wanted to call your project something else just rename the directory.
Before we get into all the files and structures let's get this thing going! Run `php bin/console server:run`
to run the built in PHP webserver. 

As the comments say here, we can just go to localhost:8000 in our browser to see how our new site is looking.
Congratulations! This is your first Symfony page. This isn't some static demo page, this is a rendered page
from the files inside of our project. And at the bottom here we have the fantastic web debug toolbar, which
we are definitely going to dive into. 

Now to build our first page in Symfony!
