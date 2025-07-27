<?php
/**
 * Class file for retrieving WordPress.org plugin information.
 *
 * @package MyPluginInformation
 */

/**
 * Retrieves and processes plugin data from WordPress.org Plugin API.
 */
class My_Plugin_Information {

	/**
	 * Constructor.
	 */
	public function __construct() {}

	/**
	 * Add hooks.
	 *
	 * @return void
	 */
	public function add_hooks() {
		// Hook up to the init action.
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Register shortcode.
	 *
	 * @return void
	 */
	public function init() {
		// Register the shortcode [mpi slug='my-plugin-info' field='version'].
		add_shortcode( 'mpi', array( $this, 'shortcode' ) );
	}

	/**
	 * Get plugin information from WordPress.org.
	 *
	 * @param string $slug The WordPress.org slug of the plugin.
	 * @return stdClass|null Plugin info object or null on failure.
	 */
	public function get_plugin_info( $slug ) {
		// Create a unique transient name based on plugin slug.
		$transient_name = 'mpi-' . $slug;

		// Check if a cached version of the plugin info already exists.
		$info = get_transient( $transient_name );

		if ( empty( $info ) ) {
			// Include the plugin API functions (only available in admin area by default).
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			// Request plugin information from the WordPress.org Plugin API.
			$info = plugins_api( 'plugin_information', array( 'slug' => $slug ) );

			// If the API call failed or returned an error, abort and return null.
			if ( ! $info || is_wp_error( $info ) ) {
				return null;
			}

			// By default, plugin data is cached for 1 hour.
			// Developers can override this using the 'mpi_transient_expiration' filter.
			$expiration = apply_filters( 'mpi_transient_expiration', HOUR_IN_SECONDS, $slug, $transient_name );
			set_transient( $transient_name, $info, $expiration );
		}

		// Add a virtual subfield for the average star rating (e.g., 4.8).
		if (
			is_object( $info )
			&& property_exists( $info, 'ratings' )
			&& is_array( $info->ratings )
		) {
			$total_votes  = array_sum( $info->ratings );
			$weighted_sum = 0;

			foreach ( $info->ratings as $stars => $count ) {
				$weighted_sum += $stars * $count;
			}

			$average = ( $total_votes > 0 ) ? round( $weighted_sum / $total_votes, 1 ) : 0;

			// Add average rating as a virtual subfield.
			$info->ratings['average'] = $average;
		}

		return $info;
	}

	/**
	 * Get a specific field from the plugin info.
	 *
	 * @param string $slug  The WordPress.org slug of the plugin.
	 * @param string $field The field you want to retrieve.
	 * @return string Value of the requested field or empty string.
	 */
	public function get_plugin_field( $slug, $field ) {
		// Fetch the full plugin info object.
		$info = $this->get_plugin_info( $slug );

		// Ensure the info is a valid object and has the requested field.
		if ( ! is_object( $info ) || ! property_exists( $info, $field ) ) {
			return '';
		}

		return $info->{$field};
	}

	/**
	 * Shortcode handler for [mpi].
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function shortcode( $atts = array() ) {
		// Merge provided shortcode attributes with defaults.
		$atts = shortcode_atts(
			array(
				'slug'     => '',
				'field'    => '',
				'subfield' => false,
			),
			$atts
		);

		// Both 'slug' and 'field' are required for the shortcode to work.
		if ( '' === $atts['slug'] || '' === $atts['field'] ) {
			return '';
		}

		// Sanitize the slug and field to avoid injection or malformed input.
		$slug  = sanitize_title( $atts['slug'] );
		$field = sanitize_title( $atts['field'] );

		// If a subfield is specified, attempt to retrieve it from the parent field.
		if ( $atts['subfield'] ) {
			// Sanitize the subfield key.
			$subfield = sanitize_title( $atts['subfield'] );

			// Fetch the full plugin info object.
			$info = $this->get_plugin_info( $slug );

			// Ensure the info is a valid object and has the requested field.
			if ( ! is_object( $info ) || ! property_exists( $info, $field ) ) {
				return '';
			}

			// Extract the parent field value.
			$value = $info->{$field};

			// Return subfield if it exists in the array, otherwise return empty string.
			return is_array( $value ) && isset( $value[ $subfield ] ) ? $value[ $subfield ] : '';
		}

		// Return the field directly if no subfield is specified.
		return $this->get_plugin_field( $slug, $field );
	}
}
