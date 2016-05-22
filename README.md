# Joyful Development with Symfony

Well hi there! This repository holds the code and script
for the Symfony course on KnpUniversity.

## Setup

If you've just download the code, congratulations!

To get it working, follow these steps:

**Setup parameters.yml**

First, make sure you have an `app/config/parameters.yml`
file (you should). If you don't, copy `app/config/parameters.yml.dist`
to get it.

Next, look at the configuration and make any adjustments you
need (like `database_password`).

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

**Start the built-in web server**

You can use Nginx or Apache, but the built-in web server works
great:

```
php bin/console server:run
```

Now check out the site at `http://localhost:8000`

Have fun!

## Have some Ideas or Feedback?

And as always, thanks so much for your support and letting us do what
we love!

If you have suggestions or questions, please feel free to
open an issue or message us.

<3 Your friends at KnpUniversity
