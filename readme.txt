=== My Plugin Information – Fetch Data from WordPress.org ===
Contributors: themeist, hchouhan
Donate link: https://themeist.com/plugins/wordpress/my-plugin-information/
Tags: plugin data, WordPress.org, shortcode, plugin info, directory
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL-3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Fetch plugin data from WordPress.org using a simple shortcode. Shows version, installs, ratings, and more. Cached for speed, auto-updated hourly.


== Description ==

Want to display information about any plugin hosted on WordPress.org?

This plugin lets you fetch and display details like version, active installs, ratings, changelog, and more using a simple shortcode. Data is pulled from the WordPress.org Plugin API, cached locally for performance, and automatically refreshed every hour.

Perfect for plugin developers who want to show up-to-date info about their own plugins on their site.

If you find this plugin useful, please consider [leaving a review](https://wordpress.org/support/plugin/my-plugin-information/reviews/?rate=5#new-post). It helps others discover the plugin and supports continued development.

== Installation ==

1. Go to **Plugins → Add New** in your WordPress dashboard.
2. Search for “My Plugin Information” and click **Install Now**.
3. Activate the plugin.
4. Add a shortcode like `[mpi slug="plugin-slug" field="version"]` to any post, page, or widget area.
5. Replace `plugin-slug` with the actual slug of the plugin you want to display information for.

For advanced usage examples and developer functions, see the [documentation on Themeist](https://themeist.com/plugins/wordpress/my-plugin-information/).

== Frequently Asked Questions ==

= How to get support? =
You can visit the [support forum](https://wordpress.org/support/plugin/my-plugin-information/) and start a discussion if needed.

= Where can I report bugs or contribute? =
You can report issues or contribute to the plugin on [GitHub](https://github.com/webtions/my-plugin-information).

= How often is the plugin data updated? =
The plugin uses transients and fetches fresh data from WordPress.org every hour by default.

= Can I change how long the plugin data is cached? =
Yes, there is a filter available to change the transient expiration time. Useful if you want shorter or longer cache duration depending on your needs.

== Changelog ==

= 1.0.0 - (27 July 2025) =
* Renamed class file and class name to match plugin slug
* Added support for `subfield` attribute in the shortcode (thanks to [@vyskoczilova](https://profiles.wordpress.org/vyskoczilova/))
* Allows access to nested fields like `sections` and `ratings`
* Improved shortcode logic with fallback handling
* Fixed all PHPCS issues, improved formatting and comments
* Updated readme with full usage and development instructions

= 0.3.0 - (24 June 2015) =
* Simplified shortcode logic by removing hardcoded if checks for specific fields like rating, version, etc. (thanks to [@dvankooten](https://profiles.wordpress.org/dvankooten/))
* Now all fields are fetched dynamically from the API response
* Code cleanup and formatting improvements

= 0.2.0 - (30 April 2014) =
* Added 3 new fields (thanks to [Piet from SenlinOnline.com](https://profiles.wordpress.org/senlin/))

= 0.1.1 - (07 October 2013) =
* Structural changes to improve logic

= 0.1 - (30 September 2013) =
* Initial release
