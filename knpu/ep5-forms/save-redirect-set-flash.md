# Save, Redirect, setFlash (and Dance)

We already have the finished `Genus` object. So what do we do now? Whatever we want!

Probably... we want to save this to the database. Add `$genus = $form->getData()`.
Get the entity manager with `$em = this->getDoctrine()->getManager()`. Then, the
classic `$em->persist($genus)` and `$em->flush()`:

[[[ code('f0e450be8c') ]]]

## Always Redirect!

Next, we *always* redirect after a successful form submit - ya know, to make sure
that the user can't just refresh and re-post that data. That'd be lame.

To do that, `return $this->redirectToRoute()`. Hmm, generate a URL to the
`admin_genus_list` route - that's the main admin page I created before the
course:

[[[ code('e60d343473') ]]]

Because `redirectToRoute()` returns a `RedirectResponse`, we're done!

Time to try it out. I'll be lazy and refresh the POST. We *should* get a brand
new "Sea Monster" genus. There it is! Awesome!

## Adding a Super Friendly (Flash) Message

Now, it worked... but it lack some spirit! There was no "Success! You're amazing! You
created a new genus!" message.

And I want to build a friendly site, so let's add that message. Back in `newAction()`,
add some code *right* before the redirect: `$this->addFlash('success')` - you'll see
where that key is used in a minute - then `Genus created - you are amazing!`:

[[[ code('6dbd2f4191') ]]]

It's good to encourage users.

But let's be curious and see what this does behind the scenes. Hold `command` and click
into the `addFlash()` method:

[[[ code('fe49ad40e6') ]]]

Okay, cool: it uses the `session` service, fetches something called a "flash bag"
and adds our message to it. So the flash bag is a special part of this session where
you can store messages that will automatically disappear *after* one redirect. If
we store a message here and then redirect, on the next page, we can read those
messages from the flash bag, and print them on the page. And because the message
automatically disappears after one redirect, we won't accidentally show it to the
user more than once.

And actually, it's even a little bit cooler than that. A message will *actually*
stay in the flash bag until you ask for it. Then it's removed. This is good because
if you - for some reason - redirect *twice* before rendering the message, no problem!
It'll stay in there and wait for you.

### Rendering the Flash Message

All we need to do now is render the flash message. And the best place for this is
in your base template. Because then, you can set a flash message, redirect to *any*
other page, and it'll always show up.

Right above the `body` block, add `for msg in app.session` - the shortcut to get
the `session` service - `.flashbag.get()` and then the `success` key. Add the `endfor`:

[[[ code('e3e3c3395a') ]]]

Why `success`? Because that's what we used in the controller - but this string is
arbitrary:

[[[ code('cb4ea1d8b5') ]]]

Usually I have one for `success` that I style green and happy, and on called `error`
that style to be red and scary.

I'll make this happy with the `alert-success` from bootstrap and then render `msg`:

[[[ code('850ec2f541') ]]]

Cool! Go back and create `Sea Monster2`. Change its subfamily, give it a species
count and save that sea creature! Ocean conservation has never been so easy.

And, I'm feeling the warm and fuzzy from our message.

Next, let's *really* start to control how the fields are rendered.
