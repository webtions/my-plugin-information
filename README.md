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

### 0.4.0 (2025-07-26)

- Added support for `subfield` attribute in the shortcode (thanks to [@vyskoczilova](https://profiles.wordpress.org/vyskoczilova/))
- Allows access to nested fields like `sections` and `ratings`
- Updated readme with full usage and development instructions
- Improved shortcode logic and fallback handling

### 0.3.0 (2015-06-24)

- Code cleanup and improvements (thanks to [@dvankooten](https://profiles.wordpress.org/dvankooten/))

### 0.1.0 (2013-09-30)

- Initial release

</details>
