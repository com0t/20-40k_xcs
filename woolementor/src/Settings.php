<?php
/**
 * All settings related functions
 */
namespace Codexpert\Woolementor;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Settings as Settings_API;

/**
 * @package Plugin
 * @subpackage Settings
 * @author Codexpert <hi@codexpert.io>
 */
class Settings extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}
	
	public function init_menu() {

		global $woolementor, $woolementor_pro;

		$site_config = [
			'PHP Version'				=> PHP_VERSION,
			'WordPress Version' 		=> get_bloginfo( 'version' ),
			'WooCommerce Version'		=> is_plugin_active( 'woocommerce/woocommerce.php' ) ? get_option( 'woocommerce_version' ) : 'Not Active',
			'Elementor Version'			=> is_plugin_active( 'elementor/elementor.php' ) ? get_option( 'elementor_version' ) : 'Not Active',
			'Elementor Pro Version'		=> is_plugin_active( 'elementor-pro/elementor-pro.php' ) ? get_option( 'elementor_pro_version' ) : 'Not Active',
			'CoDesigner Version'		=> $woolementor['Version'],
			'CoDesigner Pro Version'	=> defined( 'WOOLEMENTOR_PRO' ) ? $woolementor_pro['Version'] : 'Not Active',
			'CoDesigner Pro License'	=> defined( 'WOOLEMENTOR_PRO' ) && wcd_is_pro_activated() ? 'Activated' : 'Not Activated',
			'Memory Limit'				=> defined( 'WP_MEMORY_LIMIT' ) && WP_MEMORY_LIMIT ? WP_MEMORY_LIMIT : 'Not Defined',
			'Debug Mode'				=> defined( 'WP_DEBUG' ) && WP_DEBUG ? 'Enabled' : 'Disabled',
			'Active Plugins'			=> get_option( 'active_plugins' ),
			'Checkout Page ID'			=> get_option( 'woocommerce_checkout_page_id' ),
			'Enable Debug' 				=> get_option( 'wl_enable_debug' ),
			'Enabled Widgets'			=> wcd_active_widgets(),
			'Checkout Fields'			=> defined( 'WOOLEMENTOR_PRO' ) ? get_option( '_wcd_checkout_fields' ) : [],
		];
		
		$settings = [
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => $this->name,
			'header'        => $this->name,
			'icon'			=> WOOLEMENTOR_ASSETS . '/img/icon.png',
			'position'		=> 58,
			'sections'      => [
				'woolementor_widgets'	=> [
					'id'        => 'woolementor_widgets',
					'label'     => __( 'Widgets', 'woolementor' ),
					'icon'      => 'dashicons-screenoptions',
					'color'		=> '#42bea9',
					'sticky'	=> true,
					'template'  => WOOLEMENTOR_DIR . '/views/settings/widgets.php',
				],
				'wcd_templates'	=> [
					'id'        => 'wcd_templates',
					'label'     => __( 'Template Library', 'woolementor' ),
					'icon'      => 'dashicons-download',
					'color'		=> '#f46262',
					'no_heading'=> true,
					'hide_form'	=> true,
					'template'  => WOOLEMENTOR_DIR . '/views/settings/templates.php',
				],
				'wcd_email_designer'	=> [
					'id'        => 'wcd_email_designer',
					'label'     => __( 'Email Designer', 'woolementor' ),
					'icon'      => 'dashicons-email-alt',
					'color'		=> '#266fb8',
					'no_heading'=> true,
					'hide_form'	=> true,
					'template'  => WOOLEMENTOR_DIR . '/views/settings/email-designer.php',
				],
				'woolementor_tools'	=> [
					'id'        => 'woolementor_tools',
					'label'     => __( 'Tools', 'woolementor' ),
					'icon'      => 'dashicons-admin-tools',
					'color'		=> '#f29a20',
					'page_load'	=> true,
					'fields'    => [
						'enable_debug' => [
							'id'      	=> 'enable_debug',
							'label'     => __( 'Enable Debug', 'woolementor' ),
							'type'      => 'switch',
							'desc'      => __( 'Enable this if you face any CSS or JS related issues.', 'woolementor' ),
							'disabled'  => false,
						],
						'quantity_input' => [
							'id'      	=> 'quantity_input',
							'label'     => __( 'Fix Quantity Button', 'woolementor' ),
							'type'      => 'switch',
							'desc'      => sprintf( __( 'Check this if you see the %s and %s buttons twice in the cart.', 'woolementor' ), '<button type="button">+</button>', '<button type="button">-</button>' ),
							'disabled'  => false,
						],
						'reset' => [
							'id'      	=> 'reset',
							'label'     => __( 'Reset Settings', 'woolementor' ),
							'type'      => 'switch',
							'desc'      => __( 'This will reset every changes you\'ve made. Don\'t do this unless you know what you\'re doing.', 'woolementor' ),
							'disabled'  => false,
						],
						'report' => [
							'id'      => 'report',
							'label'     => __( 'Report', 'woolementor' ),
							'type'      => 'textarea',
							'desc'     	=> '<button id="wl-report-copy" class="button button-primary"><span class="dashicons dashicons-admin-page"></span></button>',
							'columns'   => 24,
							'rows'      => 10,
							'default'   => json_encode( $site_config, JSON_PRETTY_PRINT ),
							'readonly'  => true,
						],
					]
				],
				'wcd_help' => [
					'id'        => 'wcd_help',
					'label'     => __( 'Help &amp; Support', 'woolementor' ),
					'icon'      => 'dashicons-sos',
					'color'		=> '#008742',
					'template'  => WOOLEMENTOR_DIR . '/views/settings/help.php',
					'hide_form'	=> true,
					'no_heading'=> true,
				],
				'wcd_upgrade'	=> [
					'id'        => 'wcd_upgrade',
					'label'     => __( 'PRO Features', 'woolementor' ),
					'icon'      => 'dashicons-buddicons-groups',
					'color'		=> '#ec5ca7',
					'hide_form'	=> true,
					'no_heading'=> true,
					'template'  => WOOLEMENTOR_DIR . '/views/settings/pro-features.php',
				],
			],
		];

		new Settings_API( apply_filters( 'woolementor-settings_args', $settings ) );
	}

	public function reset( $option_name, $_post ) {
		if ( isset( $_post['reset'] ) && $_post['reset'] == 'on' ) {
			delete_option( $option_name );
			delete_option( 'woolementor_widgets' );
			delete_option( '_wcd_checkout_fields' );
			delete_option( 'wcd_email_designer' );
		}
	}
}