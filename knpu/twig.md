# Twig

Let's dive into Twig. Unless you're building just an API Twig is going to be your best friend. It really is
that awesome to work with and really really easy. Let me give you a very intro to it. 

Twig has two syntaxes. First we have `{{ }}` which is the same something tag and `{% %}` which is the do something
tag. Ultimately if what you want to do is print something, you'll use `{{  }}` and in the middle it will be
either a variable name or quotes around a string. If you want to do something like an if statment, a for tag
 or setting a veriable we'll use `{% %}`. 
 
 Head over to Twig's website at twig.sensiolabs.org, click into the documentation and if you scroll down a bit
 you'll find a list of everything that Twig does. The first thing I want to check out is this Tags column. 
 This is the finite list of do someting tags. Click on `if` and we'll see that we would use `{% if %}`. Also
 check out `set` which is writen `{% set %}`. And check out `for`, as you may have guesse dthat one is `{% for %}`.
 For your project you'll probably end up only using 5 or 6 of these do something tags. 
 
 Twig also has other things like functions, there's the dump function which we'll use in a moment. These look
 like normal functions. And there are these filters which look like fancy functions. For example the 
 `lower` filter where you can echo something, | and then you pipe it into the filter. 
 
 Let's make some things happen in this Twig template. One of the things that our Aquanauts will be able to do
 is write notes about a specific genus which we will then render. 
 
 Create this cool `$notes` variable with some hardcoded text and then pass it into our Twig template. 
