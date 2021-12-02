<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Product_Tabs extends Widget_Base {

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
			'section_product_tabs_style',
			[
				'label' => __( 'Tabs', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_style' );

		$this->start_controls_tab( 'normal_tabs_style',
			[
				'label' => __( 'Normal', 'woolementor' ),
			]
		);

		$this->add_control(
			'tab_text_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_bg_color',
			[
				'label' => __( 'Background Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tabs_border_color',
			[
				'label' => __( 'Border Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'active_tabs_style',
			[
				'label' => __( 'Active', 'woolementor' ),
			]
		);

		$this->add_control(
			'active_tab_text_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'active_tab_bg_color',
			[
				'label' => __( 'Background Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel, .wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'background-color: {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'active_tabs_border_color',
			[
				'label' => __( 'Border Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-color: {{VALUE}} {{VALUE}} {{active_tab_bg_color.VALUE}} {{VALUE}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li:not(.active)' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'separator_tabs_style',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'tab_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_panel_style',
			[
				'label' => __( 'Panel', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-Tabs-panel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'heading_panel_heading_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Heading', 'woolementor' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_heading_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel h2',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'panel_border_width',
			[
				'label' => __( 'Border Width', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; margin-top: -{{TOP}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'panel_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'.wl {{WRAPPER}} .woocommerce-tabs ul.wc-tabs' => 'margin-left: {{TOP}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'panel_box_shadow',
				'selector' => '.wl {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
			]
		);

		$this->end_controls_section();
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

		wp_enqueue_style( 'woocommerce-general' );

		echo '<div class="wl-product-data-tabs product">';

		setup_postdata( $product->get_id() );

		// we are removing the description tab to avoid the infinity loop conflict
		add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
		    unset( $tabs['description'] );
		    return $tabs;
		} );

		wc_get_template( 'single-product/tabs/tabs.php' );

		echo '</div>';

        /**
         * Load Script
         */
        $this->render_script();
	}

	protected function render_script() {
		if ( wp_doing_ajax() ) {
			?>
			<script>
				jQuery( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
			</script>
			<?php
		}
    }
}

