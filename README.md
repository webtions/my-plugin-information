# My Plugin Information #

A developer-focused WordPress plugin that lets you **fetch and display information** about any plugin hosted on WordPress.org.

It provides a shortcode and helper functions to retrieve common fields such as `version`, `changelog`, `active_installs`, and many others available via the Plugin API.

Data is pulled from the WordPress.org Plugin API, **cached locally** using transients, and **automatically refreshed every hour** to reduce API calls and ensure **fast performance**.

**Reference article**: [Communicating with the WordPress.org Plugin API](https://code.tutsplus.com/communicating-with-the-wordpressorg-plugin-api--wp-33069t)


## Usage

Use the `[mpi]` shortcode to output plugin information from WordPress.org.

### Basic example

```
[mpi slug='my-plugin-slug' field='version']
```

### With nested subfield

Use the optional `subfield` parameter to access nested fields:

```
[mpi slug='my-plugin-slug' field='sections' subfield='changelog']
```

## Available Shortcode Fields

Use the `[mpi]` shortcode to retrieve data from the WordPress.org Plugin API.

### Basic Fields

These can be used directly via the `field` attribute:

- `name`
- `slug`
- `version`
- `author`
- `author_profile`
- `requires`
- `tested`
- `requires_php`
- `rating`
- `num_ratings`
- `support_url`
- `support_threads`
- `support_threads_resolved`
- `active_installs`
- `last_updated`
- `added`
- `homepage`
- `download_link`
- `donate_link`
- `preview_link`

### Nested Fields (with `subfield`)

Some fields return structured data (arrays). You can access sub-parts of these fields using the `subfield` attribute.

```text
[mpi slug='my-plugin-information' field='sections' subfield='changelog']
[mpi slug='my-plugin-information' field='ratings' subfield='5']
```

#### `sections` supports:
- `description`
- `installation`
- `faq`
- `changelog`
- `reviews`

#### `ratings` supports:
- `5`, `4`, `3`, `2`, `1` — count of each star rating


> ℹ️ Other complex fields like `contributors`, `tags`, and `versions` are not supported via shortcode.
> To access them, use the `mpi_get_plugin_info()` function in your PHP code.

---

## Security

If you discover a security vulnerability in this plugin, please report it privately to `mail@webtions.com` so it can be addressed responsibly.

## License

This plugin is licensed under the [GPL-3.0 License](http://www.gnu.org/licenses/gpl-3.0.txt).

## Credits

Thanks to the following contributors for helping improve this plugin:

- [@dvankooten](https://github.com/dvankooten) – code cleanup and improvements
- [@vyskoczilova](https://github.com/vyskoczilova) – added support for `subfield` attribute

---

## Development

<details><summary>Show setup instructions</summary>

### Setup

To contribute to the plugin and ensure your code follows coding standards:

1. Clone the repository:

    ```sh
    git clone https://github.com/webtions/my-plugin-information.git
    ```

2. Navigate to the plugin directory:

    ```sh
    cd my-plugin-information
    ```

3. Install PHP dependencies:

    ```sh
    composer install
    ```

### Development Commands

Check for coding standard issues:

```bash
composer standards:check
```

Automatically fix fixable code style issues:

```bash
composer standards:fix
```

Run static analysis:

```bash
composer analyze
```

> This plugin follows the official [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/).

</details>

## Changelog

<details><summary>View changelog</summary>

### 1.0.0 - (27 July 2025)

- Added `mpi_transient_expiration` filter to control cache duration
- Added `subfield` shortcode attribute (thanks to [@vyskoczilova](https://profiles.wordpress.org/vyskoczilova/))
- Added support for nested fields like `sections` and `ratings`
- Added support for retrieving average star rating using the `ratings.average` subfield, e.g. `[mpi slug="plugin-slug" field="ratings" subfield="average"]`
- Changed transient naming format to `mpi-{slug}`
- Renamed class file and class name to match plugin slug
- Improved shortcode fallback handling
- Fixed issues reported by PHPCS and PHPStan
- Added inline comments throughout the plugin
 Updated readme with usage and dev instructions

### 0.3.0 - (24 June 2015)

- Simplified shortcode logic by removing hardcoded if checks for specific fields like rating, version, etc. (thanks to [@dvankooten](https://profiles.wordpress.org/dvankooten/))
- Now all fields are fetched dynamically from the API response

### 0.2.0 - (30 April 2014)

- Added 3 new fields (thanks to [Piet from SenlinOnline.com](https://profiles.wordpress.org/senlin/))

### 0.1.1 - (15 November 2013)

- Structural changes to improve logic

### 0.1.0 - (30 September 2013)

- Initial release

</details>
