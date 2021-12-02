<?php 
global $woolementor;
$textdomain = $woolementor['TextDomain'];

wp_enqueue_style( $textdomain . '-email-designer' );
?>
<div id="wcd-email-designer-wrapper">
	<div class="wcd-email-designer-header wcd-email-designer-heading">
		<h4><?php _e( 'Extraordinary Features of', 'woolementor' ); ?></h4>
		<h2><?php _e( 'The Email Designer', 'woolementor' ); ?></h4>
		<p><?php _e( 'Finally! The much-awaited WooCommerce Email customizer is here! You can now customize WooCommerce transactional emails with Elementor and WC Designer.', 'woolementor' ) ?></p>
	</div>
	<div class="wcd-email-designer-content-panel">
		<div class="wcd-email-designer-box wcd-email-designer-editor-wrap">
			<div class="wcd-email-designer-box-image">
				<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/editor-pannel.png", WOOLEMENTOR ) ); ?>" alt="<?php _e( 'Email Setting Tool', 'woolementor' ); ?>">
			</div>
			<div class="wcd-email-designer-box-content wcd-email-designer-heading">
				<div class="wcd-email-designer-box-content-wrap">
					<span class="dashicons dashicons-admin-customizer"></span>
					<h4><?php _e( 'Email Editor Panel', 'woolementor' ); ?></h4>
					<h2><?php _e( 'Create email templates '. '<br>' .' with Elementor', 'woolementor' ); ?></h4>
					<p><?php _e( 'Create your own custom email template using Elementor and WC Designer. Here you have unlimited customization options. Add business logo and change layout, typography, background color etc to reinforce your brand.', 'woolementor' ) ?></p>
				</div>
			</div>
		</div>
		<div class="wcd-email-designer-box wcd-email-designer-setting-wrap">
			<div class="wcd-email-designer-box-content wcd-email-designer-heading">
				<div class="wcd-email-designer-box-content-wrap wcd-padding-left-32">
					<span class="dashicons dashicons-admin-tools"></span>
					<h4><?php _e( 'Email Settings Panel', 'woolementor' ); ?></h4>
					<h2><?php _e( 'Set up email templates for different events', 'woolementor' ); ?></h4>
					<p><?php _e( 'Choose from the settings which email template to use for what event. You can set different email templates for different events, e.g., one for new order, one for processing order and another for completed order etc. You can set email templates for both admin emails and customer emails.', 'woolementor' ) ?></p>
				</div>
			</div>
			<div class="wcd-email-designer-box-image">
				<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/email-setting.png", WOOLEMENTOR ) ); ?>" alt="<?php _e( 'Email Setting Tool', 'woolementor' ); ?>">
			</div>
		</div>
		<div class="wcd-email-designer-box wcd-email-designer-inbox-wrap">
			<div class="wcd-email-designer-box-image">
				<img src="<?php echo esc_url( plugins_url( "assets/img/email-designer/send-email.png", WOOLEMENTOR ) ); ?>" alt="<?php _e( 'Email Setting Tool', 'woolementor' ); ?>">
			</div>
			<div class="wcd-email-designer-box-content wcd-email-designer-heading">
				<div class="wcd-email-designer-box-content-wrap wcd-padding-left-32">
					<span class="dashicons dashicons-email"></span>
					<h4><?php _e( 'Send Beautiful Emails', 'woolementor' ); ?></h4>
					<h2><?php _e( 'Bespoke branded WooCommerce emails', 'woolementor' ); ?></h4>
					<p><?php _e( 'After doing the necessary set up, you are ready to send your custom branded emails. Your customer gets exactly the same email you design.', 'woolementor' ) ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="wcd-email-designer-footer">
		<p class="wcd-edf-desc">A beautifully designed email can bring peace of mind to your customers. Don't you want to improve your customers' experience? Take your desicion right away.. 🥳</p>
		<div class="wcd-edf-btns">
			<a href="<?php echo wcd_help_link(); ?>" target="_blank" class="wcd-edf-btn"><?php _e( 'I have a question' ) ?></a>
			<a href="<?php echo wcd_home_link(); ?>" target="_blank" class="wcd-edf-btn active"><?php _e( 'I\'m ready to upgrade' ) ?></a>
		</div>
	</div>
</div>