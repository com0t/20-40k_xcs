<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Product_Additional_Information extends Widget_Base {

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
			'section_additional_info_style',
			[
				'label' => __( 'General', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'additinal_info_default_styles',
		    [
		        'label'     => __( 'Display', 'woolementor-pro' ),
		        'type'      => Controls_Manager::HIDDEN,
		        'selectors' => [
		            '.wl {{WRAPPER}} .wl-product-additional-information.hide-wlpai-heading h2' => 'display: none;',
		            '.wl {{WRAPPER}} .wl-product-additional-information table.woocommerce-product-attributes' => 'margin:0',
		        ],
		        'default' => 'traditional',
		    ]
		);

		$this->add_control(
			'show_heading',
			[
				'label' => __( 'Heading', 'woolementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-additional-information h2' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-additional-information h2',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 500 ],
				],
				'condition' => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-additional-information .shop_attributes' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-additional-information .shop_attributes tr th,
							  .wl {{WRAPPER}} .wl-product-additional-information .shop_attributes tr td',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 500 ],
				],
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

		$settings = $this->get_settings_for_display();

		$hide = isset( $settings['show_heading'] ) && $settings['show_heading'] != 'yes' ? 'hide-wlpai-heading' : '';
		echo "<div class='wl-product-additional-information {$hide}'>";
		wc_get_template( 'single-product/tabs/additional-information.php' );
		echo "</div>";
	}
}

