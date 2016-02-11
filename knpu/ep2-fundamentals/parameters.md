# Parameters

Look closely at this `config.yml` file, one of the settings under `framework` is
called `default_locale` which is used for some language related stuff. Its value
is `%locale%`, that's a little weird. 

Scrolling up a bit there's another key called `parameters` with `local:en`. What
we're looking at here is a very powerful variable system within the configuration
files. Here's how it works: In any of these configuration files you can have a
`parameters` key and below that you can create variables like `locale` and set that
to a value. Why is this cool? Because you can then reuse that value in any other file
not just the original one by saying `%locale%`. 

Under the `doctrine` key there are a bunch more, `%database_host%`, `%database_port%`
and a lot of these are coming from this `parameters.yml` file. In here we've got
another `parameters` key with a bunch of settings. 

Whenever you are building this configuration system you just need to know that there's
a cool variable system in there called `parameters` and you can use it by saying
`%parameter_name%`. 

Just like the services, we can get a list of them in the terminal by running
`./bin/console debug:container --parameters`. Woah, check out this huge list of
built in parameters that we can take advantage of or override. Most of these you don't
need to worry about, but know that the system is there. 

We can use this to do something really cool with the cache changes that we just made.

In the production evironment we use the `file_system` cache and in the `dev` environment
we use the `array` cache. Create a new parameter called `cache_type` and set that 
to `file_system`. Scrolling down, change this `type` to `%cache_type%`.

Over in the terminal rerun the `debug:container --parameters` again to see our type
right at the top set to `file_system` which is pretty cool! 

Let's clear our cache in the `prod` environment to make sure this is working. Head
back to the browser, and we are using `app.php` which is production so go ahead
and refresh that. It's still loading very fast so it looks like everything is working. 

Now over in `config_dev.yml` we don't need to write all of this code anymore to
override the cache. Instead, we can just redefine that `cache_type` parameter.

I'll copy the `parameters` key from `config.yml`, paste it into `config_dev.yml`,
change the parameter to `array`. At the bottom of this file you can just remove the
`doctrine_cache` key and it's contents. Now in the `dev` environment that parameter
is going to be overriden to use the `array` type. 

Back in the browser refresh in the `dev` environment and we should still see it loading
slowly. Perfect, it's still taking over a second because it's not using the cache.

In our terminal's big list of parameters there's a whole group of them that start
with `kernel.`, like `kernel.bundles` which is the list of bundles, `kernel.cache_dir`
which is the cache directory for Symfony, `kernel.debug` which is for wether or not
we're in debug mode. These are special parameters and you won't find these defined
anywhere. They're just built into Symfony and they can be very useful. 

Particularly useful are `kernel.cache_dir` and `kernel.route_dir` which points to
the `app` directory of your project. Remember, when we do cache things we're doing 
that in `/tmp/doctrine_cache` which is a little weird. Maybe this project doesn't
have a `tmp` directory that's writeable for some reason. 

Instead, let's put the cache right in the same directory as my cache which this
does by default without the setting but we'll do it manually. 

By default Symfony puts its cache in the `var/cache/` directory. When we ls into this
we can see that there is a cache for the `dev` environment and one for the `prod`
environment. We can put our cache there by typing `%kernel.cache_dir%` and how about
adding `/markdown_cache` to that. Awesome!

To see that working, clear the cache in the `prod` environment, back to the browser
and switch to the `prod` tab and refresh. Cool, looks like it's still loading pretty
fast. 

Back in the terminal `ls var/cache/prod/` and there is our markdown cache directory.

The last important thing with configuration is this `parameters.yml` file. If 
`config.yml` just imports `parameters.yml` then why even have this file? Why not
just copy all of these parameters and put them right into `config.yml`?

Here's why, the job of `parameters.yml` is to hold configuration that is different
from one machine to another. For example, your database password is most likely
not the same as my database password and probably not the same as the production
database password. 

If we put that password right in the middle of `config.yml` and hardcoded it there
that would suck! In that scenario I'd be commiting my password to the repository 
and you'd have to change it for your computer but also try not to commit it. 

Instead of that confusing mess of seaweed, we use `parameters` inside of `config.yml`
and we isolate all of the machine specific configuration to this one file. And then,
we do not commit this file to the repository. In fact, if you look at the `.gitignore`
file, `app/config/parameters.yml` is the first one on the list. If a new developer
joins the project they will not have a `parameters.yml` file, they'll build their
own without risk of commiting it to the repository. 

Of course, if I joined a new project, and I didn't have a `parameters.yml` file I would
not know what to put in here. It's going to be different on each project. This is
the reason we have this other file called `parameters.yml.dist`. This is not read
by Symfony, it's just meant to be a template of all of the configuration that you
need. 

As you add or remove things from the `parameters.yml` you also want add or remove
them from this dist file. 

For example, see these mailer things down here? In `config.yml` there's a `swiftmailer`
bundle that's being configured and it's using all these different bits of configuration.

Let's pretend that we don't need to send emails in our application which means
we don't even need the `swiftmailer` bundle. It's not hurting anything, but let's
get rid of it! 

Over in `AppKernel.php` find the `SwiftmailerBundle`, completely remove it and then
in `config.yml` completely remove the `swiftmailer` configuration. Now that we've
done that, we don't need these parameters anymore. They're not hurting anything, 
but no one is using them. Just delete all the `mailer` parameters, and finally
delete them from the dist file so that a new developer doesn't think that they need
to configure those. Awesome!

Head over to the terminal and run `./bin/console debug:container mailer` it returns
that there are no services that match `mailer`, looks like our deleting what thorough. 


