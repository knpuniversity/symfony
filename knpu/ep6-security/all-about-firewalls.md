# All About Firewalls

Open up `app/config/security.yml`. Security - especially *authentication* - is all
configured here. We'll look at this piece-by-piece, but there's one section that's
more important than all the rest: `firewalls`.

## All About Firewalls

Your firewall *is* your authentication system: it's like the security desk you pass
when going into a building. Now, there's always only *one* firewall that's active
on any request. You see, if you go to a URL that starts with `/_profiler`, `/_wdt`
or `/css`, you hit the `dev` firewall *only*. This basically turns security off:
it's like sneaking through the side door of a building that has no security desk.
This is here to prevent us from getting over-excited with security and accidentally
securing our debugging tools.

In reality, every *real* request will activate the `main` firewall. Because it has
no `pattern` key, it matches *all* URLs. Oh, and these keys - `main` and `dev`,
are meaningless.

Our job is to activate different ways to authenticate under this *one* firewall. We
might allow the user to authenticate via a form login, HTTP basic, an API token,
Facebook login or *all* of these. 

So - if you ignore the `dev` firewall, we really only have *one* firewall, and I
want yours to look like mine. There *are* use-cases for having multiple firewalls,
but you probably don't need it. If you're curious, we *do* set this up on our Symfony
REST API course.

## We won't use form_login

Ok, *we* want to activate a system that allows the user to submit their email and
password to login. If you look at the official documentation about this, you'll notice
they add a key called `form_login` under their firewall. Then, everything just magically
works. I mean, literally: you submit your login form, Symfony intercepts the request
and takes care of everything else.

It's really cool because it's quick to set up! But it's super magical and hard to
extend and control. If you're using FOSUserBundle, they also recommend that
you use this. 

But, you have a choice. We *won't* use this. Instead, we'll use a system that's new
in Symfony 2.8 called Guard. It *is* more work to setup, but you'll have control
over *everything* from day 1.
