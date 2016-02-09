# Config.yml

Ok, I get it, I bring in a bundle and it gives me more services (useful objects). 
There must be a way for us to control those services. For example, Symfony has a
logger service. By default, it logs into `var/logs/dev.log`, but certainly there
must be a way for us to control that. Maybe we want to log to a database or have
the logs be rotated every 24 hours. 

The answer to how we can take more control lies within one file, `app/config/config.yml`.
Now, you are probably noticing the other configuration files in here, I'll get to 
those, but just ignore them for now. Just pretend this is the only configuration
file in the entire system. 

Other than imports and parameters on top, every route key you see here, like framework,
twig and doctrine corresponds to a bundle that is being configured. All of this 
stuff under here is you configuring the framework bundle. All the stuff under
twig is you configuring the twig bundle. Wait a second, if the job of the bundle is
to give you services then what we're really doing here is configuring the services
that the framework bundle gives us. 

Wonderfully, it is in this fairly user friendly format. Typically it will be easy
to figure out what you want to configure by following the names of things. So now
you may be wondering what ethings can you control under one of these keys?

If I've said it once I'll say it again, you can read the documenation. There's a 
great reference section on symfony.com to show all of this. But I'll show you another
way. 

Head back to terminal and use our favorite `./bin/console` and run `config:dump-reference`.
This gives us a nice little map with the bundle name on the left and the extension
alias on the right, which is a fancy way of saying the route key. This is what
we'll use in `config.yml` to configure that bundle. 

One of these is called `twig`, so rerun our console command again with twig. Look 
at this! It dumped a giant yml example of everything you can configure under the
twig key. Now that's pretty incredible. 

Let's play with this a bit, at the bottom here, there's a spot called `number_format:`
`thousands_separator` let me show you what that does. When we call `$this->render`
that uses twig in the background so if we want to control how all that works, it's
going to be by doing things under the `twig` key in `config.yml`. 

Let's pretend for a moment that the known species is this big 99999 number. Use
a built in filter in twig called `number_format` and when we refresh this isn the
browser we get a nice 99 comma 999 since most of the world does thousands with
a comma. But, let's say you are from one of the counties that uses a period instead,
you'll want to change the twig service that's rendering these templates. To do that,
following our `config:dump-reference` we can go to `config.yml` and add 
`number_format:` `thousands_separator:'.'`. Behind the scenes this changes how
the service works and when we refresh we get 99 point 999. 

Since Symfony really isn't doing anything, it's actually one of these services, 
if you're trying to control something in Symfony what you're really trying to do
is figure out what configuration you need to change in `config.yml` to change
the behavoir of the service you're working on. 

The last cool thing about this file is that it is validated, so if we have a typo
like adding an s to `thousand_separator` and we refresh, our browser gives us a
huge error. From here we can go back and figure out what's wrong. 

