# Loading CSS & JS Assets

We have an HTML layout, yay! Good for us!

But... it's *super* boring... and that's just no fun. Besides, I want to talk about
assets!

If you download the code for this project, in the `start/` directory, you'll find a
`tutorial/` directory. I've already copied this into my project. It holds some goodies
that we need to help get things looking less ugly, and more interesting!

## Copying web files

First, copy the 4 directories in `web/`... to `web/`: this includes some CSS, images,
JS and vendor files for Bootstrap and FontAwesome:

```
web/css
web/images
web/js
web/vendor
```

These are boring, normal, traditional static files: we're not doing anything fancy
with frontend assets in this screencast.

***SEEALSO
One way to get fancy is by using Gulp to process, minify and combine assets.
See [Gulp! Refreshment for Your Frontend Assets][2].
***

Ok, important thing: the `web/` directory is the *document root*. In other words,
anything in `web/` can be accessed by the public. If I wanted to load up that `favicon.ico`,
I'd use my hostname `/favicon.ico` - like `http://localhost:8000/favicon.ico`. If
a file is *outside* of web, then it's *not* publicly accessible.

## Including Static Assets

Ok, more work: go into the `app/` directory and copy the new `base.html.twig` file.
Paste that over the original and open it up:

[[[ code('5c45fe9842') ]]]

Hey! We have some real-looking HTML! To bring this to life, we need to include some
of those CSS and JS assets that we just put into `web/`. And here's the key: Symfony
doesn't care about your assets... at all. It's not personal, it keeps things simple.
You include CSS and JS files the way you always have: with tried-and-true `link`
and `script` tags. These paths are relative to the `web/` directory, because that's
the document root. 

### The `stylesheets` and `javascripts` blocks

Ok ok, in reality there are *two* little-itty-bitty Symfony things to show you about
assets. First, notice that the link tags live inside a block called `stylesheets`:

[[[ code('05e4fbd492') ]]]

Really, technically, that does... nothing! Seriously: you don't have to do this,
it will make no difference... for now.

But, in the future, doing this will give you the power to add page-specific CSS by
adding *more* `link` tags to the bottom of the `stylesheets` block from inside a
child template. I'll show you that later. Just know that it's a good practice to
put CSS inside of a block, like `stylesheets`.

***SEEALSO
How can you add page-specific CSS or JS files? See [ReactJS talks to your API][1].
***

The same is true for script tags: I've got mine in a block called `javascripts`:

[[[ code('3a77c1ca3f') ]]]

### The asset function

You're probably already looking at the *second* important Symfony thing about assets:
the `asset()` function. *Whenever* you refer to a static file, you'll wrap the path
in `{{ asset() }}`. This does... you guessed it! Nothing! Ok, that's not totally true.
But it really doesn't do much, and you'd be just fine if you forgot it and hardcoded
the path.

So what *does* `asset()` do? Well, if you eventually deploy and use a CDN, it will
save your butt. With just one tiny config change, Symfony can prefix *every* static
URL with your CDN host. So `/css/styles.css` becomes `http://superfastcdn.com/css/styles.css`.
That's pretty awesome, so be good and use `asset()` in case you need it. You can also
do some cool cache-busting stuff.

Other than the asset stuff, the base layout is just like before: it has a `title`
block, a `body` block in the middle and some `javascripts`. We just added the pretty
markup.

## Updating `show.html.twig`

Let's finish this! Copy `show.html.twig` and overwrite our boring version:

[[[ code('e276894e4b') ]]]

And yep, it's also similar to before - I swear I'm not trying to sneak in any magic!
It still extends `base.html.twig`, prints out the genus name and loops over the notes.
Oh, and hey! When I refer to the image - which is a static file - I'm using the `asset()`
function.

Ok, ready for this? Refresh the page. Boom! So much prettier.

These days, you can do some pretty crazy things with assets via frontend tools like
Gulp or PHP tools like Assetic. But you *might* not need any of these. If you can,
keep it simple.


[1]: https://knpuniversity.com/screencast/symfony/reactjs-api
[2]: https://knpuniversity.com/screencast/gulp
