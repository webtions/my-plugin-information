<?php
/**
 * Public functions for My Plugin Information.
 *
 * @package My_Plugin_Information
 */

/**
 * Get full plugin info object from the WordPress.org Plugins API.
 *
 * @param string $slug The WordPress.org slug of the plugin.
 * @return stdClass
 */
function mpi_get_plugin_info( $slug ) {
	global $my_plugin_information;
	return $my_plugin_information->get_plugin_info( $slug );
}

/**
 * Get a specific plugin field from the WordPress.org Plugins API response.
 *
 * @param string $slug  The WordPress.org slug of the plugin.
 * @param string $field The specific field to return (e.g., 'version', 'author').
 * @return string
 */
function mpi_get_plugin_field( $slug, $field ) {
	global $my_plugin_information;
	return $my_plugin_information->get_plugin_field( $slug, $field );
}
