# RizeMeet facilitates recurring meeting organization

## Purpose 
You want to regularly meet with a group of friends/colleagues, etc... and coordinating meeting date, time, and place, while having a minimal presnece online that introduces your group.

You need a content management system (CMS), but many of these are overly complex (e.g. Wordpress).

RizeMeet provides:
- Having a static front page
- Dynamic meeting date/time and location update
- Easy publishing of minutes
- Simple mailing list

RizeMeet is meant to coordinate meetings of small groups.
It fits for a specific niche requiring a specific and minimal functionality.

You may find other CMS, such as Hugo, more suitable for anything more full-fledged as a website.

You can choose to use the filesystem or a DB to store the mailing list.

## Installation

1. Create the site folder next to the 'www' and 'php' folders.
2. Retrieve the PHP dependencies with composer. Run: `composer update``
3. Depending on what permissions your server has you may need to set folder permissions for it to write to various folders (e.g., site, www/admin, www/imgs)

## Want to contribute?

The aim is to provide a simple but functional set of specific features.

See problems with functionality? Design? Interaction? Let us know.

## To do

- Check the admin page date update - does it update visually on submit?
- Use a month-code for each meeting - so sending a new invite will move the meeting rather than creating a second one
