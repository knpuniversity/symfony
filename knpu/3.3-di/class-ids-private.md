# Class ID's Private

Now before Symphony 3.3, our service IDs typically looked like this. They were sort of in underscore, lowercased version of a class name. In Symphony 3.3, that's still totally legal but the best practice has changed to actually make your service IDs equal to your class name when possible. Sometimes, as we have down here, you have one, two services that actually point the same class. Those are gonna be handled a little bit differently and we'll talk about that.

So I'm actually gonna copy the app.markdown_transformer old service ID. Instead, we can say AppBundle\Service\MarkdownTransformer. And when your service ID is your class name, you can actually remove the class key to shorten things.

Now of course, when we do that, we broke our application. Anything that was using the old service ID is not gonna work anymore and of course, we could hunt the right code and find those, but I wanna show you the safest way to upgrade to the new format. And then later, we're gonna clean some things up and get rid of those old references.

But a really quite great way to safely upgrade is to create a new file in your config directory called legacy_aliases.yml. Inside here, I'll add normal services key and then I'm going to paste the old service ID and say '@'. And then Imma go over here and copy the new service ID and then paste that there.

This creates something called a service alias. This is not a new feature in Symphony 3.3, though the syntax is new. A service alias is like a symbolic link. Anything in our code that references app.markdown_transformer will actually receive the AppBundle\Service\MarkdownTransformer service. This means that our code will not be broken. And little by little, we can remove references to this old service ID.

Now this file's not automatically loaded so the top of service.yml, I'm gonna add an imports and here we're gonna import legacy_aliases.yml and everything should work just fine.

So I'm gonna repeat that for all the other services and honestly, when we upgraded [inaudible 00:02:48] University, this was the most tedious part of the process. Going one by one, copying the service ID, copying the class name, and then putting it into our legacy_aliases. If you want, you can write a little script that will parse through and help you do this. It's up to you.

Now I've noticed for the LoginFormAuthenticator, there's no configuration left so you can actually put a tilde.

Perfect.

Now one of the other reasons that we're making this change is that it's going to help with autowiring and we're gonna talk more about that later.

Now of course, these two at the bottom, these services are a problem, we can't make the ... ID the class name because this is used in two places. When you encounter this, you should use the old way of naming your services which is an underscored version of things.

So at this point, we haven't changed anything other than we have changed to this new standard of using service IDs but thanks to our legacy_aliases, our application still works without touching any other files.

The last change we're gonna make here is under defaults to add public: false. And this is a critical change in Symphony 3.3. This idea of public services being public: true or public: false has existed for a long time in Symphony but it hasn't been a widely used feature. Now that we have public: false under defaults, every single service in this file is public: false. That means that you cannot fetch these services directly from the container. For example, I can't say container arrow get AppBundle\Service\MarkdownTransformer.

The only way I can use the AppBundle\Service\MarkdownTransformer service is by wiring it to other services, like using as an argument or using it via autowiring. So it works like every other service, you just can't fetch it out at run time.

And that's fine, because we just invented all these service IDs so we know that we're not using these anywhere in our code yet. The exception are these two down here. We might be using these directly from the container. In fact, I know we are, if you look at src, AppBundle, Controller, Admin bundle, Admin, GenusAdminController. Down in edit action, you can see we're actually getting out both of our message generators via this arrow get, we're getting them directly from the container.

So for now, we're actually gonna add public: true on these guys. Now realize also that legacy_aliases ... Aliases can also be public or private but by default everything is public and since we don't have a defaults in this file that says these are private, all these aliases are public which is good because there's a good chance that we are using these throughout our code base.

Alright, with that change, we are ready to do the next big change, which is where we import all services from [inaudible 00:07:10] \AppBundle

