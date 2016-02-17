# Parameters: The Variables of Configuration

We've basically mastered Symfony configuration and environments. But there's just
*one* more near trick up its sleeve.

Look closely inside `config.yml` file: one of the settings - `default_locale` - is
set to a strange-looking value: `%locale%`. Huh.

Scrolling up a bit, there's another root key called `parameters` with `locale: en`.
You're witnessing the power of a special "variable system" inside config files.
Here's how it works: in any of these configuration files, you can have a
`parameters` key. And below that you can create variables like `locale` and set that
to a value. Why is this cool? Because you can then reuse that value in *any* other file
by saying `%locale%`. 

Look under the `doctrine` key. Hey, a bunch more, like `%database_host%` and `%database_port%`.
These are set just like `locale`, but in a different file: `parameters.yml`.

So that's it! If you add a new key under `parameters`, you can use that in any other
file by saying `%parameter_name%`.

And just like services, we can get a *list* of every parameter available. How? Ah,
our friend the console of course. Run:

```bash
bin/console debug:container --parameters
```

Woah,  that's a *huge* list you can take advantage of or even override. Most of these
you won't care about, but don't forget this little cheatsheet is there for you.

## Creating a new Parameter

*We* can leverage parameters to do something *really* cool with our cache setup.

In the `prod` environment, we use the `file_system` cache. In `dev`, we use `array`.
We can improve this. Create a new parameter called `cache_type` and set that 
to `file_system`. Scroll down and set `type` to `%cache_type%`.

Run over in the terminal to see if the parameter showed up:

```bash
bin/console debug:container --parameters
```

It's right on top. Cool! Clear the cache in the `prod` environment so we can double-check
everything is still working. Ok good - now refresh using `app.php`. It's still loading
fast - so we haven't broken anything... yet.

Here's where things get interesting. In `config_dev.yml`, it took a lot of code *just*
to turn caching off. Parameters to the rescue! Copy the `parameters` key from `config.yml`
and paste it into this file. But now, change its value to `array` and celebrate
by completely removing the `doctrine_cache` key at the bottom.

That's it! Refresh the browser in the `dev` environment: *great* it's still slow.
