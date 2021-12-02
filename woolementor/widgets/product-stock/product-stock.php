<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Product_Stock extends Widget_Base {

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

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'section_product_stock_content',
			[
				'label' 		=> __( 'Content', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_responsive_control(
            'align',
            [
                'label' 		=> __( 'Alignment', 'woolementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' 		=> [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-center',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor' ),
                        'icon' 		=> 'eicon-text-align-right',
                    ],
                ],
                'toggle' 		=> true,
                'default' 		=> 'left',
				'separator' 	=> 'before',
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-product-stock .stock' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_product_stock_style',
			[
				'label' => __( 'Style', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_stock_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-stock .stock' => 'margin:0;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-stock .stock' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wl-product-stock .stock',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
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
			$product = wc_get_product( $product_id );
			$stock_status 	= $product->get_stock_status();
			$stock_qty 		= $product->get_stock_quantity();
			if ( $stock_status == 'instock' && is_null( $stock_qty ) ) {
				echo "<div class='wl-product-stock'><p class='stock' >100 in stock</p></div>";
			}
		}

		if ( empty( $product ) ) {
			return;
		}

		echo "<div class='wl-product-stock'>";
		echo wc_get_stock_html( $product );
		echo "</div>";
	}
}

