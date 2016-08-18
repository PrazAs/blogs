=== What Would Seth Godin Do ===
Contributors: richardkmiller
Donate link: http://richardkmiller.com/
Tags: marketing, segmentation, cookies, Seth Godin, GPL
Requires at least: 3.1
Tested up to: 4.6
Stable tag: 2.0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays a custom welcome message to new visitors and another to return visitors.

== Description ==

Seth Godin advocates using [cookies](http://en.wikipedia.org/wiki/HTTP_cookie) to distinguish between new and returning visitors to your site:

>"One opportunity that's underused is the idea of using cookies to treat returning visitors differently than newbies. It's more work at first, but it can offer two experiences to two different sorts of people." (Source: [In the Middle, Starting](http://sethgodin.typepad.com/seths_blog/2006/08/in_the_middle_s.html))

I built this WordPress plugin to implement Seth Godin's idea. It reduces the "work at first" to almost nothing.

By default, new visitors to your blog will see a small box above each post containing the words "If you're new here, you may want to subscribe to my RSS feed. Thanks for visiting!" After 5 visits the message disappears. You can customize this message, its lifespan, and its location. The message can be excluded from certain pages if desired.

New visitors will appreciate some context and background information about your site. This is your chance to offer them a special welcome and invite them to become permanent subscribers. You can also specify a message for return visitors.

I can be reached at richard AT richardkmiller DOT com. I appreciate comments and suggestions.


== Installation ==

Installation is easy:

1. Download the WWSGD WordPress plugin and unzip it.
2. Copy the `what-would-seth-godin-do` folder to your WordPress plugins folder (`/wp-content/plugins/`).
3. Activate the plugin on the *Plugins* page.
4. Customize settings in the *Settings* panel, *WWSGD* subpanel.

That's it!


Subversion (SVN) users can check out the plugin directly from the WordPress.org repository:

[http://plugins.svn.wordpress.org/what-would-seth-godin-do/](http://plugins.svn.wordpress.org/what-would-seth-godin-do/)


== Frequently Asked Questions ==

= Can I position the welcome message before the title or elsewhere on the page? =
>You can position the welcome message in any specific location by using the template tag `<?php wwsgd_the_message(); ?>` in your theme.

= Does this plugin work with WP Super Cache and other caching plugins? =
>Yes, as of version 2.0, WWSGD works with WP Super Cache and other caching plugins.

= Will my welcome message be indexed by Google and other search engines? =
>No, as of version 2.0, your WWSGD message will not visible to search engine crawlers and will not be indexed.


== Screenshots ==

1. After activating *What Would Seth Godin Do*, you can configure settings in the Settings -> WWSGD menu.  You can customize the message, its lifespan, and its location. You can also display a message for return visitors.
2. Your welcome message appears before (or after) each post for the specified length of time.


== CHANGELOG ==
= 2.0.6 =
* Bug fix: Make WWSGD compatible with SSL by using plugins_url() instead of WP_PLUGIN_URL

= 2.0.5 =
* Bug fix: The welcome message was not being displayed on individual posts and page when certain plugins were installed (e.g. WordPress SEO by Yoast) that use `the_content` or `the_excerpt` internally. (Thanks to Rob Woodgate.)
* Tested with WordPress 3.6
* Updated informational links in Admin panel
* Updated copyright year
* Added License tag (GPLv2)

= 2.0.4 =
* Fixed problem with jQuery not being loaded

= 2.0.3 =
* WWSGD only sets one cookie now, not a separate cookie for each post or page. (Fixed regression.)

= 2.0.2 =
* Moved JS from header to footer. Fixed loading of JS file from non-standard WP paths. (Thanks to Kenn Wilson and gwk0.)
* Tested with WordPress 3.2

= 2.0.1 =
* Fixed bug: I forgot to set an expiration on the cookie.

= 2.0 =
* Cookie logic now occurs in the browser (using jQuery) instead of on the server to prevent welcome message from being displayed to search engines. (Thanks to [Chris Abraham](http://cjyabraham.com/) for sending a patch.)
* User can now exclude specific posts or pages from displaying the welcome message.
* Cleaned up Settings panel to match WordPress UI.
* Added better feedback links.

= 1.7.3 =
* Don't show message on excerpts
* Tested with WordPress 3.1.3

= 1.7.2 =
* Tested with WordPress 3.1

= 1.7.1 =
* Tested with WordPress 3.0

= 1.7 =
* Added template tag <?php wwsgd_the_message(); ?> which can be used in themes for positioning the message in any location.

= 1.6 =
* Added option to exclude welcome message from Pages. Default is to show on both Posts and Pages.
* No "welcome back" message by default.

= 1.5 =
* Added "welcome back" message for return visitors.
* Welcome message is shown only once on pages with multiple posts.
* Added nonces for improved security.
* Improved security against XSS attacks.

= 1.0 =
* Initial release.


== Upgrade Notice ==
= 2.0.6 =
Fixed a bug that caused errors on SSL pages

= 2.0.5 =
Fixed a bug that prevented the welcome message from displaying on individual posts when certain plugins were installed.

= 2.0.4 =
WWSGD now working with the latest version of WordPress, fixing a problem loading jQuery.

= 2.0.3 =
The WWSGD counter (and cookie) is now site-wide, not a separate counter for each page. (This is a return to the original v1 behavior.)

= 2.0.2 =
WWSGD now works when WordPress is installed in a separate directory from the site root.

= 2.0.1 =
WWSGD now works with caching plugins and is invisible to search engines. You can also exclude specific posts or pages from displaying the welcome message.

= 2.0 =
WWSGD now works with caching plugins and is invisible to search engines. You can also exclude specific posts or pages from displaying the welcome message.

