# JSON Responses + Route Generation

Okay, this is cool... but what about APIs and JavaScript frontends and all that new
fancy stuff? How does Symfony stand up to that? Actually, it stands up *wonderfully*:
Symfony is a first-class tool for building APIs. Seriously, you're going to love
it.

Since the world is now a mix of traditional apps that return HTML and API's that
feed a JavaScript frontend, we'll make an app that's a mixture of both.

Right now, the notes are rendered server-side inside of the `show.html.twig` template.
But that's not awesome enough! If an aquanaut adds a new comment, I need to see it
instantly, *without* refreshing. To do that, we'll need an API endpoint that returns
the notes as JSON. Once we have that, we can use JavaScript to use that endpoint
and do the rendering.

## Creating API Endpoints

So how *do* you create API endpoints in Symfony? Ok, do you remember what a controller
*always* returns? Yes, a Response! And ya know what? Symfony doesn't care whether
that holds HTML, JSON, or a CSV of octopus research data. So actually, this turns
out to be really easy.

Create a new controller: I'll call it `getNotesAction()`. This will return notes
for a specific genus. Use `@Route("/genus/{genusName}/notes")`. We really only want
this endpoint to be used for `GET` requests to this URL. Add `@Method("GET")`:

[[[ code('c9f252a70f') ]]]

Without this, the route will match a request using *any* HTTP method, like `POST`.
But with this, the route will only match if you make a GET request to this URL. Did
we need to do this? Well no: but it's pretty trendy in API's to think about which
HTTP method should be used for each route.

## Missing Annotation use Statement

Hmm, it's highlighting the `@Method` as a missing import. Ah! Don't forget when
you use annotations, let PhpStorm autocomplete them for you. That's important because
when you do that, PhpStorm adds a `use` statement at the top of the file that you
need:

[[[ code('fdeae7b606') ]]]

If you forget this, you'll get a pretty clear error about it.

Ok, let's see if Symfony sees the route! Head to the console and run `debug:router`:

```bash
php bin/console debug:router
```

Hey! There's the new route at the bottom, with its method set to GET.

## The JSON Controller

Remove the `$notes` from the other controller: we won't pass that to the template
anymore:

[[[ code('cfb58bd6e8') ]]]

In the new controller, I'll paste a new `$notes` variable set to some beautiful
data:

[[[ code('62b22cdc9e') ]]]

We're not using a database yet, but you can already see that this kind of *looks*
like it came from one: it has a username, a photo for each avatar, and the actual
note. It'll be pretty easy to make this dynamic in the [next episode][1].

Next, create a `$data` variable, set it to an array, and put the `$notes` in a `notes`
key inside of that. Don't worry about this: I'm just creating a future JSON structure
I like:

[[[ code('cb8214a92f') ]]]

Now, how do we finally return `$data` as JSON? Simple: `return new Response()` and
pass it `json_encode($data)`:

[[[ code('66e480328b') ]]]

Simple!

Hey, let's see if this works. Copy the existing URL and add `/notes` at the end.
Congratulations, you've just created your first Symfony API endpoint.

## JsonResponse

But you know, that *could* have been easier. Replace the Response with `new JsonResponse`
and pass it `$data` without the `json_encode`:

[[[ code('7a85429388') ]]]

This does two things. First, it
calls `json_encode()` for you. Hey thanks! And second, it sets the `application/json`
`Content-Type` header on the Response, which we could have set manually, but this
is easier.

Refresh. It still works perfectly.


[1]: http://knpuniversity.com/screencast/symfony-doctrine
