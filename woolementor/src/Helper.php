<?php
/**
 * All helpers functions
 */
namespace Codexpert\Woolementor;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\License;
use Elementor\Controls_Manager;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Helper
 * @author Codexpert <hi@codexpert.io>
 */
class Helper extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	public static function pri( $data ) {
		echo '<pre>';
		if( is_object( $data ) || is_array( $data ) ) {
			print_r( $data );
		}
		else {
			var_dump( $data );
		}
		echo '</pre>';
	}

	/**
	 * @param bool $show_cached either to use a cached list of posts or not. If enabled, make sure to wp_cache_delete() with the `save_post` hook
	 */
	public static function get_posts( $args = [], $show_heading = false, $show_cached = false ) {

		$defaults = [
			'post_type'         => 'post',
			'posts_per_page'    => -1,
			'post_status'		=> 'publish'
		];

		$_args = wp_parse_args( $args, $defaults );

		// use cache
		if( true === $show_cached && ( $cached_posts = wp_cache_get( "wcd_{$_args['post_type']}", 'woolementor' ) ) ) {
			$posts = $cached_posts;
		}

		// don't use cache
		else {
			$queried = new \WP_Query( $_args );

			$posts = [];
			foreach( $queried->posts as $post ) :
				$posts[ $post->ID ] = $post->post_title;
			endforeach;
			
			wp_cache_add( "wcd_{$_args['post_type']}", $posts, 'woolementor', 3600 );
		}

		$posts = $show_heading ? [ '' => sprintf( __( '- Choose a %s -', 'woolementor' ), $_args['post_type'] ) ] + $posts : $posts;

		return apply_filters( 'wcd_get_posts', $posts, $_args );
	}

	public static function get_option( $key, $section, $default = '' ) {

		$options = get_option( $key );

		if ( isset( $options[ $section ] ) ) {
			return $options[ $section ];
		}

		return $default;
	}

	/**
	 * Includes a template file resides in /views diretory
	 *
	 * It'll look into /woolementor directory of your active theme
	 * first. if not found, default template will be used.
	 * can be overwriten with wcd_template_overwrite_dir hook
	 *
	 * @param string $slug slug of template. Ex: template-slug.php
	 * @param string $sub_dir sub-directory under base directory
	 * @param array $fields fields of the form
	 */
	public static function get_template( $slug, $base = 'views', $args = null ) {

		// templates can be placed in this directory
		$overwrite_template_dir = apply_filters( 'wcd_template_overwrite_dir', get_stylesheet_directory() . '/woolementor/', $slug, $base, $args );
		
		// default template directory
		$plugin_template_dir = dirname( WOOLEMENTOR ) . "/{$base}/";

		// full path of a template file in plugin directory
		$plugin_template_path =  $plugin_template_dir . $slug . '.php';
		
		// full path of a template file in overwrite directory
		$overwrite_template_path =  $overwrite_template_dir . $slug . '.php';

		// if template is found in overwrite directory
		if( file_exists( $overwrite_template_path ) ) {
			ob_start();
			include $overwrite_template_path;
			return ob_get_clean();
		}
		// otherwise use default one
		elseif ( file_exists( $plugin_template_path ) ) {
			ob_start();
			include $plugin_template_path;
			return ob_get_clean();
		}
		else {
			return __( 'Template not found!', 'woolementor' );
		}
	}

	/**
	 * Returns the text (Pro) if pro version is not activated.
	 *
	 * @return boolen
	 *
	 * @since 1.0
	 */
	public static function pro_text() {
	    return ( self::is_pro_activated() ? '' : '<span class="wl-pro-text"> ('. __( 'PRO', 'woolementor' ) .')</span>' );
	}

	/**
	 * Returns the Pro overlay if pro version is not activated.
	 *
	 * @return string
	 *
	 * @since 3.0
	 */
	public static function pro_overlay( $widget_title, $file = __FILE__ ) {
	    if( !current_user_can( 'edit_pages' ) ) return;

	    echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $widget_title, '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

	    if( file_exists( dirname( $file ) . '/assets/img/screenshot.png' ) ) {
	        echo "<img src='" . plugins_url( 'assets/img/screenshot.png', $file ) . "' />";
	    }
	}

	/**
	 * Centralized the elementor controls for managing query in shop widgets
	 *
	 * @return elementor controls
	 *
	 * @author Jakaria Istauk <jakariamd35@gmail.com>
	 * 
	 * @since 3.0
	 */
	public static function get_shop_query_controls( $element ){
		/**
		 * Product Source
		 */
		$element->start_controls_section(
		    'product_source_control',
		    [
		        'label' => __( 'Product Source', 'woolementor' ),
		        'tab'   => Controls_Manager::TAB_CONTENT,
		    ]
		);


		$element->add_control(
		    'product_source',
		    [
		        'label'     => __( 'Source Type', 'woolementor' ),
		        'type'      => Controls_Manager::SELECT,
		        'default'   => 'shop',
		        'options'   => [
		            'shop'              => __( 'Shop', 'woolementor' ),
		            'related-products'  => __( 'Related Products', 'woolementor' ),
		            'upsells'           => __( 'Up Sells', 'woolementor' ),
		            'cross-sells'       => __( 'Cross Sells', 'woolementor' ),
		            'cart-upsells'  	=> __( 'Cart Up Sells', 'woolementor' ),
		            'cart-cross-sells'  => __( 'Cart Cross Sells', 'woolementor' ),
		            'cart-related-products' => __( 'Cart Related Products', 'woolementor' ),
		        ],
		        'label_block' => true
		    ]
		);

		/**
		 * Query non shop types
		 */
		$element->start_controls_tabs(
		    'non_shop_souce_section',
		    [
		        'separator' => 'before',
		        'condition' => [
		            'product_source!' => 'shop'
		        ],
		    ]
		);

		$element->start_controls_tab(
		    'non_shop_souce_tab',
		    [
		        'label'     => __( '', 'woolementor' ),
		    ]
		);

		$element->add_control(
		    'content_source',
		    [
		        'label' => __( 'Content Source', 'woolementor' ),
		        'type' => Controls_Manager::SELECT,
		        'options' => [
		            'current_product'   => __( 'Current Product', 'woolementor' ),
		            'different_product' => __( 'Custom', 'woolementor' ),
		        ],
		        'default' => 'current_product' ,
		        'label_block' => true,
		        'conditions'  => [
		            'relation' => 'or',
		            'terms' => [
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'related-products',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cross-sells',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'upsells',
		                ],
		            ] 
		        ],
		    ]
		);

		$element->add_control(
		    'main_product_id',
		    [
		        'label'     => __( 'Product ID', 'woolementor' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => get_post_type( get_the_ID() ) == 'product' ? get_the_ID() : '',
		        'description'  => __( 'Input the base product ID', 'woolementor' ),
		        'separator' => 'after',
		        'conditions'  => [
		            'terms' => [
		                [
		                    'name' => 'content_source',
		                    'operator' => '==',
		                    'value' => 'different_product',
		                ],
		                [
		                	'relation' => 'or',
		                	'terms' => [
		                		[
		                		    'name' => 'product_source',
		                		    'operator' => '==',
		                		    'value' => 'cross-sells',
		                		],
		                		[
		                		    'name' => 'product_source',
		                		    'operator' => '==',
		                		    'value' => 'upsells',
		                		],
		                		[
		                		    'name' => 'product_source',
		                		    'operator' => '==',
		                		    'value' => 'related-products',
		                		],
		                	]
		                ]
		            ] 
		        ],
		    ]
		);

		$element->add_control(
		    'product_limit',
		    [
		        'label'     => __( 'Products Limit', 'woolementor' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => 3,
		        'description'  => __( 'Number of products to show', 'woolementor' ),
		    ]
		);

		$element->add_control(
		    'ns_exclude_products',
		    [
		        'label'     => __( 'Exclude Products', 'woolementor' ),
		        'type'      => Controls_Manager::TEXT,
		        'separator' => 'before',
		        'description'  => __( "Comma separated ID's of products that should be excluded", 'woolementor' ),
		        'conditions'     => [
		            'relation' => 'or',
		            'terms' => [
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'related-products',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cart-cross-sells',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cart-upsells',
		                ],
		                [
		                    'name' => 'product_source',
		                    'operator' => '==',
		                    'value' => 'cart-related-products',
		                ],
		            ]
		        ],
		    ]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();

		/**
		 * Query controls
		 */

		$element->add_control(
		    'custom_query',
		    [
		        'label'         => __( 'Custom Query', 'woolementor' ),
		        'type'          => Controls_Manager::SWITCHER,
		        'label_on'      => __( 'Yes', 'woolementor' ),
		        'label_off'     => __( 'No', 'woolementor' ),
		        'return_value'  => 'yes',
		        'default'       => 'no',
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->add_control(
		    'number',
		    [
		        'label'     => __( 'Products per page', 'woolementor' ),
		        'type'      => Controls_Manager::NUMBER,
		        'default'   => 6,
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->add_control(
		    'order',
		    [
		        'label'         => __( 'Order', 'woolementor' ),
		        'type'          => Controls_Manager::SELECT,
		        'default'       => 'ASC',
		        'options'       => [
		            'ASC'       => __( 'ASC', 'woolementor' ),
		            'DESC'      => __( 'DESC', 'woolementor' ),
		        ],
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->add_control(
		    'orderby',
		    [
		        'label'         => __( 'Order By', 'woolementor' ),
		        'type'          => Controls_Manager::SELECT,
		        'default'       => 'ID',
		        'options'       => wcd_order_options(),
		        'condition' =>[
		            'product_source' => 'shop'
		        ]
		    ]
		);

		$element->start_controls_tabs(
		    'custom_query_section_separator',
		    [
		        'separator' => 'before',
		        'condition' => [
		            'custom_query' => 'yes',
		            'product_source' => 'shop'
		        ],
		    ]
		);

		$element->start_controls_tab(
		    'custom_query_section_normal',
		    [
		        'label'     => __( 'Custom Query', 'woolementor' ),
		    ]
		);

		/**
		 * qury by authhor
		 * 
		 * @author Jakaria Istauk <jakariamd35@gmail.com>
		 * 
		 * @since 3.0
		 */
		$element->add_control(
		    'author',
		    [
		        'label'     => __( 'Author ID', 'woolementor' ),
		        'type'      => Controls_Manager::NUMBER,
		    ]
		);

		$element->add_control(
		    'categories',
		    [
		        'label'     => __( 'Include Category', 'woolementor' ),
		        'type'      => Controls_Manager::SELECT2,
		        'options'   => wcd_get_terms(),
		        'multiple'  => true,
		        'label_block' => true,
		    ]
		);

		$element->add_control(
		    'exclude_categories',
		    [
		        'label'     => __( 'Exclude Categories', 'woolementor' ),
		        'type'      => Controls_Manager::SELECT2,
		        'options'   => wcd_get_terms(),
		        'multiple'  => true,
		        'label_block' => true,
		    ]
		);

		$element->add_control(
		    'include_products',
		    [
		        'label'         => __( 'Include Products', 'woolementor' ),
		        'type'          => Controls_Manager::TEXT,
		        'label_block'   => 'block',
		        'description'   => __( 'Separate product ID\'s with comma delimiter', 'woolementor' ),
		    ]
		);

		$element->add_control(
		    'exclude_products',
		    [
		        'label'         => __( 'Exclude Products', 'woolementor' ),
		        'type'          => Controls_Manager::TEXT,
		        'label_block'   => 'block',
		        'description'   => __( 'Separate product ID\'s with comma delimiter', 'woolementor' ),
		    ]
		);

		$element->add_control(
		    'sale_products_show_hide',
		    [
		        'label'         => __( "'On Sale' Products Only", 'woolementor' ),
		        'type'          => Controls_Manager::SWITCHER,
		        'label_on'      => __( 'Yes', 'woolementor' ),
		        'label_off'     => __( 'No', 'woolementor' ),
		        'return_value'  => 'yes',
		        'default'       => 'no',
		    ]
		);

		$element->add_control(
		    'out_of_stock',
		    [
		        'label'         => __( "Hide Stock out products", 'woolementor' ),
		        'type'          => Controls_Manager::SWITCHER,
		        'label_on'      => __( 'Yes', 'woolementor' ),
		        'label_off'     => __( 'No', 'woolementor' ),
		        'return_value'  => 'yes',
		        'default'       => '',
		    ]
		);

		$element->add_control(
		    'offset',
		    [
		        'label'         => __( 'Offset', 'woolementor' ),
		        'type'          => Controls_Manager::NUMBER,
		    ]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();
		$element->end_controls_section();
	}

}