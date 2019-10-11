# Recipes Archive

THIS IS NOT A FOOD BLOG

It's just a simple site that uses WordPress to create a shared archive of recipes that's searchable, taggable, and shareable.

No fancy photos or walls of text to scroll past to get to the directions - I just got tired of digging in vain through emails and text files for the word "cheese" when it turns out I should've been looking for "mozzarella" instead.

## Setup

1. Clone this git repo into the document root:

	```git clone git@github.com:kjnedrud/recipes.git .```

2. From the document root, get the latest WP version:

	```svn co http://core.svn.wordpress.org/tags/[WORDPRESS_VERSION] .```

3. Create a new blank MySQL database and have the credentials handy...

4. Copy sample config file:

	```cp external-config-sample.php external-config.php```

5. Edit `external-config.php` to add database credentials and other configs

6. Visit in web browser and complete the WP site setup steps

### Permissions

The following directories may need permissions set:

 * `content/uploads`
 * `content/themes/recipes/acf-json`

Recursively set the owner (group will likely be `_www` on local Mac environment and `www-data` on web server) and add write permissions:

```sudo chown -R [user]:[group] [directory]```

```chmod -R g+w [directory]```

## Useful Commands

### Compile CSS

```sass --watch main.scss main.css```

### Upgrade WordPress

```svn sw http://core.svn.wordpress.org/tags/[WORDPRESS_VERSION] .```
