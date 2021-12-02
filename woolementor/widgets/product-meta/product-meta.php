<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Typography;

class Product_Meta extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id 		= wcd_get_widget_id( __CLASS__ );
	    $this->widget 	= wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
	}

	public function get_name() {
		return $this->id;
	}

	public function get_title() {
		return $this->widget['title'];
	}

	public function get_icon() {
		return $this->widget['icon'];
	}

	public function get_categories() {
		return $this->widget['categories'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_product_meta_style',
			[
				'label' => __( 'Style', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => [
					'table' => __( 'Table', 'woolementor' ),
					'stacked' => __( 'Stacked', 'woolementor' ),
					'inline' => __( 'Inline', 'woolementor' ),
				],
				'prefix_class' => 'elementor-woo-meta--view-',
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => __( 'Space Between', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta .detail-container' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}}.elementor-woo-meta--view-inline .detail-container:after' => 'right: calc( (-{{SIZE}}{{UNIT}}/2) + (-{{divider_weight.SIZE}}px/2) )',
					'body:not.rtl {{WRAPPER}}.elementor-woo-meta--view-inline .detail-container:after' => 'left: calc( (-{{SIZE}}{{UNIT}}/2) - ({{divider_weight.SIZE}}px/2) )',
				],
			]
		);

		$this->add_control(
			'divider',
			[
				'label' => __( 'Divider', 'woolementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'woolementor' ),
				'label_on' => __( 'On', 'woolementor' ),
				'selectors' => [
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'content: ""',
				],
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => __( 'Style', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => __( 'Solid', 'woolementor' ),
					'double' => __( 'Double', 'woolementor' ),
					'dotted' => __( 'Dotted', 'woolementor' ),
					'dashed' => __( 'Dashed', 'woolementor' ),
				],
				'default' => 'solid',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:last-child):after' => 'border-top-style: {{VALUE}}',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta .detail-container:not(:last-child):after' => 'border-left-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label' => __( 'Weight', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'.wl {{WRAPPER}}:not(.elementor-woo-meta--view-inline) .wcd_product_meta .detail-container:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}; margin-bottom: calc(-{{SIZE}}{{UNIT}}/2)',
					'.wl {{WRAPPER}}.elementor-woo-meta--view-inline .wcd_product_meta .detail-container:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'divider_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'condition' => [
					'divider' => 'yes',
					'view!' => 'inline',
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_height',
			[
				'label' => __( 'Height', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'divider' => 'yes',
					'view' => 'inline',
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => __( 'Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd_product_meta .detail-container:not(:last-child):after' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_text_style',
			[
				'label' => __( 'Text', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '.wl {{WRAPPER}}',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}}' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_link_style',
			[
				'label' => __( 'Link', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'selector' => '.wl {{WRAPPER}} a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => __( 'Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_meta_captions',
			[
				'label' => __( 'Captions', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_category_caption',
			[
				'label' => __( 'Category', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'category_caption_single',
			[
				'label' => __( 'Singular', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Category', 'woolementor' ),
			]
		);

		$this->add_control(
			'category_caption_plural',
			[
				'label' => __( 'Plural', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Categories', 'woolementor' ),
			]
		);

		$this->add_control(
			'heading_tag_caption',
			[
				'label' => __( 'Tag', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tag_caption_single',
			[
				'label' => __( 'Singular', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Tag', 'woolementor' ),
			]
		);

		$this->add_control(
			'tag_caption_plural',
			[
				'label' => __( 'Plural', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Tags', 'woolementor' ),
			]
		);

		$this->add_control(
			'heading_sku_caption',
			[
				'label' => __( 'SKU', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sku_caption',
			[
				'label' => __( 'SKU', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'SKU', 'woolementor' ),
			]
		);

		$this->add_control(
			'sku_missing_caption',
			[
				'label' => __( 'Missing', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'N/A', 'woolementor' ),
			]
		);

		$this->end_controls_section();
	}

	private function get_plural_or_single( $single, $plural, $count ) {
		return 1 === $count ? $single : $plural;
	}

	protected function render() {
		global $product;

		$product = wc_get_product();

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id = wcd_get_product_id();
			$product 	= wc_get_product( $product_id );
		}

		if ( empty( $product ) ) {
			return;
		}

		$sku = $product->get_sku();

		$settings = $this->get_settings_for_display();
		$sku_caption = ! empty( $settings['sku_caption'] ) ? sanitize_text_field( $settings['sku_caption'] ) : __( 'SKU', 'woolementor' );
		$sku_missing = ! empty( $settings['sku_missing_caption'] ) ? sanitize_text_field( $settings['sku_missing_caption'] ) : __( 'N/A', 'woolementor' );
		$category_caption_single = ! empty( $settings['category_caption_single'] ) ? sanitize_text_field( $settings['category_caption_single'] ) : __( 'Category', 'woolementor' );
		$category_caption_plural = ! empty( $settings['category_caption_plural'] ) ? sanitize_text_field( $settings['category_caption_plural'] ): __( 'Categories', 'woolementor' );
		$tag_caption_single = ! empty( $settings['tag_caption_single'] ) ? sanitize_text_field( $settings['tag_caption_single'] ) : __( 'Tag', 'woolementor' );
		$tag_caption_plural = ! empty( $settings['tag_caption_plural'] ) ? sanitize_text_field( $settings['tag_caption_plural'] ) : __( 'Tags', 'woolementor' );
		?>
		<div class="wcd_product_meta">

			<?php do_action( 'woocommerce_product_meta_start' ); ?>

			<?php if ( wc_product_sku_enabled() && ( $sku || $product->is_type( 'variable' ) ) ) : ?>
				<span class="sku_wrapper detail-container"><span class="detail-label"><?php echo esc_html( $sku_caption ); ?></span> <span class="sku"><?php echo $sku ? $sku : esc_html( $sku_missing ); ?></span></span>
			<?php endif; ?>

			<?php if ( count( $product->get_category_ids() ) ) : ?>
				<span class="posted_in detail-container"><span class="detail-label"><?php echo esc_html( $this->get_plural_or_single( $category_caption_single, $category_caption_plural, count( $product->get_category_ids() ) ) ); ?></span> <span class="detail-content"><?php echo get_the_term_list( $product->get_id(), 'product_cat', '', ', ' ); ?></span></span>
			<?php endif; ?>

			<?php if ( count( $product->get_tag_ids() ) ) : ?>
				<span class="tagged_as detail-container"><span class="detail-label"><?php echo esc_html( $this->get_plural_or_single( $tag_caption_single, $tag_caption_plural, count( $product->get_tag_ids() ) ) ); ?></span> <span class="detail-content"><?php echo get_the_term_list( $product->get_id(), 'product_tag', '', ', ' ); ?></span></span>
			<?php endif; ?>

			<?php do_action( 'woocommerce_product_meta_end' ); ?>

		</div>
		<?php
	}
}

