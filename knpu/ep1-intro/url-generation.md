# Generating URLs

We now have *two* pages: the HTML `/genus/{genusName}` page and the JSON endpoint.
Ok ok, the JSON endpoint isn't really a *page*, at least not in the traditional sense.
But pretend it is for a second. Pretend that we want to link from the HTML page to
the JSON endpoint so the user can see it. Yes yes, we're going to do something fancier
with JavaScript in a minute, but stay with me: this is important.

In `show.html.twig`, get rid of all this `notes` stuff because we're not passing in
a `notes` variable anymore. Instead, near the top, add a new anchor tag. I want to
put the URL to the `getNotesAction` page. Fill this in with `/genus/{{ name }}/notes`.

Perfect right! Wrong! Ok, only kind of wrong. This *will* work: you can click the
link and go that URL. But this kinda sucks: if I decided that I needed to change
the URL for this route, we would need to hunt down and update *every* link on the
site. That's ridiculous.

Instead, routing has a second purpose: the ability to generate the URL to a specific
route. But to do that, you need to give the route a unique name. After the URL, add
comma and `name="genus_show_notes"`:

[[[ code('c356e8c8a6') ]]]

The name can be anything, but it's usually underscored and lowercased.

## The Twig path() Function

To generate a URL in Twig, use the `path()` function. This has two arguments. The
first is the name of the route - `genus_show_notes`. The second, which is optional,
is an associative array. In Twig, an associative array is written using `{ }`, just
like JavaScript or JSON. Here, pass in the values for any wildcards that are in the
route. This route has `{genusName}`, so pass it `genusName` set to the `name` variable:

[[[ code('94879d175d') ]]]

Ok, go back and refresh! This generates the same URL... so that might seem kind of
boring. But if you ever need to change the URL for the route, all the links would
automatically update. When you're moving fast to build something amazing, that's
huge.

Linking to a JSON endpoint isn't realistic. Let's do what we originally planned: use
JavaScript to give us a dynamic frontend.
