# Setup! PhpStorm + git

I've already opened the project in PhpStorm. It is by *far* the best editor for
working with Symfony. And I'm not even getting paid to say this! Though, if
there are any PhpStorm employees watching, I do accept payment in ice cream.

Anyways, it's awesome, but not free, but totally worth it. It has a free trial: so
go download it and follow along with me.

## The PhpStorm Symfony Plugin

To get *really* crazy, you'll want to install the *amazing*, incredible Symfony plugin.
This thing makes Symfony development so absurdly fun, I'm going to walk you through
its installation right now.

In Preferences, search for Symfony and click the plugins option. From here, click
'Browse Repositories` and then find the Symfony Plugin. You'll recognize it as the
one with over 1.3 *million* downloads.

***TIP
You should *also* find and install the [PHP Annotations][2] plugin. That will give you
the awesome annotations auto-completion that you'll see in the video.
***

I already have it installed, but if you don't, you'll see an `Install Plugin` button.
Click that and then restart PHPStorm. Once you're back, go into Preferences again
and search for Symfony to find the new "Symfony Plugin" item. To activate the magic,
click the "Enable Plugin for this Project" checkbox. Do this once per project. Oh,
and also make sure that these paths say `var/cache` instead of `app`.

***SEEALSO
If you're interested in more PHPStorm tricks we have an entire [screencast][1] on it
for you to enjoy.
***

## Starting the git Repository

Ready to code? Wait! Before we break stuff, let's be good developers and start a
new git repository. Our terminal is blocked by the built-in web server, so open up
a new tab. Here, run:

```bash
git init
git add .
git status
```

The project already has a `.gitignore` file that's setup to avoid committing anything
we don't want, like the `vendor/` directory and the file that holds database credentials.
Hey, thanks Symfony! Make the first commit and give it a clever message... hopefully,
more clever than mine:

```bash
git commit
```


[1]: http://knpuniversity.com/screencast/phpstorm
[2]: https://plugins.jetbrains.com/plugin/7320
