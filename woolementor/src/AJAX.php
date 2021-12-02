<?php
/**
 * All AJAX related functions
 */
namespace Codexpert\Woolementor;
use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage AJAX
 * @author Codexpert <hi@codexpert.io>
 */
class AJAX extends Base {

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

	/**
	 * Adds a product to the wishlist
	 * Removes a product from the wishlist
	 *
	 * @TODO: change method name 
	 *
	 * @since 1.0
	 */
	public function add_to_wish() {
		$response = [
			 'status'	=> 0,
			 'message'	=>__( 'Unauthorized!', 'woolementor' )
		];

		if( !wp_verify_nonce( $_POST['_wpnonce'], $this->slug ) ) {
		    wp_send_json( $response );
		}

		if( !isset( $_POST['product_id'] ) ) {
			$response['message'] = __( 'No product selected!', 'woolementor' );
		    wp_send_json( $response );
		}

		extract( $_POST );

		$user_id = get_current_user_id();
		$wishlist = wcd_get_wishlist( $user_id );

		// if the product is already in the wishlist, remove
		if ( ( $key = array_search( $product_id, $wishlist ) ) !== false ) {
			$response['action'] = 'removed';
		    unset( $wishlist[ $key ] );
		}

		// add to wishlist
		else {
			$response['action'] = 'added';
			$wishlist[] = $product_id;
		}

		$wishlist = array_unique( $wishlist );

		// update wishlist
		wcd_set_wishlist( $wishlist, $user_id );

		// send response
		$response['status'] = 1;
		$response['message'] = sprintf( __( 'Wishlist item %s!', 'woolementor' ), $response['action'] );
		wp_send_json( $response );
	}

	public function add_variations_to_cart() {
		$response['status'] 	= 0;
		$response['message'] 	= __( 'Something is wrong!', 'woolementor' );
		
		if( !wp_verify_nonce( $_POST['_wpnonce'], 'woolementor' ) ) {
			$response['message'] = __( 'Unauthorized!', 'woolementor' );
		    wp_send_json( $response );
		}

		$variations = $_POST['variation'];
		$product_id = $_POST['product_id'];
		$attributes = $_POST['attributes'];
		$variation_checked =  $_POST['variation_checked'];

		$checked_items = array_intersect_key( $variations, $variation_checked );

		if ( count( $checked_items ) < 1 ) {
			$response['message'] = __( 'No variations selected!', 'woolementor' );
			wp_send_json( $response );
		}

		foreach ( $checked_items as $key => $item ) {
			WC()->cart->add_to_cart( $product_id, $item, $key, $attributes[ $key ] );
		}

		$response['status'] 	= 1;
		$response['message'] 	= __( 'Product Added', 'woolementor' );
		wp_send_json( $response );
	}

	public function multiple_product_add_to_cart() {
		$response['status'] 	= 0;
		$response['message'] 	= __( 'Something is wrong!', 'woolementor' );
		
		if( !wp_verify_nonce( $_POST['_wpnonce'], 'woolementor' ) ) {
			$response['message'] = __( 'Unauthorized!', 'woolementor' );
		    wp_send_json( $response );
		}

		$checked_items = $_POST['cart_item_ids'];
		$multiple_qty = $_POST['multiple_qty'];


		if ( count( $checked_items ) < 1 ) {
			$response['message'] = __( 'No products selected!', 'woolementor' );
			wp_send_json( $response );
		}

		foreach ( $checked_items as $key => $item ) {
			$qty = is_null( $multiple_qty ) && !isset( $multiple_qty[ $item ] ) ? 1 : $multiple_qty[ $item ];
			WC()->cart->add_to_cart( $item, $qty );
		}

		$response['status'] 	= 1;
		$response['message'] 	= __( 'Product Added', 'woolementor' );
		wp_send_json( $response );
	}

	public function template_sync(){
		$response['status'] 	= 0;
		$response['message'] 	= __( 'Something is wrong!', 'woolementor' );
		
		if( !wp_verify_nonce( $_POST['_wpnonce'], 'woolementor' ) ) {
			$response['message'] = __( 'Unauthorized!', 'woolementor' );
		    wp_send_json( $response );
		}

		Library_Source::get_library_data( true );

		$response['status'] 	= 1;
		$response['message'] 	= __( 'Synchronization Complete', 'woolementor' );
		wp_send_json( $response );
	}
}