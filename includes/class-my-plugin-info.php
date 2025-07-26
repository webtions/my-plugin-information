<?php

class DOT_MyPluginInfo {


	/**
	 * Constructor
	 */
	public function __construct() {	}

	/**
	 * Add hooks
	 */
	public function add_hooks() {
		// Hook up to the init action
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Runs when WordPress is initialized
	 */
	public function init() {
		// Register the shortcode [mpi slug='my-plugin-info' field='version']
		add_shortcode( 'mpi', array( $this, 'shortcode' ) );
	}

	/**
	 * @param string $slug The WordPress.org slug of the plugin
	 * @return StdClass
	 */
	public function get_plugin_info( $slug ) {

		// Create a empty array with variable name different based on plugin slug
		$transient_name = 'mpi' . $slug;

		/**
		 * Check if transient with the plugin data exists
		 */
		$info = get_transient( $transient_name );

		if ( empty( $info ) ) {

			/**
			 * Connect to WordPress.org using plugins_api
			 * About plugins_api -
			 * http://wp.tutsplus.com/tutorials/plugins/communicating-with-the-wordpress-org-plugin-api/
			 */
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			$info = plugins_api( 'plugin_information', array( 'slug' => $slug ) );


			// Check for errors with the data returned from WordPress.org
			if ( ! $info or is_wp_error( $info ) ) {
				return null;
			}


			// Set a transient with the plugin data
			// Use Options API with auto update cron job in next version.
			set_transient( $transient_name, $info, 1 * HOUR_IN_SECONDS );
		}

		return $info;
	}

	/**
	 * Get a specific field
	 *
	 * @param string $slug The WordPress.org slug of the plugin
	 * @param string $field The field you want to retrieve
	 *
	 * @return string
	 */
	public function get_plugin_field( $slug, $field ) {

		// Fetch info
		$info = $this->get_plugin_info( $slug );

		if( ! is_object( $info ) || ! property_exists( $info, $field ) ) {
			return '';
		}

		return $info->{$field};
	}

	/**
	 * @param array $atts
	 *
	 * @return string
	 */
	public function shortcode( $atts = array() ) {

		// get our variable from $atts
		$atts = shortcode_atts( array(
			'slug' => '', //foo is a default value
			'field' => '',
			'subfield' => false
		), $atts );

		/**
		 * Slug & field must both be givens
		 */
		if ( '' === $atts['slug'] || '' === $atts['field'] ) {
			return '';
		}

		// Sanitize slug attribute
		$slug = sanitize_title( $atts['slug'] );

		// Sanitize field attribute
		$field = sanitize_title( $atts['field'] );

		// If set subfield value
		if ( $atts['subfield'] ) {
			
		    // Sanitize subfield attribute
		    $subfield = sanitize_title( $atts['subfield'] );
		
		    // Rertrieve parent
		    $value = $this->get_plugin_field( $slug, $field );
			
		    // Get subfield value
		    return $value[$subfield];
			
		} else {
		    return $this->get_plugin_field( $slug, $field );
		}	
	}


}
