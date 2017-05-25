# Problematic Multi-Service Classes

All this auto registration stuff works really, really well as you'll see. The errors, we get them, are predictable, they happen at compile time, simply walks you through what you need to do if a service for example can't be auto wired.

One exception to it working really well, is when you have multiple services that point at the same class. In other words, when you have cases where you can't name your service the same as the class ID. Actually, right now if you move over to [inaudible 00:00:31] bin/console debug:container --show-private to show private services and grab that grep message, you're going to see a little bit of a surprise. There are actually three services in the container. Our two services, plus a third one that was automatically registered up here with our automatic registration.

Now technically, that's not a problem. No body is referencing our new service who's ideas AppBundle\Service\MessageGenerator. However, there is a small problem and that deals with autowiring.

Here's the way that autowiring works. To show you an example, I'm going to open up the HashPasswordListener. As you can see here, this is typened with UserPasswordEncoder. Here we do not have any arguments and that's being autowired. When the autowiring system sees a typent, it uses a few pieces of logic to figure out what service to pass there.

The first and by far the most important piece of logic that it uses, it looks to see if there's a service in the container who's ID exactly matches this classmate. In other words, it's looking for a service who's ID is exactly Sympfony\Component\Security\Core\Encoder\UserPasswordEncoder. That always wins. And that's the proper way to auto wire things. That's also why we have made all of our service IDs be the class name; as soon as you do that, all of our services can be autowired into other classes. The cool thing about this approach is that it's not magic, Sympfony is not doing anything behind the scenes, you are actually in full control of what service gets autowired for what class. And we are going to talk more about that.

Now if it can't find a service with that ID, it actually does one other thing that is deprecated and will be removed soon.

It actually looks across every service in the container to look and see if any of the class, any of the services have this class. If exactly one has that class, it passes it here. That functionality is actually has been deprecated and will be removed in Symfony4 and you're going to see us fix that in a few places in a second. If it finds two services or more, it throws a big exception.

In Symfony4, none of that is going to exist. If it doesn't find a class with service ID exactly, it's going to throw in exception.

The third thing it does, which is not relevant to us, is that if it finds no services in a container with that class or interface, it automatically registers a new autorwired service. That's not relevant to use though because we have all of our services being imported so that can never happen. And there's a good chance that will be removed as well.

So basically, autowiring looks for a service who's ID exactly matches the typent and if it doesn't find it, it doesn't work. So the problem is that in the future, if somebody typents MessageGenerator, as an argument this first service is going to be used. And actually in this instance, it's not that huge of a problem. Our MessageGenerator has a required construct arguments, so you'd see a very clear exception on that. But still, that's a little unexpected and we didn't want that to happen.

So there's a few ways to fix this. First, if you want to, you can explicitly exclude it. So to exclude here, it would say Service/MessageGenerator.php Now if you go to terminal you'll see that there's just two services, our two services. And neither of them have the classes, the service ID, so we try to autowire them now, you just get a huge exception.

Second, instead of doing that, if you want one of your two services to be the one that's autowired, you can just give that one the class name. So I'm going to do that with our Encouraging_message_generator. I'm going to copy that service ID, I'm actually going to open up our legacy services, legacy_aliases and do the same thing my other services. I'll make the class name, service ID, and set up an alias to point to that.

Now we still have two difference services in the container, but the first one is going to be autowired if you want to autowire it. If you want to pass the second one, you'll need to explicitly configure that, and you'll see how to do that in a second.

The final option, which is totally up to you, is actually to tweak your application so that you don't have this situation. For example, in the tutorial directory, which you should have if you downloaded this project, I have a Message Manager Class. I'm going to copy that and paste it into my service directory. You can see this is sort of a combination where it takes encouragingMessages and discouragingMessages as two separate methods. So it's kind of like two services combined with each other.

[inaudible 00:06:46] I'm going to wire that. AppBundle\Service\MessageManager: Now I'm going to pass it the first and second argument explicitly. So now that we have a MessageManager service. And I'm going to use this instead of my old MessageGenerator services. So for example, if I copy this service ID, go to my terminal git grep and paste that, you can see that this is used inside the GenusAdminController. In fact, both services are only used in that one spot.

So now that I have a new MessageManager service, which I've purposely made public for now, inside my GenusAdmin, I can use that instead. So this ->get instead of encouraging_message_generator, we'll say (MessageManager::class) -> get EncouragingMessage. And same thing down here, (MessageManager::class)->getDiscouragingMessage. And now this service is being used and we can actually remove our legacy alias as well cause that's not being used. So this is totally optional but it does make life a little easier. I can now autowire my MessageManager wherever I want, and I don't need to worry about configuring it out.

For our refresher now, everything seems to work just fine now. I'm actually going to delete my MessageGenerator service entirely. Perfect!

