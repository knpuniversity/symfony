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
from deploying this file since this file is only for development and you really
don't want your users taking on that role. 
