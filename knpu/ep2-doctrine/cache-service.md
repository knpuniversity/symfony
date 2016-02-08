# Cache Service

New challenge! Eventually we'll be rendering a lot of markdown. Maybe even really
big pieces of markdown. Rendering this takes time, so we don't want to do it on
every single request in production. Instead, we need to cache the markdown processing.

Caching is just another tool that we need. Some service that is really good at
caching a string and letting us fetch that string later. Fortunately, Symfony comes
with a bundle called `DoctrineCacheBundle`. 

Double check that you have it in your project's composer.json file. If for some reason
you don't have it just use composer to grab it. 

By default it isn't instatiated. In the `AppKernel` file add that to the project since
we want to use the services it provides. `new DoctrineCacheBundle()`. That added a
use statement on top of the class. Just for consistency, add the full namespace down
at the bottom like the rest of the bundles. 
