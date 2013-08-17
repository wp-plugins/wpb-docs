=== WPB Docs ===
Contributors: Mladjo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=QXZZJ83F6PBDQ&lc=SE&item_name=WPB%20Docs&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags:  shortcode, custom post type, bootstrap, documentation
Requires at least: 3.3.0
Tested up to: 3.6
Stable tag: 1.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easy to use WordPress plugin that make Twitter's Bootstrap like documentation.

== Description ==

Twitter's Bootstrap style documentation management plugin. Registers a custom post type for documents. Items can be grouped by Taxonomy Categories.
Easy to display via shortcode.

== Installation ==

Just install and activate as any other WordPress plugin.

To display your documents, please use the following shortcode:

*[wpb_docs]*

Shortcode accepts following arguments

* 'limit' => 5 (the maximum number of items to display)
* 'orderby' => 'menu_order' (how to order the items - accepts all default WordPress ordering options)
* 'order' => 'DESC' (the order direction)
* 'doc_category' => 'Category name' (the name of the category to filter by)

= Usage Examples =
*[wpb_docs limit="10" doc_category="My Category" orderby="menu_order" order="DESC"]*
*[wpb_docs limit="10" doc_category="My Category"]*

== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

= 1.0.0 =
* Initial release.
