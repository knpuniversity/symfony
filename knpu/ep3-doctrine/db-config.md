# Database Config and Automatic Table Creation

We *described* the `genus` table to Doctrine via annotations, but this table doesn't
exist yet. No worries - Doctrine can create it for us!

And actually, we don't even have a database yet. Doctrine can also handle this. Head
to the terminal use the console to run:

```bash
./bin/console doctrine:database:create
```

But wait! Can Doctrine do this yet? We haven't told it *anything* about the database:
not the name we want, the user or the password.

## Configuring the Database

Where do we do that? The same place that *everything*, meaning all *services* are
configured: `app/config/config.yml`. Scroll down to the `doctrine` key:

[[[ code('930c80e88e') ]]]

Ah, *this* is what tells Doctrine all about your database connection.

But, the information is not hardcoded here - these are references to parameters
that are defined in `parameters.yml`:

[[[ code('278568f4c3') ]]]

Update the `database_name` to `aqua_note` and on my super-secure local machine,
the database user is `root` with no password.

***SEEALSO
Find out more about these parameters in our [Symfony Fundamentals Series][1].
***

Back to the terminal! *Now* hit enter on the command:

```bash
./bin/console doctrine:database:create
```

Database created. To create the table, run:

```bash
./bin/console doctrine:schema:update --dump-sql
```

This looks great - `CREATE TABLE genus` with the two columns. But this didn't *execute*
the query yet - the `--dump-sql` option is used to preview the query if you're curious.
Replace it with `--force`.

```bash
./bin/console doctrine:schema:update --force
```

So hey guys, this is really cool - we can be totally lazy and let Doctrine do all
the heavy database-lifting for us. This `doctrine:schema:update` command is actually
more powerful than it looks - it's going to "wow" us in a few minutes.

But first, let's learn how to insert data into the new table.


[1]: http://knpuniversity.com/screencast/symfony-fundamentals/config-parameters
