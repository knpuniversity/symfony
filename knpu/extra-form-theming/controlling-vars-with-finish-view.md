# Controller Variables with finishView

Close up those classes and I'm going to ask a very simple question. I know I
set a help variable inside of my twig template, but could I set that help
variable inside of my form class? The answer is yes. The way to do it is by
overriding another method inside this class called finished view. Either go to
code it generates or Command N, it's like override methods and select finish
view. There's actually two methods that are called when your form has turned
into a form view object. They're subtly different so don't worry about it, but
in this case you want finish view. You don't need to call the parent function.

Now check this out. We can say view [ and let's set the funfact field. Fun
fact>bars>help= then we'll type a message. For example, "leatherback sea
turtles can travel more than 10,000 miles every year." Let's break this down.
When this form class has turned into a form view, Symfony calls this finished
view function at the end. Remember, our form is a big tree. Our form view on
top has sub-form views for each field. The way you can access that is by saying
view[funfact.

In fact, inside of your form template when you say genusform.funfact, genus
form is a form view object, it may seem when you say .funfact that actually
reads the funfact array key off of that object. In other words, those two
syntaxes are exactly the same. Then we say >vars which is a public array
property and we add a help variable to it. All in all when we're done this sets
the view variable.

Now it's up to one level difficulty bigger. I'm going to copy my stream but
then comment this function out because here's what I want to be able to do. I
want to be able to go up to my funfact field past no as the second argument so
it keeps guessing my form type and then pass it in a help option. I want this
to ultimately set a help variable. If I did this now, huge error because as I
mentioned earlier, there is no option called help. It's invalid to pass that. I
want to make this work for every field in my system. Let's do it.
