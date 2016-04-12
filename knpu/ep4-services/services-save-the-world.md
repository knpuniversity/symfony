# Create Service

Hey, hey, friends! Back for more!? You should be feeling *pretty* good about yourself
already - but you're about to feel like a kid in a very nerdy, borderline embarrassing
candy store. In this course, we *fully* uncover services: those little useful objects
that literally do *everything* in Symfony.

Now as always, you *should* code along with me - otherwise we'll find out and it's
kinda company policy to mail you a big package full of glitter. But if you code along -
and we meet in person, well, there's a cookie with your name on it.

So find the "Download" button on any of the tutorial pages, download the code, unzip
it and move into the `start` directory. As always, I already have the `start` directory
code here, so I'll skip to the last step: open up a new terminal and launch the built-in
PHP web server with:

```bash
php bin/console server:run
```

In your case, open up the `README.md` file in the `start` directory - it has a few
extra instructions.

## Services: Doers of Good

In the last courses, if I repeated anything too many times, it was this: Refresh!
But second would be that Symfony is basically just a big container of useful objects
called services... and *everything* that happens is *actually* done by one of
these.

[[[ code('7a81277b2e') ]]]

For example, the `render()` function - it's the key to rendering templates, right?
No - it's a fraud! Open up Symfony's base `Controller`:

[[[ code('1e30b04747') ]]]

it doesn't do *any* work: it just finds the `templating` service and tells *it* to do
all the work. Ah, management.

This means that Symfony doesn't render templates: The *templating* service renders
templates. To get a big list of birthday wishes, I mean services, run:

```bash
./bin/console debug:container
```

That's a lot of firepower at our fingertips.

We *also* found out that we can control these services in `app/config/config.yml`:

[[[ code('a48f42e1c4') ]]]

## New Goal: Service Architecture

But now we have a new, daring goal: adding our *own* services to the container. It
turns out, learning to do this will unlock almost *everything* else in Symfony.

Open up `GenusController` and look at `showAction()`:

[[[ code('3ea86fa5d1') ]]]

We *used* to have about 15 lines of code that parsed the `$funFact` through Markdown
and then cached it. I want that back. But, but but! I don't want to have these 15 lines
of code live here, in my controller.

Why not? Three reasons:

1. I can't re-use this. If I need to do parse some markdown somewhere else... well,
   I could copy-and-paste? But then, how would I sleep at night?

2. It's not instantly clear *what* these 15 lines do: I have to actually take time
   and read them to find out. If you have a lot of chunks like this, suddenly *nobody* knows
   what's going on in your app. You know what I'm talking about?

3. If you want to unit test this code... well, you can't. To unit test something,
   it needs to live in its own, isolated, focused class.

Well hey, that's a great idea - let's move this *outside* of our controller and solve
all three problems at once... *plus* impress our developer friends with our sweet
code organizational skills.
