# Services

Alright! First half of Symfony: route, controller, response - we've got it! Now what's the second half?
Well, that's all about useful objects. Obviously, just returning a string response like this is not going
to take us very far. Our aquanaut deserve more! Sometimes we'll want to render templates, maybe we'll
need to talk to the database, or maybe we'll create objects and have something that turns those into JSON
for our API. 

You can use these optional useful objects, if you want to, from within your controller. For example,
if you want to send an email, Symfony has an object for that. Our goal is simply to understand what objects
are available in Symfony and how we can use them. These objects are commonly called services. So when you
hear the word `service` just thnk that's a  `useful object`. To keep track of all of these services, Symfony
puts them all into one big array called the container. Well, it's not actually an array, it's an object. But
it looks and acts like an array. So, if I give you the container, you get access to any of the useful objects
that you want out of it like the mailer or logger object. 

As soon as you need access to one of the useful objects in Symfony, you're going to extend Symfony's base controller.
In the `GenusController` add `extends Controller` from the FrameworkBundle. And I'll hit tab on that to get autocomplete
and the use statment. 

What we want to do first is render a template. In this project we'll render some templates in HTML and we'll
build an API on the side so that you'll get both aspects. 

If you want to render a template, the useful object you need is called templating. Here, add `$templating = ` 
and then get that off of the container. As soon as we extend Symfony's base controller we can type 
`$this->container->get('')` and then we use the nickname of the service object that we want. In this case
it's called `templating`. 
