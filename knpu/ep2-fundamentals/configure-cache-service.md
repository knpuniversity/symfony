# Configuring DoctrineCacheBundle

We have a new toy, I mean service! In `GenusController`, let's use it:
`$cache = $this->get('')` and start typing `markdown`. Ah, there's our service!

[[[ code('34254489cc') ]]]

Here's the goal: make sure the same string doesn't get parsed twice through markdown.
To do that, create a `$key = md5($funFact);`:

[[[ code('ea4c667e90') ]]]

To use the cache service, add `if ($cache->contains($key))`. In this case,
just set `$funFact = $cache->fetch($key);`:

[[[ code('a1f40a624c') ]]]

Else, we're going to need to parse through Markdown.

Let's live *dangerously*: add a `sleep(1);` to pretend like our markdown transformation
is *really* taking a long time. Next, parse the fun fact and finish with
`$cache->save($key, $funFact)`:

[[[ code('7ee9751953') ]]]

Let's do this! Go back to the browser... and watch closely my friends. Refresh!
Things are moving a bit slow. Yep: the web debug toolbar shows us 1048 ms. Refresh
again. super fast! Just 41 ms: the cache is working! But... uhh... where is this
being cached exactly?

Out of the box, the answer is in `var/cache`. In the terminal, `ls var/cache`, then
`ls var/cache/dev`:

```bash
ls var/cache/dev/
```

Hey! There's a `doctrine` directory with `cache/file_system`
inside. *There* is our cached markdown.

This bundle *assumed* that this is where we want to cache things. That was really
convenient, but clearly, there needs to be a way to control that as well. 

## Configuring the Cache Path

Rerun `config:dump-reference doctrine_cache`:

```bash
./bin/console config:dump-reference doctrine_cache
```

Ah, there's a `directory` key we can use to control things. In the editor, add this
new `directory` key and set it to `/tmp/doctrine_cache` for now:

[[[ code('3cfda7cd88') ]]]

Ok, back to the browser team. Refresh! Poseidon's beard, check out that HUGE error! 
"Unrecognized option 'directory'". Remember, configuration is validated... which
means we just messed something up. Oh yea: I see the problem: I need to have
`file_system` and *then* `directory` below that. Add `file_system` above `directory`
and then indent it to make things match:

[[[ code('13416f8052') ]]]

Ok, try this out one more time.

It should be slow the first time... yes! And then super fast the second time. In
the terminal, we can even see a `/tmp/doctrine_cache/` directory:

```bash
ls /tmp/doctrine_cache/
```

Big picture time: bundles give you services, and those services can be controlled
in `config.yml`. Every bundle works a little bit different - but if you understand
this basic concept, you're on your way.
