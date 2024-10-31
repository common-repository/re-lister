=== RE Lister ===
Contributors: customscripts, chrisbuck
Tags: real estate, custom post type, meta tags, short code, mls, property
Requires at least: 4.1
Tested up to: 4.8.1
Requires PHP: 5
Stable tag: 2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create real estate listings, complete with MLS information, property details, agent info and more.

== Description ==
Easily create real estate listings, complete with MLS information, property details, agent info and more. Includes convenient shortcodes. Included form fields are based on the Zillow Interchange Format.

== Installation ==
1. Install and activate the plugin from the Plugins admin page.
2. Select \"Listings\" in the admin panel.
3. Select \"Create Listing\" in the sub-menu.
4. Add listing information in the \"Listing Information\" meta box.
5. Add short codes to the listing post body to display the listing information.
6. Note: All listing short codes must be enclosed with [listing] and [/listing]. Other html is allowed.
7. Short codes are simply the camel cased name of the field. E.g., [DisplayAddress] or [StreetAddress] or [BrokerName].

== Frequently Asked Questions ==
= **How do I use the short codes to display listing information?** =
All short codes must be enclosed within a [listing][/listing] short code. The format for enclosed short codes is simply the camel-cased field name, e.g., [DisplayAddress], [BrokerName], etc.
"Camel case," in this context, refers to capitalizing the first letter of each word in the label, and removing any empty spaces. E.g., "Street Address" becomes "StreetAddress." You then need to enclose the camel-cased label in brackets, e.g., [StreetAddress]. Also be sure to enclose the short code in the parent short codes, [listing] and [/listing]. (Notice that the listing short codes are not capitalized).
= **Are there short codes for all fields?** =
No. Shortcodes are available for the vast majority of listing fields, but not for certain ones that have the same label as another field. For example, "Picture URL" is a field in both the "Picture" and "Agent" sections. Using [PictureURL] will display the URL **only** for the Picture section, not the Agent section.

Similarly, there are "Street Address" fields in both the Location and Office sections. The [StreetAddress] shortcode will only show the address for the Location.
= **I want a better way to sort through my listings (other than Categories and Tags). Can I do that?** =
This feature is coming soon.
= **Can I publish listings as a (Zillow Interchange Format) feed?** =
No, not yet. This feature is coming soon.

== Screenshots ==
1. Display listing information by including shortcodes within [listing] and [/listing].
2. Save listing information in the form fields.
3. Listing information displays (via shortcode) in the Listing post type.

== Changelog ==

= 2.1 =
* Added TGM Plugin Activation to recommend RE-Feed plugin (wordpress.org/plugins/re-feed).

= 2.0 =
* Updated readme.txt: FAQ and Author URI.
* Added shortcode descriptions on hovering over field labels.
* Updated FAQs.
* Added "Documentation" submenu for Listings post type.
* Fixed meta key references for Floor Covering, Heating Fuels, Heating Systems, Parking Types, View Type.
* Added maxlength characters for Agent -> EmailAddress, Broker -> EmailAddress, and BasicDetails -> Description.

= 1.1 =
* Stable, initial release

== Additional Info ==
**New:** A plugin to publish listings as RSS (in the Zillow Interchange Format).
Check out the RE Feed plugin in the WP Repository!

*For more information, follow us online at customscripts.tech*