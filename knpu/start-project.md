# Start Project

Well hey guys! You know what? I'm *pumped* that you're learning Symfony, because
it's the hardest framework ever! Relax, I'm kidding. Symfony *does* have a reputation
for being tough to learn, but this is a trap! Or at least, it's an outdated idea.

Look: Symfony can be *incredibly* simple and will put you in a position to write
powerful, well-designed code, whether it's for an API or a traditional web app. And
when it does get a bit more difficult, it's usually because you're learning best
practices and object oriented goodness that's turning you into a better developer.

## Symfony Components & Framework

So what is Symfony anyways? First, it's a set of components: meaning PHP libraries.
Actually, it's about 30 small libraries. That means that you could use Symfony in
your non-Symfony project today by using one of its little libraries. One of my favorites
is called Finder: it's really good at searching deep into directories for files.

But Symfony is also a framework where we've taken all of those components and glued
them together for so that you can get things done faster. This series is all about
doing *amazing* things with the Symfony framework. 

## The Symfony Installer

Let's get our first Symfony project rolling. Head over to [Symfony.com](http://symfony.com/download)
and click 'Download'. Our first task is to get the `Symfony Installer`. Depending
on your system, this means running commands from one of these boxes. Since I'm on
a mac, I'll copy the `curl` command and paste it into the terminal:

```bash
sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
```

Copy the second command and run that to adjust some permissions:

```bash
sudo chmod a+x /usr/local/bin/symfony
```

This gives us a new `symfony` executable:

```bash
symfony
```

But hold on! This is *not* Symfony, it's the Symfony Installer: a tiny utility that
makes it really easy to start new Symfony projects.

## Downloading the Project

Let's start one! Run `symfony new` and then the name of the project. Call the project
`aqua_note`:

```bash
symfony new aqua_note
```

I'll tell you more about it soon. In the background this is downloading a new Symfony
project, unzipping it, making sure your system is configured, warning you of any
problems and then dropping the new files into this `aqua_note` directory. Not bad!

***TIP
The project name - `aqua_note` - is only used to determine the directory name: it's
not important at all afterwards.
***

Move into the directory and check it out.

```bash
cd aqua_note
ls
```

This is *also* not Symfony: it's just a set of files and directories that form a web
app that *use* the Symfony libraries. Those libraries - along with other third-party
code - live in the `vendor/` directory.

Before I explain the other directories, let's get this thing working! Run:

```bash
php bin/console server:run
```

to start the built in PHP web server. Yes, you can also use Nginx or Apache: but this
is much easier for development. When you're done later, just hit ctrl+c to stop the
server.

As the comment says here, go to `http://localhost:8000` in your browser. And boom!
Congrats! This is your first page being executed by the Symfony framework. That's
right: this is being rendered dynamically from the files inside of your project.
At the bottom, you'll see one of the *best* features of Symfony: the web debug toolbar.
This is *full* of debugging information - more on that later.

Ok, let's start building our own pages!
