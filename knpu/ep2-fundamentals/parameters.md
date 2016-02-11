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

Under the `doctrine` key there are a bunch more. 
