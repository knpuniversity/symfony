# Fetch me a User Object!

There's really only 2 things you can do with security: deny access and find out
*who* is logged in. 

To show that off, find `newAction`. Let's update the flash message to include the
email address of the current user.

Surround the string with `sprintf` and add a `%s` placeholder right in the middle.
How can you find out who's logged in? Yep, it's `$this->getUser()`. And *that* returns -
wait for it - our `User` object. Which allows us to use *any* methods on it, like
`getEmail()`.

But wait! Do we have a `getEmail()` method on `User` - because I didn't see auto-completion?!
Check it out. Whoops - we don't!

My bad - head to the bottom and add it!

Nice! Now go and create a sea monster. Fill out all the fields... and... eureka!

## The Secret Behind getUser()

But you know I hate secrets: I want to know what that `getUser()` method *really*
does. So hold command and click to see that method.

The important piece is that the user comes from a service called `security.token_storage`.
So if you ever need the `User` object in a service, this is how to get it.

But, it takes a couple of steps: `getToken()` gives you a pretty unimportant object,
except for the fact that you can call `getUser()` on it.

### The Creepy anon.

But, there's a pitfall: if you are anonymous - so, not logged in - `getUser()` does
*not* return `null`, as you might expect: it returns a string: `anon.`. I know -
it's super weird. So, if you ever *do* fetch the user object directly via this service,
check to make sure `getUser()` returns an object. If it doesn't, the user isn't logged
in.

## Getting the User in Twig

The *one* other place where you'll need to fetch the User is inside Twig. In fact,
let's talk about security in general in Twig. Open up `base.html.twig`.

Earlier, we already showed how to check for a role in Twig: it's via the `is_granted()`
function. It's easy: it works exactly the same as in the controller.

So, how do we get the user object? To find out - open up the homepage template. If
the User is logged in, let's welcome them by email.

Open the print tag and say `app.user ? app.user.email : 'Aquanauts'`. That `app`
variable is the *one* global variable you get in Symfony. And one of its super-powers
is to give you the current `User` object if there is one, or `null` if the user isn't
logged in.

Head to the home page and... celebrate.
