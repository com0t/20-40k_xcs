<?php
/**
 * Template library templates
 */

defined( 'ABSPATH' ) || exit;
?>

<script type="text/template" id="tmpl-wl-templates-modal__preview">
	<div class="tmpl-wl-templates-modal-preview-iframe">
    	<iframe></iframe>
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-library-header-back">
	<div id="elementor-template-library-header-preview-back" class="tmpl-wl-template-library-header-preview-back">
		<i class="eicon-" aria-hidden="true"></i>
		<span><?php echo esc_html__( 'Back to Library', 'elementor' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-library-loading">
	<div class="elementor-loader-wrapper tmpl-wl-loader-wrapper">
		<div class="elementor-loader">
			<!-- <div class="elementor-loader-boxes">
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
			</div> -->
			<img src="<?php echo WOOLEMENTOR_ASSETS . '/img/icon-128.png'; ?>"
		</div>
		<div class="elementor-loading-title"><?php echo esc_html__( 'Loading', 'elementor' ); ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-library-header-menu-responsive">
	<div class="elementor-component-tab wl__responsive-menu-item elementor-active" data-tab="desktop">
		<i class="eicon-device-desktop" aria-hidden="true" title="<?php esc_attr_e( 'Desktop view', 'woolementor' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Desktop view', 'woolementor' ); ?></span>
	</div>
	<div class="elementor-component-tab wl__responsive-menu-item" data-tab="tab">
		<i class="eicon-device-tablet" aria-hidden="true" title="<?php esc_attr_e( 'Tab view', 'woolementor' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Tab view', 'woolementor' ); ?></span>
	</div>
	<div class="elementor-component-tab wl__responsive-menu-item" data-tab="mobile">
		<i class="eicon-device-mobile" aria-hidden="true" title="<?php esc_attr_e( 'Mobile view', 'woolementor' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Mobile view', 'woolementor' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-library-header-preview">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		<a class="elementor-template-library-template-action elementor-template-library-template-insert elementor-button tmpl-wl-template-insert">
			<i class="eicon-file-download" aria-hidden="true"></i>
			<span class="elementor-button-title"><?php echo esc_html__( 'Insert', 'elementor' ); ?></span>
		</a>
	</div>
</script>

<script type="text/template" id="tmpl-wl-templates-modal__header">
	<div class="elementor-templates-modal__header__logo-area"></div>
	<div class="elementor-templates-modal__header__menu-area"></div>
	<div class="elementor-templates-modal__header__items-area">
		<div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--normal elementor-templates-modal__header__item close-modal">
				<i class="eicon-close" aria-hidden="true" title="<?php echo esc_html__( 'Close', 'elementor' ); ?>"></i>
				<span class="elementor-screen-only"><?php echo esc_html__( 'Close', 'elementor' ); ?></span>
			</div>
		<div id="elementor-template-library-header-tools"></div>
	</div>
</script>

<script type="text/template" id="tmpl-wl-templates-modal__header__logo">
	<div class="elementor-templates-modal__header__logo">
		<span class="elementor-templates-modal__header__logo__icon-wrapper e-logo-wrapper wl-logo-wrapper">
			<!-- <i class="eicon-elementor"></i> -->
			<img src="<?php echo WOOLEMENTOR_ASSETS . '/img/icon.png'; ?>"
		</span>
		<span class="elementor-templates-modal__header__logo__title">Library</span>
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-modal__header__menu">
	<div id="elementor-template-library-header-menu">
		<div class="elementor-component-tab elementor-template-library-menu-item elementor-active" data-tab="blocks">Blocks</div>
		<div class="elementor-component-tab elementor-template-library-menu-item" data-tab="pages">Pages</div>
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-modal__header__actions">
	<div id="elementor-template-library-header-actions">
		<!-- <div id="elementor-template-library-header-import" class="elementor-templates-modal__header__item">
			<i class="eicon-upload-circle-o" aria-hidden="true" title="<?php esc_attr_e( 'Import Template', 'elementor' ); ?>"></i>
			<span class="elementor-screen-only"><?php echo esc_html__( 'Import Template', 'elementor' ); ?></span>
		</div> -->
		<div id="elementor-template-library-header-sync" class="elementor-templates-modal__header__item">
			<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e( 'Sync Library', 'elementor' ); ?>"></i>
			<span class="elementor-screen-only"><?php echo esc_html__( 'Sync Library', 'elementor' ); ?></span>
		</div>
		<!-- <div id="elementor-template-library-header-save" class="elementor-templates-modal__header__item">
			<i class="eicon-save-o" aria-hidden="true" title="<?php esc_attr_e( 'Save', 'elementor' ); ?>"></i>
			<span class="elementor-screen-only"><?php echo esc_html__( 'Save', 'elementor' ); ?></span>
		</div> -->
	</div>
</script>

<script type="text/template" id="tmpl-wl-template-library-filters">
	<div id="wl-template-library-filters">

		<div id="wl-template-library-categories">
			<select>
				<option value=""><?php _e( 'Choose a category', 'woolementor' ); ?></option>
			<% _.each( cats, function(v, k) { %>
				<option value="<%= k %>"><%= v %></option>
			<% } ); %>
			</select>
		</div>

		<div id="wl-template-library-search">
			<input type="text" />
			<i class="eicon-search"></i>
		</div>

	</div>
</script>

<script type="text/template" id="tmpl-wl-template-library-pages">
	<% _.each( pages, function(i) { %>
		<div class="import-this elementor-template-library-template-remote <% _.each( i.subtype, function(v, k) { %> cat-<%= k %> <% } ); %>" title="<%= i.title %>">

			<div class="elementor-template-library-template-body">
				<div class="elementor-template-library-template-screenshot" style="background-image: url(<%= i.thumbnail %>);"></div>
				
				<div class="elementor-template-library-template-preview" data-url="<%= i.url %>" data-tab="<%= i.template_id %>">
					<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
				</div>
			</div>

			<div class="elementor-template-library-template-footer">
				
				<a class="elementor-template-library-template-action elementor-template-library-template-insert elementor-button tmpl-wl-template-insert" data-tab="<%= i.template_id %>">
					<i class="eicon-file-download" aria-hidden="true"></i>
					<span class="elementor-button-title">Insert</span>
				</a>

				<div class="elementor-template-library-template-name"><%= i.title %></div>
				<!-- <div class="elementor-template-library-favorite">
					<input id="elementor-template-library-template-1190-favorite-input" class="elementor-template-library-template-favorite-input" type="checkbox">
					<label for="elementor-template-library-template-1190-favorite-input" class="elementor-template-library-template-favorite-label">
						<i class="eicon-heart-o" aria-hidden="true"></i>
						<span class="elementor-screen-only">Favorite</span>
					</label>
				</div> -->
			</div>

			<!-- <h3><a href="<%= WOOLEMENTOR_LIB.url %>/get/<%= i.template_id %>"><%= i.title %></a></h3> -->
			<!-- <img src="<%= i.thumbnail %>" style="max-width:100px" /> -->
		</div>
	<% } ); %>
</script>

<script type="text/template" id="tmpl-wl-template-library-blocks">
	<% _.each( blocks, function(i) { %>
		<div class="import-this elementor-template-library-template-remote <% _.each( i.subtype, function(v, k) { %> cat-<%= k %> <% } ); %>" title="<%= i.title %>">

			<div class="elementor-template-library-template-body tmpl-wl-template-body">
				<div class="elementor-template-library-template-screenshot tmpl-wl-template-screenshot" style="background-image: url(<%= i.thumbnail %>);"></div>

				<div class="elementor-template-library-template-preview" data-url="<%= i.url %>" data-tab="<%= i.template_id %>">
					<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
				</div>
			</div>

			<div class="elementor-template-library-template-footer">
				
				<a class="elementor-template-library-template-action elementor-template-library-template-insert elementor-button tmpl-wl-template-insert" data-tab="<%= i.template_id %>">
					<i class="eicon-file-download" aria-hidden="true"></i>
					<span class="elementor-button-title">Insert</span>
				</a>

				<div class="elementor-template-library-template-name"><%= i.title %></div>
				<!-- <div class="elementor-template-library-favorite">
					<input id="elementor-template-library-template-1190-favorite-input" class="elementor-template-library-template-favorite-input" type="checkbox">
					<label for="elementor-template-library-template-1190-favorite-input" class="elementor-template-library-template-favorite-label">
						<i class="eicon-heart-o" aria-hidden="true"></i>
						<span class="elementor-screen-only">Favorite</span>
					</label>
				</div> -->
			</div>

			<!-- <h3><a href="<%= WOOLEMENTOR_LIB.url %>/get/<%= i.template_id %>"><%= i.title %></a></h3> -->
			<!-- <img src="<%= i.thumbnail %>" style="max-width:100px" /> -->
		</div>
	<% } ); %>
</script>

<!-- <script type="text/template" id="tmpl-wl-template-library-pro-button">
	<a class="elementor-template-library-template-action elementor-button tmpl-wl-template-pro-button" href="https://codexpert.io/woolementor/#free-vs-pro" target="_blank">
		<i class="eicon-external-link-square" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php esc_html_e( 'Get Pro', 'woolementor' ); ?></span>
	</a>
</script> -->