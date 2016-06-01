# All About Firewalls
Open up `app/config/security.yml`. Security - especially *authentication* - is all
configured here. We'll look at this piece-by-piece, but there's one section that's
more important than all the others: `firewalls`.

## All About Firewalls

Your firewall *is* your authentication system: it's like the security desk you pass
when going into a big building. Now, there's always only *one* firewall that's active
on any request. You see, if you go to a URL that starts with `_profiler`, `_wdt`
or `/css`, you hit the `dev` firewall *only*. This basically turns security off:
it's like sneaking through the side door of a building that has no security desk.
This is here to prevent us from getting over-excited with security and accidentally
securing our nice debugging tools.

In reality, every *real* request will active the `main` firewall, because it has
no `pattern` key, so it matches *all* URLs.

Our job is to activate different ways to authenticate under this *one* firewall. We
might allow the user to authenticate via a form login, HTTP basic, and API token,
Facebook login or *all* of these. 

So - if you ignore the `dev` firewall, we really only have *one* firewall, and I
want yours to look like mine. There *are* use-cases for having multiple firewalls,
but you probably don't need it. If you're curious, we *do* set this up on our Symfony
REST API courses.

## We won't use form_login

Ok, *we* want to activate a system that allows the user to submit their email and
password to login. If you look at an official documentation about this, you'll notice
they add a key called `form_login` under their firewall. Then, everything else just
magically happens. I mean, literally: you submit your login form, Symfony intercepts
the request and takes care of everything else.

It's really cool because it's quick to set up! But it's super magical and harder to
extend when you need to. If you're using FOSUserBundle, they also recommend that
you use this. 

But, you have a choice. We *won't* use this. Instead, we'll use a system that's new
in Symfony 2.8 called Guard. It'll be more work to setup, but you'll have control
over *everything* from day 1.
