<?php
/**
 * All Widgets facing functions
 */
namespace Codexpert\Woolementor;
use Codexpert\Plugin\Base;
use \Elementor\Plugin as Elementor_Plugin;
use \Elementor\Controls_Manager;
use \Elementor\Scheme_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Widgets
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Widgets extends Base {

	public $plugin;

	/**
	 * Constructor function
	 *
	 * @since 1.0
	 */
	public function __construct( $plugin ) {
		$this->plugin   = $plugin;
        $this->slug     = $this->plugin['TextDomain'];
        $this->name     = $this->plugin['Name'];
        $this->version  = $this->plugin['Version'];
		$this->widgets 	= woolementor_widgets();
		$this->active_widgets = wcd_active_widgets();
		$this->active_controls = $this->active_widgets;
		$this->assets 	= WOOLEMENTOR_ASSETS;
	}

	public function editor_enqueue_styles() {
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( "{$this->slug}-editor", "{$this->assets}/css/editor{$min}.css", '', $this->version, 'all' );
		// enqueue JavaScript
		wp_enqueue_script( 'xdLocalStorage', 'https://cdn.jsdelivr.net/npm/xdlocalstorage@2.0.5/dist/scripts/xdLocalStorage.min.js', [], '2.0.5', true );
		wp_enqueue_script( "{$this->slug}-xd-copy-paste", "{$this->assets}/js/xd-copy-paste.js", [], $this->version, true );
	}

	/**
	 * Registers categories for widgets
	 *
	 * @since 1.0
	 */
	public function register_category( $elements_manager ) {
		foreach ( wcd_widget_categories() as $id => $data ) {
			$elements_manager->add_category(
				$id,
				[
					'title'	=> $data['title'],
					'icon'	=> $data['icon'],
				]
			);
		}
	}

	/**
	 * Registers THE widgets
	 *
	 * @since 1.0
	 */
	public function register_widgets() {

		foreach( $this->active_widgets as $active_widget ) {
			$should_register = apply_filters( 'wcd_register_widget', true, $active_widget );
			if(
				wcd_is_pro_feature( $active_widget ) &&
				defined( 'WOOLEMENTOR_PRO_DIR' ) && $should_register &&
				wcd_is_pro_activated() &&
				file_exists( $file = WOOLEMENTOR_PRO_DIR . "/widgets/{$active_widget}/{$active_widget}.php" )
			) {
				require_once( $file );

				$class = str_replace( ' ', '_', ucwords( str_replace( array( '-', '.php' ), array( ' ', '' ), $active_widget ) ) );
				
				$widget = "Codexpert\\Woolementor_Pro\\{$class}";

				if( class_exists( $widget ) ) {
					Elementor_Plugin::instance()->widgets_manager->register_widget_type( new $widget() );
				}
			}
			elseif( $should_register && file_exists( $file = WOOLEMENTOR_DIR . "/widgets/{$active_widget}/{$active_widget}.php" ) ) {
				require_once( $file );

				$class = str_replace( ' ', '_', ucwords( str_replace( array( '-', '.php' ), array( ' ', '' ), $active_widget ) ) );
				
				$widget = "Codexpert\\Woolementor\\{$class}";

				if( class_exists( $widget ) ) {
					Elementor_Plugin::instance()->widgets_manager->register_widget_type( new $widget() );
				}
			}
		}
	}

	/**
	 * Registers additional controls for widgets
	 *
	 * @since 1.0
	 */
	public function register_controls() {
		
		include_once( WOOLEMENTOR_DIR . '/controls/gradient-text.php' );
        $gradient_text = __NAMESPACE__ . '\Controls\Group_Control_Gradient_Text';

        Elementor_Plugin::instance()->controls_manager->add_group_control( $gradient_text::get_type(), new $gradient_text() );
	}

	/**
	 * Enables Woolementor's place in the default content
	 *
	 * @since 1.0
	 *
	 * @TODO: use a better hook to add this
	 */
	public function the_content( $content ) {
		$content_start = apply_filters( 'woolementor-content_start', '' );
		$content_close = apply_filters( 'woolementor-content_close', '' );

		return $content_start . $content . $content_close;
	}

	public function set_filter_query( $wp_query ){

		if ( !isset( $wp_query->query ) || !isset( $wp_query->query['post_type'] ) || $wp_query->query['post_type'] != 'product' ) return;
			
		if ( !isset( $_GET['filter'] ) || empty( $_GET['filter'] ) ) return;

		if( !empty( $_GET['filter']['taxonomies'] ) ) {
			$taxonomies = [];
			foreach ( $_GET['filter']['taxonomies'] as $key => $term ) {
		        $taxonomies[] = array(
		          'taxonomy' => sanitize_text_field( $key ),
		          'field'    => 'slug',
		          'terms'    => $term,
		        );
			}

			$wp_query->set( 'tax_query', $taxonomies );
		}


		 if ( isset( $_GET['filter']['max_price'] ) && $_GET['filter']['max_price'] != '' && isset( $_GET['filter']['min_price'] ) && $_GET['filter']['min_price'] != '' ) {
			$max_price = sanitize_number( $_GET['filter']['max_price'] );
			$min_price = sanitize_number( $_GET['filter']['min_price'] );

	       	$meta_query[] = array(
		          'key' 	=> '_price',
	              'value' 	=> [ $min_price, $max_price ],
	              'compare' => 'BETWEEN',
	              'type' 	=> 'NUMERIC'
	        );
	        $default_metaq = $wp_query->meta_query ? $wp_query->meta_query : [];
			$wp_query->set( 'meta_query', array_merge( $default_metaq, $meta_query ) );
		}

		if ( isset( $_GET['filter']['orderby'] ) ) {					
			$orderby = sanitize_text_field( $_GET['filter']['orderby'] );
			$args['orderby']	= $orderby;
			$wp_query->set( 'orderby', $orderby );

		    if( in_array( $orderby, [ '_price', 'total_sales', '_wc_average_rating' ] ) ) {
		    	$args['meta_key']	= $orderby;
		    	$args['orderby'] 	= 'meta_value_num';
				$wp_query->set( 'meta_key', $orderby );
				$wp_query->set( 'orderby', 'meta_value_num' );
		    }
		}

		if( isset( $_GET['filter']['order'] ) ){
	        $order	= sanitize_text_field( $_GET['filter']['order'] );
			$wp_query->set( 'order', $order );
	    }
	    if( isset( $_GET['filter']['q'] ) ){
	        $q		= sanitize_text_field( $_GET['filter']['q'] );
			$wp_query->set( 's', $q );
	    }
	}
}