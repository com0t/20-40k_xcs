<?php
use Codexpert\Woolementor\Helper;
$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'pro-tab' ];
$pro_link		= add_query_arg( $utm, 'https://codexpert.io/codesigner/#pricing' );
$agun_features	= [ 'email-header', 'email-footer', 'email-item-details', 'email-billing-addresses', 'email-shipping-addresses', 'email-customer-note', 'email-description', 'wishlist', 'billing-address', 'shipping-address', 'payment-methods', 'shop-accordion', 'shop-table', 'dynamic-tabs', 'menu-cart', 'filter-vertical', 'product-comparison' ];
$pro_features	= [
	'checkout-widgets'	=> [
		'title'			=> __( 'Checkout Page', 'woolementor' ),
		'subtitle'		=> __( 'Customizable Checkout 🔥', 'woolementor' ),
		'description'	=> __( 'Helps you customize your checkout page. Adding new billing or shipping fields, changing field attributes, styling your own.. You name it.', 'woolementor' ),
	],
	'email-designer'	=> [
		'title'			=> __( 'Email Designer', 'woolementor' ),
		'subtitle'		=> __( 'Customizable Transactional Emails 🔥', 'woolementor' ),
		'description'	=> __( 'Bored with WooCommerce\'s ugly and pale emails? You won\'t be again. It now allows you to send beautiful transational mails built with Elementor!', 'woolementor' ),
	],
	'more-shop-design'	=> [
		'title'			=> __( 'New Shop Designs', 'woolementor' ),
		'subtitle'		=> __( 'More Shop Widgets', 'woolementor' ),
		'description'	=> __( 'CoDesigner Pro includes 6 additional beautiful shop widgets. But, we\'re not stopping here and are continuously working. More widgets are coming soon.', 'woolementor' ),
	],
	'ready-made-templates'=> [
		'title'			=> __( 'Template Library', 'woolementor' ),
		'subtitle'		=> __( 'Ready-made Templates For You 🔥', 'woolementor' ),
		'description'	=> __( 'You will have access to hundreds of ready-made templates that uses Pro widgets to be imported using the native Elementor importer.', 'woolementor' ),
	],
	'template-builder'	=> [
		'title'			=> __( 'Template Builder', 'woolementor' ),
		'subtitle'		=> __( 'Header, Footer, Archive & Much More', 'woolementor' ),
		'description'	=> __( 'You can now create header, footer, archive, etc templates conditionally with a lot of customization options.', 'woolementor' ),
	],
	'pricing-table'	=> [
		'title'			=> __( 'Pricing Table', 'woolementor' ),
		'subtitle'		=> __( 'Amazing Pricing Tables', 'woolementor' ),
		'description'	=> __( 'Along with 2 Pricing Tables included in the free version, CoDesigner Pro brings 3 more Pricing Table widgets that are amazing and mindblowing.', 'woolementor' ),
	],
	'beautiful-wishlist'	=> [
		'title'			=> __( 'Wishlist', 'woolementor' ),
		'subtitle'		=> __( 'Smart Wishlist Management 🔥', 'woolementor' ),
		'description'	=> __( 'CoDesigner Pro includes a very smart and intuitive Wishlist feature. You customers can now add products to Wishlish and to the cart right from there.', 'woolementor' ),
	],
	'sales-notification'=> [
		'title'			=> __( 'Sales Notification', 'woolementor' ),
		'subtitle'		=> __( 'Display Recent Sales', 'woolementor' ),
		'description'	=> __( 'Sales Notification widget lets you display your recent sales. It\'s a proven token of trust! Notifications can be pulled from your orders or added manually.', 'woolementor' ),
	],
];
?>
<div id="wl-pro-wrap">
	<div id="wl-pro-features">
		<div class="wl-pro-features-heading">
			<h4 class="wl-small-title"><?php _e( 'Premium Features', 'woolementor' ); ?></h4>
			<h2 class="wl-large-title"><?php _e( 'You\'ll Definitely Fall In Love With', 'woolementor' ); ?></h2>
			<p class="wl-desc"><?php _e( 'Along with the <strong>Award Winning</strong> premium and priority support from our dedicated support team, you\'re going to get these awesome features if you upgrade to CoDesigner Pro.', 'woolementor' ) ?></p>
		</div>

		<div class="wl-pro-features">
			<?php
			$item_count = 0;
			foreach ( $pro_features as $id => $data ) {
				$is_even 	= $item_count % 2;
				$img 		= "<img src='" . plugins_url( "assets/img/{$id}.png", WOOLEMENTOR ) . "' />";
				$reverse 	= $alignment = '';
				$reverse 	= $is_even == 0 ? '' : 'reverse';
				$alignment 	= $is_even == 0 ? 'left' : 'right';
				echo "
				<div class='wl-pro-feature {$reverse}'>
					<div class='wl-pro-feature-content'>
						<a href='{$pro_link}' target='_blank'><h3 class='wl-widget-subtitle'>{$data['title']}</h3></a>
						<h2 class='wl-widget-title'>{$data['subtitle']}</h2>
						<p class='wl-feature-desc'>{$data['description']}</p>
					</div>
					<div class='wl-pro-feature-img'>{$img}</div>
				</div>
				";
				$item_count++;
			}
			?>
		</div>
	</div>
	<div id="wl-call-to-action">
		<div class="wl-cta-left">
			<?php _e( 'Customize your WooCommerce store with Elementor', 'woolementor' ) ?>
		</div>
		<div class="wl-cta-right">
			<a href="<?php echo $pro_link; ?>" target='_blank'><?php _e( 'GO PRO', 'woolementor' ) ?></a>
		</div>
	</div>
	<div id="wl-pro-widgets" class="">
		<div id="wl-widgets-heading" class="">
			<h1 class="wl-large-title"><?php _e( '40+ Pro Widgets', 'woolementor' ); ?></h1>
		</div>
		<div class='wl-pro-widget-list'>
			<?php 
			foreach ( woolementor_widgets() as $id => $widget ) {
				if( wcd_is_pro_feature( $id ) ) {
					$demo_txt = __( 'View Demo', 'woolementor' );
					$demo_url = add_query_arg( $utm, $widget['demo'] );
					$title = in_array( $id, $agun_features ) ? "{$widget['title']} 🔥" : $widget['title'];
					echo "
					<a href='{$demo_url}' title='{$demo_txt}' target='_blank'>
						<div class='wl-pro-widget'>
							<i class='{$widget['icon']}'></i> {$title}
						</div>
					</a>
					";
				}
			}
			?>
		</div>
	</div>
	<div id="wl-pro-upgrade">
		<div class="wcd-edf-btns">
			<a href="<?php echo wcd_help_link(); ?>" target="_blank" class="wcd-edf-btn"><?php _e( 'I have a question' ) ?></a>
			<a href="<?php echo wcd_home_link(); ?>" target="_blank" class="wcd-edf-btn active"><?php _e( 'I\'m ready to upgrade' ) ?></a>
		</div>
	</div>
</div>