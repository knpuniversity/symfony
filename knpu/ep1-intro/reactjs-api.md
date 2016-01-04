# ReactJS talks to your API

Okay. Let’s remove this link here and add some JavaScript to just this page.
Now, in our base template, we already have JavaScript that’s included on every
single page, but now I wanna include JavaScript that’s just included on this
page. And I wanna do that for performance.

And notice this is in a block javascripts, so what we can do below here is we
can just override that block. Block javascripts endblock, and then put whatever
JavaScript we inside of here. But wait. When you override blocks, you override
them completely. So if I just do this, it will completely replace the scripts
in my base template, and I don’t want that. The trick is to use the curly-curly
parent function. That will include all of the scripts from the parent block,
and then below that, we can add our own stuff.

Okay. So, I’m gonna render all of these comments – the comments that we had on
the page – dynamically by using our API endpoints. We’re gonna do that with
React.js, which is super fun to play with. If you’re not familiar with it, it’s
okay. We’re just gonna touch on it a little bit to show off how things work.

First, I’ll include three external script tags. And then I’m gonna include one
more script tag that points to a JavaScript file in our project, which is
notes.react.js. Let’s take a look at that. Remember, this is in the web
directory, js/notes.react.js. So, this is a little React.js application that I
created that goes to our API endpoints and then builds all of the markup that
we had before in our page dynamically. So, you recognize this as the markup
that we were using before for our comments.

Now, notice one thing here. It makes an AJAX endpoint just using jQuery – so,
very simple – but I have the URL hardcoded right now to /genus/octopus/notes.
So obviously, that’s a problem, but we’re going – but let’s just ignore it for
a second. Trust me – we’ll fix it.

Back in our template, to get things working, make another script tag for text
equals babel. Then here, we will boot the application, ReactDOM.render, and
FutureStorm is not gonna like how this looks, but we’ll ignore it. And we’ll
render our NoteSection, and then we’re gonna render into
document.getElementById(‘js-notes-wrapper’). What I’ll do is actually create
that element up here, so I don’t need any of this notes stuff anymore because
that’s about to be done dynamically. Instead, we’ll have id equals that. So,
everything will get rendered into that div.

Cool. Let’s give it a try. So, refresh, and it’s alive. It happened really
quickly, but this is actually loading dynamically. And in fact, I put a little
interval in there, so this is actually reloading automatically about every two
seconds. So, if we go into our controller here, maybe we take out AquaWeaver in
the middle. Go back, and boom! It’s gone. We put it back, and then it comes
back. So, really cool stuff.

But we still have that hardcoded URL inside of here, and I don’t like that. So,
the way you fix this is gonna be specific to what you’re using, AngularJS,
React.js, but it kinda has the same idea. We need to pass the dynamic value
into here. So, the way we’re gonna do that in React is change this to
this.props.url, which means now we need to pass a URL property into our
NoteSection. And since you’re creating that down here, we can do that in this
spot.

So first, let’s get the URL to that AJAX endpoint, so we’ll say var notesUrl =,
and we’ll set up a JavaScript variable. And inside of here, we’ll actually
inline some twigs. This’ll look a little weird – we have twig inside of
JavaScript. And we’ll link to our genus_show_notes and then pass it the
genusName set to the name variable, so it’s the same way we regenerated the
link before. And to pass it into React, we could say url={notesUrl}. And with
that, we should be able to refresh, and everything still works.

So, either we have a twig template front-end or this awesome API for our sweet
React.js front-end. It doesn’t really matter. We can have a mix of the two.
It’s all the same fundamental philosophy.
