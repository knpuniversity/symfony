# ReactJS talks to your API

Remove the link. In `base.html.twig`, we already have a few JavaScript files that
are included on every page. But now, I want to include some JavaScript on *just*
this page - I don't need this stuff everywhere.

## Page-Specific JavaScript (or CSS)

Remember [from earlier][1] that those script tags live in a `javascripts` block.
Hey, that's perfect! In the child template, we can override that block:
`{% block javascripts %}` then `{% endblock %}`:

[[[ code('12514947b0') ]]]

Now, whatever JS we put here will end up at the bottom of the layout. Perfect, right?

No, not perfect! When you override blocks, you override them *completely*. With this
code, it will completely replace the other scripts in the base template. I don't want
that! I really want to *append* content to this block.

The secret awesome solution to this is the `parent()` function:

[[[ code('7a27bbd637') ]]]

This prints all of the content from the parent block, and *then* we can put our
cool stuff below that.

## Including the ReactJS Code

Here's the goal: add some JavaScript that will make an AJAX request to the notes
API endpoint and use that to render them with the same markup we had before. We'll
use ReactJS to do this. It's powerful... and super fun, but if it's new to you, don't
worry. We're not going to learn it now, just preview it to see how to get our API
working with a JavaScript frontend.

First, include three external script tags for React itself. Next, I'm going to include
one more script tag that points to a file in *our* project: `notes.react.js`:

[[[ code('98007baabe') ]]]

Let's check that file out! Remember, it's in `web/js/notes.react.js`:

[[[ code('8d61daff30') ]]]

## The ReactJS App

This is a small ReactJS app that uses our API to build all of the same markup that
we had on the page before, but dynamically. It uses jQuery to make the AJAX call:

[[[ code('bde76dcba0') ]]]

But I have a hardcoded URL right now - `/genus/octopus/notes`. Obviously, that's
a problem, and lame. But ignore it for a second.

Back in the template, we need to start up the ReactJS app. Add a `script` tag with
`type="text/babel"` - that's a React thing. To boot the app, add `ReactDOM.render`:

[[[ code('ef87c143ef') ]]]

PhpStorm is *not* going to like how this looks, but ignore it. Render the
`NoteSection` into `document.getElementById('js-notes-wrapper')`:

[[[ code('71dc1ec0a7') ]]]

Back in the HTML area, clear things out and add an empty div with this `id`:

[[[ code('8d0ba5c2ee') ]]]

Everything will be rendered here.

Ya know what? I think we should try it. Refresh. It's alive! It happened quickly,
but this *is* loading dynamically. In fact, I added some simple magic so that it
checks for new comments every two seconds. Let's see if it'll update without refreshing.

In the controller, remove one of the notes - take out `AquaWeaver` in the middle.
Back to the browser! Boom! It's gone. Now put it back. There it is! So, really cool
stuff.

## Generating the URL for JavaScript

But... we still have that hardcoded URL. That's still lame, and a problem. *How*
you fix this will depend on if you're using AngularJS, ReactJS or something else.
But the idea is the same: we need to pass the dynamic value into JavaScript. Change
the URL to `this.props.url`:

[[[ code('8d4269895f') ]]]

This means that we will pass a `url` property to `NoteSection`. Since we create
that in the Twig template, we'll pass it in there.

First, we need to get the URL to the API endpoint. Add `var notesUrl = ''`. Inside,
generate the URL with twig using `path()`. Pass it `genus_show_notes` and the `genusName`
set to `name`:

[[[ code('b9c4a005fd') ]]]

Yes, this is Twig inside of JavaScript. And yes, I know it can feel a little crazy.

Finally, pass this into React as a prop using `url={notesUrl}`:

[[[ code('d3a82668fe') ]]]

Try that out. It still works very nicely.

***SEEALSO
There is also an open-source bundle called [FOSJsRoutingBundle][2] that allows
you to generate URLs purely from JavaScript. It's pretty awesome.
***

Congrats on making it this far: it means you're serious! We've just started, but
we've already created a rich HTML page *and* an API endpoint to fuel some sweet
JavaScript. And we're just starting to scratch the surface of Symfony.

What about talking to a database, using forms, setting up security or handling API
input and validation? How and why should you register your own services? And what
are event listeners? The answers to these will make you *truly* dangerous not just
in Symfony, but as a programmer in general.

See you on the next challenge.


[1]: http://knpuniversity.com/screencast/symfony/layout-assets
[2]: https://github.com/FriendsOfSymfony/FOSJsRoutingBundle
