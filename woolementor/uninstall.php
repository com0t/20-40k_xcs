<?php
/**
 * Uninstall Woolementor.
 *
 * @package Woolementor
 */

// Exit if accessed directly.
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

// Remove options that were added by Woolementor
$options_keys = [ 'wcd_email_designer', 'wcd_install_time', 'wcd_installed', 'wcd_survey', 'woolementor_tools', 'wcd_version', 'woolementor_widgets', 'woolementor-activated', 'woolementor-docs-json' ];
foreach ( $options_keys as $key ) {
	delete_option( $key );
}