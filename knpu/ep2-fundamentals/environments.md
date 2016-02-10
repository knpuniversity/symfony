# Environments

So if the point of `config.yml` is to configure the bundles and the services those
bundles give us, then what the heck are all of these other files in `App/Config`;
we've got `config_dev.yml`, `config_test.yml`, `parameters.yml`, `security.yml`,
`services.yml`, let's find out!

One of the most powerful parts of Symfony's configuration system is this idea of
environments. Now, I don't mean environments like `dev`, `staging`, or `production`
on your servers, it's environments within your application. An environment is a set
of configuration. 

Think about it, if you have an application that has some code, to get that code
running it's going to need configuration. It needs to know what your database
password is, what file your logger should log to, and at what priority it should
log those messages. 

In Symfony you can boot your application with different sets of configuration. In
the `dev` environment you'll want to boot with lots of logging and in the `prod` 
you'll only want it to log errors. 

The first question is, how do we choose these environments? The two main environments
in Symfony are `dev` and `prod`, so, which environment have we been using so far?

The answer to that is down here in the web directory, which is the document root.
This is the only directory where these files are public. 

In here we've got two files, one called `app.php` and a `app_dev.php`, and these 
are called the front controllers. Whenever you access a Symfony application you're
executing either `app.php` or `app_dev.php`. When you use Symfony's built in web
server, you'll be executing `app_dev.php` it's preconfigured in that server. 

When we go to `localhost:8000` that's equivalent to going to `localhost:8000/app_dev.php/genus/octopus`
When I plug that into our url it makes no difference, the page still loads nicely.

Let's say we want to load things in the prod environment, copy the url, open a new
tab and change it to `localhost:8000/app.php/genus/octopus` and this is the prod
environment! The first thing you'll notice is that our handy web debug toolbar is gone
because this is optimized for speed. The cool development tools are gone, but it runs
really really fast. 

Of course in production you won't need to have this `app.php` in the url because
you will configure your webserver to execute it even when there is nothing in the url.
This is how you "choose" your environment and typically you will be picking the
`dev` environment while developing. 

How do we control the configuration of each environment? If you compare these two
files, other than this big `if` block on the top of `app_dev.php` that prevents you
from deploying this file to production, the only important difference is this line
that says `$kernel = new AppKernel('prod', false);`. Remember, that `AppKernel` is
our file in the `App` directory which boots our bundles. 

The first argument to it is `prod` in `app.php` and `dev` in `app_dev.php` and that
defines your environment. The second argument is `true` or `false` which is a debug
flag and it controls whether or not errors should be shown. 

Ok so we've got `dev` and `prod` what exactly do they do? When Symfony boots, it loads
only one configuration file to get all the configuration that it needs. In the `dev` 
environment it loads `config_dev.yml` and in the `prod` environment it loads
`config_prod.yml`. 

Ok fellow deep sea explorers, this is where things get really cool! Checkout the
first line of `config_dev.yml`. It uses a special directory that imports the main
`config.yml`. Why? When we're in the `dev` environment it allows us to import all of
the main default configuration and then it overrides settings that are specific to
the `dev` environment. 

Check this out! Down here under `monolog`, which is the bundle that gives us the
logger service, it configures extra logging for the `dev` environment. Including
this one that says that the `action_level` is `debug` which says "log everything no matter
its message priority".

In `config_prod.yml`, unsurprisngly, does the exact same thing. It loads the main
configuration, and then it starts overriding settings that are specific to the `prod`
environment. In this case, you can see s similar setup for the logger, but now it 
says `action_level: error` which will only log things that are at an error level 
which is a pretty high level -- and it doesn't include debug errors.

Let's start messing around with stuff in just the `dev` environment! One of the
settings that is commented out down here under `monolog` in `config_dev.yml` is
a thing called `firephp`. This is a cool extension that allows you to get log
messages right in your browser. 

Head back to the browser and inspect element. Check that the URL is for the `dev`
environment and then refresh. Check this out, we have all these little messages 
down here telling us what route was matched and even what route was matched for our
ajax call. That is the `firephp` extention doing its work, just note that you will
need a chrome or firefox extension to see those. But, we controlled the logger service
in a way that only impacted the `dev` environment. 

Swim on over to the `GenusController` and log one more message, `$this->get('logger')`
and send an `->info()`, since we're logging everything at the `info` setting and above.
`'showing genus:'` and pop out the `.$genusName`. 


