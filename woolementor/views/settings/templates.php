<?php
use Codexpert\Woolementor\Helper;
use Codexpert\Woolementor\Library_Source;
wp_enqueue_style( 'woolementor-library' );

$library 	= Library_Source::get_library_data();
$pages 		= isset( $library['pages'] ) ? $library['pages'] : [];
$blocks 	= isset( $library['blocks'] ) ? $library['blocks'] : [];
$categories = isset( $library['categories'] ) ? $library['categories'] : [];

?>

<?php

$args = [
	'tmpl_blocks' 	=> __( 'Blocks', 'woolementor' ),
	'tmpl_pages' 	=> __( 'Pages', 'woolementor' ),
];
$tab_links = apply_filters( 'wcd_help_tab_link', $args );

echo "<div class='wcd_tab_btns wcd-tmpl-btns'>";
echo "<ul class='wcd_template_tabs wcd-tmpl-content'>";

$count 	= 0;
foreach ( $tab_links as $id => $tab_link ) {
	$active = $count == 0 ? 'active' : '';
	echo "<li class='wcd_template_tab {$active}' id='{$id}'>{$tab_link}</li>";
	$count++;
}
$cat_html = '<option value="">' . __( 'Choose a Category' ) . '</option>';
foreach ( $categories as $key => $category ) {
	$cat_html .= "<option value='{$key}'>{$category}</option>";
}

echo "</ul>
<div id='wcd-template-search-box'>
	<select id='wl-template-categories'>{$cat_html}</select>
   	<input id='wl-template-search' type='text' class='input-search' placeholder='" . __( 'Type to Search...', 'woolementor' ) . "'>
   	<button class='btn-search'><i class='eicon-search'></i></button>
 </div>
<div id='wcd-template-sync' class='elementor-templates-modal__header__item clickable'>
	<i class='eicon-sync' aria-hidden='true' title='" . __( 'Sync Library', 'woolementor' ) . "'></i>
	<span class='elementor-screen-only'>" . __( 'Sync Library', 'woolementor' ) . "</span>
</div>
</div>";
?>
<div class="elementor-templates-modal__header tmpl-admin-template-header" style="display: none;">
	<div class="tmpl-admin-template-logo-area elementor-templates-modal__header__logo-area">
		<div id="elementor-template-library-header-preview-back" class="tmpl-wl-template-library-header-preview-back">
			<i class="eicon-" aria-hidden="true"></i>
			<span><?php _e( 'Back to Library', 'woolementor-pro' ); ?></span>
		</div>
	</div>
	<div class="tmpl-admin-template-menu-area elementor-templates-modal__header__menu-area">
		<div class="elementor-component-tab wl__responsive-menu-item elementor-active" data-tab="desktop">
			<i class="eicon-device-desktop" aria-hidden="true" title="Desktop view"></i>
			<span class="elementor-screen-only"><?php _e( 'Desktop view', 'woolementor-pro' ); ?></span>
		</div>
		<div class="elementor-component-tab wl__responsive-menu-item" data-tab="tab">
			<i class="eicon-device-tablet" aria-hidden="true" title="Tab view"></i>
			<span class="elementor-screen-only"><?php _e( 'Tab view', 'woolementor-pro' ); ?></span>
		</div>
		<div class="elementor-component-tab wl__responsive-menu-item" data-tab="mobile">
			<i class="eicon-device-mobile" aria-hidden="true" title="Mobile view"></i>
			<span class="elementor-screen-only"><?php _e( 'Mobile view', 'woolementor-pro' ); ?></span>
		</div>
	</div>
</div>

<div id="tmpl_pages_content" class="wcd_template_content">
	<div id="woolementor-templates" class="wcd-tmpl-wrapper">
		<?php 
		foreach ( $pages as $page ):
			$categories = !is_null( $page['subtype'] ) ? implode(',', array_keys( $page['subtype'] ) ) : '';
			$keywords 	= !is_null( $page['keywords'] ) ? implode(',', array_keys( $page['keywords'] ) ) : '';
			?>
			<div class="import-this elementor-template-library-template-remote" title="<?php echo esc_html( $page['title'] ); ?>">		
				<span style="display:none;"><?php echo "{$categories} {$keywords}" ?></span>
				<div class="elementor-template-library-template-body">
					<div class="elementor-template-library-template-screenshot" style="background-image: url(<?php echo esc_html( $page['thumbnail'] ); ?>);"></div>
					
					<div class="elementor-template-library-template-preview" data-url="<?php echo esc_html( $page['url'] ); ?>" data-tab="<?php echo esc_html( $page['template_id'] ); ?>">
						<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
					</div>
				</div>

				<div class="elementor-template-library-template-footer">
					<a target="_blank" href="<?php echo esc_html( $page['url'] ); ?>">
						<div class="elementor-template-library-template-name"><?php echo esc_html( $page['title'] ); ?></div>
					</a>
				</div>
			</div>
			<?php
		endforeach; 
		?>
	</div>
	<div class="tmpl-wl-templates-modal-preview-iframe">
    	<iframe></iframe> 
	</div>
</div>

<div id="tmpl_blocks_content" class="wcd_template_content active">
	<div id="woolementor-templates" class="wcd-tmpl-wrapper">
		<?php 
		foreach ( $blocks as $block ):
			$categories = !is_null( $block['subtype'] ) ? implode(',', array_keys( $block['subtype'] ) ) : '';
			$keywords 	= !is_null( $block['keywords'] ) ? implode(',', array_keys( $block['keywords'] ) ) : '';
			?>
			<div class="import-this elementor-template-library-template-remote" title="<?php echo esc_html( $block['title'] ); ?>">
				<span style="display:none;"><?php echo "{$categories} {$keywords}" ?></span>
				<div class="elementor-template-library-template-body">
					<div class="elementor-template-library-template-screenshot" style="background-image: url(<?php echo esc_url( $block['thumbnail'] ); ?>);"></div>
					
					<div class="elementor-template-library-template-preview" data-url="<?php echo esc_url( $block['url'] ); ?>" data-tab="<?php echo esc_html( $block['template_id'] ); ?>">
						<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
					</div>
				</div>

				<div class="elementor-template-library-template-footer">
					<a target="_blank" href="<?php echo esc_html( $block['url'] ); ?>">
						<div class="elementor-template-library-template-name"><?php echo esc_html( $block['title'] ); ?></div>
					</a>
				</div>
			</div>
			<?php
		endforeach; 
		?>
	</div>
	<div class="tmpl-wl-templates-modal-preview-iframe">
    	<iframe></iframe> 
	</div>
</div>

<div id="elementor-template-library-loading" class="tmpl-admin-template-loader" style="display: none;">
	<div class="elementor-loader-wrapper tmpl-wl-loader-wrapper">
		<div class="elementor-loader">
			<img src="<?php echo WOOLEMENTOR_ASSETS . '/img/icon-128.png'; ?>">
		<div class="elementor-loading-title">Loading</div>
	</div>
</div></div>