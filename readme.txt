=== Cr3ativ Carousel ===
Contributors: Cr3ativ
Tags: carousel
Requires at least: 3.0.1
Tested up to: 4.3
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Cr3ativ Carousel plugin is taken from a custom post type used to create an easy to use carousel using your content (text, images or links) and display it in a carousel in up to 4 columns based on the category you choose.


== Description ==

Easily add as many carousel items as you'd like by category.  

Using the owl script available here http://owlgraphic.com/owlcarousel/ - we have created an easy to use plugin based on the content area.

You can include these items by carousel category in a post or page using the short code:

[carousel-loop columns="3" category="logos"] 

Above is an example of that short code.  We state how many columns we want to display and from what carousel category (which is the slug name of the category (all lower case and spaces are separated by -).

We also provide a widget for this plugin to utilize the same as the short code with the exception of you can tell the carousel how to sort the items and the carousel category is provided by a drop down menu.

For your convenience, the plugin also contains a directory called languags, you will find the mo/po files used for this plugin here.



== Plugin Installation ==

1. Upload the `cr3ativ-carousel` folder to your to the `/wp-content/plugins/` directory or alternatively upload the cr3ativ-carousel.zip via the plugin page of WordPress by clicking 'Add New' and select the zip from your local computer.

2. Activate the plugin once uploaded.


3. You will now see a new post type on the left of the WP admin menu named Carousel Item.

OR You can just go to your WordPress admin area, click Plugins > Add New and in the search box type Cr3ativ Carousel and choose to install and activate from the WordPress Plugin page.


== Creating a Single Carousel Item ==

1. Click ‘Carousel Item > Add New' from your WordPress admin menu.

2. Name your post with your carousel item name you wish to use.

3. Give your new post a 'Carousel Category' name.  You will need this later for when you use the short code or widget.  These can be found under 'Carousel Item' / 'Carousel Category'.  When using the shortcode you will use the slug of the Carousel Category.  When using the widget, these will be automatically displayed in a drop down for you to choose from.

4. Add regular content including images, text, links as you normally would when creating a post.  This plugin does not use the ‘featured image’ so you will not see the ‘featured image’ area that you are used to seeing on a WordPress post, don’t panic, it’s not broken, it’s missing by design to stop any confusion on where to put your images/content.

5. Click ‘Publish’.

6. Using either the widget or the short code, you can now put your carousel items by category anywhere on your WordPress site



== Styling ==
Styling for these page templates are included in the includes directory under :

/css/owl.carousel.css



== Changelog ==

= 1.1.0 =
Updated widget section to support WP 4.3.

= 1.0.6 =
Updated version # and removed extra css files no longer needed for owl carousel.

= 1.0.5 =
Updated to add missing images from CSS files, combined all 3 CSS files into 1 css file and updated the loops to include all items instead of just displaying the # of items based on WordPress reading settings.

= 1.0.4 =
Updated admin column view incase short codes are being used and added CSS to column to scroll when a lot of text is used in the content area.

= 1.0.3 =
Updated cr3ativ-carousel.php to fix issue with ‘headers already sent’ error message.

= 1.0.2 =
Updated admin view and updated the language files. Removed the ‘featured image’ section since this is not used.

= 1.0.1 =
Updated plugin to fix issue with conflict on WP Settings > Reading.

= 1.0 =
* First release.