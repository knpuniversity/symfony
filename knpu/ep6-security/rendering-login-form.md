# Rendering Login Form

Our first goal is to create a login form. Let's do this the same way we always do by creating a "Route" and "Controller". Create a new class called "SecurityController" to hold security related stuff. We can extend the normal Symphony base controller. Let's make a "public function loginAction", then we'll go to "/login" and we'll call it "security_login". Make sure you auto-complete that route so you get the "use" statement up top. Cool.

Most of a login form is actually just boilerplate code, so I'm going to go and search for "symphony security form login". Find a page called "How to Build a Traditional Login Form" and we are going to steal things.

They also have a login action, so let's copy all of their code and paste that into ours. Notice, one thing is immediately weird. There's no form processing code inside of here. This is going to be the one weird form that you build in Symphony. This endpoint will render the login form, but it will not handle the login form processing. That's handled somewhere else, but thanks to this handy "security.authentication_utils" service, we can access any authentication errors that may have happened during that process and the username that was typed in. We can use that to put it inside of the form when the login form re-renders.

For the template, I'll hit "Option", "Enter" and create that template with a little shortcut. We know we'll need a little bit of code in here, "extends", "base.html.twig", then I'll also add a little bit of markup to get us started. Great. No that's not right. Perfect. The template also has a bunch of boilerplate code, so let's copy that and paste it.

Another weird thing is, you'll notice that this does not use the normal form system. This is just building a form by hand, which you can totally do if you want to. Again, this login form is kind of a weird one. I will update this route name to be "security_login".

This is not doing anything fancy at all yet, but let's go to "/login" and try it out. There it is.

All right, so first problem is it's a little bit ugly, and the second problem is we actually need to hook up the form submitting logic. Resolve the first problem. You'll notice Symphony doesn't have to use a Symphony form system, because you just simply don't have to in this case, security is a little bit different, but I'm going to create one because I already have my form system set up to use all of my nice bootstrap form layout stuff.

In the form directory, I'll create a new form class called "LoginForm". That's because I don't need "getName" or "configureOptions". This form is going to be so simple, we're not even going to bother binding it to a class.

Inside "buildForm", let's add two things, "_username" and "_password", which will be a password type. Those fields could be called anything, but "_username" and "_password" are just kind of a Symphony standard.

Inside of "SecurityController", you can say "$form =$this->createForm|LoginForm::class" and I'm going to pass it some default data as the second argument. Specifically, the security system is going to pass as the last username the user entered. If we're going to pre-populate that on a form, we can pass that here as "$LastUsername". Again, this form is a little bit strange because we're not going to handle the form processing code here in the controller, and this is the first time we've had a form that's not bound to a class, and I basically don't do it in any other situations. Now we can replace "LastUsername" with "'Form'=>$Form->createView".

In the template, first thing I'll do is make our eventual error message a little bit nicer, with "alert alert - danger". Then I'm just going to kill this entire form and replace it with our normal form stuff, so "form_start[form]", "from_end[form]", "form_row[form._username]", and "form_row[form._password]". Don't forget your button! "class="btn"" with "type="submit"". Throw a couple classes on there, and say "login". You can add a little lock icon.

Awesome. Good deal. This is purely so Ryan can get this form looking a little less ugly, and there it is.

Before we finish, let's hook up this login link up here. This is in our base layout. I already have a slot for login. Again, this is just a normal "Route" and "Controller", so we can just link to "security_login". Refresh. Click that link. Here we are.

Login form rendering complete. Now we're going to hook up an authenticator to make this do its magic.
