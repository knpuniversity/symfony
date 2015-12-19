## Twig Layouts (Template Inheritance)

To get a layout, add a new do something tag at the top of `show.html.twig`:
`extends 'base.html.twig'`:

This says that we want `base.html.twig` to be our base template. But where does that
file live? Remember: all templates live in `app/Resources/views`. And look, there's
`base.html.twig`. This little file actually came with Symfony and it's your's to
customize. 

Refresh the browser after just this small change. Nice, a huge error

> A template that extends another one can't have a body...

So what does that mean? 

In Twig, layouts work via template inheritance. Ooooh. The `base.html.twig` template
is filled with blocks. The job of the child template is to define content that should
go into each of these blocks. For example, if you want your child template - `show.html.twig`
in this case - to put content inside this `body` block, you need to *override* it.
If you want to replace the title, then you'll override the `title` block. 

Right now, our `show.html.twig` file is just barfing content. We're telling Twig
we want to use `base.html.twig`, but it doesn't know *where* in that file this
content should be placed.

To fix this, wrap *all* of the content in a block: `{% block body %}`. At the end,
close it with `{% endblock %}`. Oh, and the names of these blocks are not important
at all. You can change them to whatever you want and can add as many as you need. 

## The Web Debug Toolbar and Profiler

With this fixed up, head back to the browser and refresh. Cool! It's the same page,
but now it has a full html source. Bonus time! Once you have a full html page, the
web debug toolbar makes an appearance. This is a killer feature in Symfony: it includes
includes information about which route was matched, which controller was executed,
how fast the page loaded, who is logged in and more.

You can also click any of the icons to get even more detailed information in the
profiler, including this amazing timeline that shows you exactly how long each part
of your application took to render. This is *amazing* for debugging and profiling.
There's also details in here on Twig, security, routes and other cool stuff. We'll
keep exploring this as we go along.

## Overriding a Second Block

Ok, the title of the page - "welcome" - well, that's not terribly inspiring or accurate
for this page. That comes from the base layout, but it's wrapper in a block called
`title`. Let's override that!

Add `{% block title %}Genus {{ name }}{% endblock %}`. The order of blocks doesn't
matter: this could be above or below the body. Back to the browser and refresh!
Ah ha! There's our new title -- not too shabby. That's it for Twig -- what's not
to love? If you want more, we have a whole screencast on *just* Twig: http://knpuniversity.com/screencast/twig.
