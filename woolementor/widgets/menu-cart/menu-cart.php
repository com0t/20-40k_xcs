<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Menu_Cart extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
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
			'section_menu_icon_content',
			[
				'label' => __( 'Menu Icon', 'woolementor-pro' ),
			]
		);

        $this->add_control(
            'icon',
            [
                'label'         => __( 'Icon', 'woolementor-pro' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'solid',
                ],
            ]
        ); 

		$this->add_control(
			'indicator_switch',
			[
				'label' 		=> __( 'Indicator', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'subtotal_switch',
			[
				'label' 		=> __( 'Subtotal', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'no',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_button_action',
			[
				'label' => __( 'Action', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'section_menu_button_action_type',
			[
				'label' 	=> __( 'Action Type', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'click'  => __( 'Click', 'woolementor-pro' ),
					'hover'  => __( 'Hover', 'woolementor-pro' ),
				],
				'default' 	=> 'click',
				'prefix_class' => 'wlmc-menu-cart-button--action-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			[
				'label' => __( 'Menu Icon', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'toggle_button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-total',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->start_controls_tabs( 'toggle_button_colors' );

		$this->start_controls_tab( 'toggle_button_normal_colors', [ 'label' => __( 'Normal', 'elementor-pro' ) ] );

		$this->add_control(
			'toggle_button_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-total' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_icon_color',
			[
				'label' => __( 'Icon Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-button-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_color',
			[
				'label' => __( 'Indicator Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_background',
			[
				'label' => __( 'Indicator Background', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'toggle_button_border_color',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wlmc-toggle-button-panel',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'toggle_button_hover_colors', [ 'label' => __( 'Hover', 'elementor-pro' ) ] );

		$this->add_control(
			'toggle_button_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-total:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_icon_color_hover',
			[
				'label' => __( 'Icon Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-button-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_button_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_color_hover',
			[
				'label' => __( 'Indicator Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'indicator_background_hover',
			[
				'label' => __( 'Indicator Background', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-count-number:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'toggle_button_border_color_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wlmc-toggle-button-panel:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_button_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'toggle_button_card_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wlmc-toggle-button-panel',
				'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
			'toggle_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'toggle_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-toggle-button-panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Icon', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'toggle_icon_size',
			[
				'label' => __( 'Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-button-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'toggle_icon_spacing',
			[
				'label' => __( 'Spacing', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size-units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-total' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
            'toggle_indicator_offset',
            [
                'label' 		=> __( 'Indicator Offset', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
				'separator' 	=> 'before',
                'condition' 	=> [
                    'indicator_switch' => ''
                ],
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'toggle_indicator_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'toggle_indicator_offset' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -100,
                        'max' 	=> 100,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wlmc-count-number' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $this->add_responsive_control(
            'toggle_indicator_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'toggle_indicator_offset' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -100,
                        'max' 	=> 100,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wlmc-count-number' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_card_area',
			[
				'label' => __( 'Card', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_product_card_width',
			[
				'label' => __( 'Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 800,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'section_product_card_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wlmc-modal-wrapper',
            ]
        );

		$this->add_responsive_control(
			'section_product_card_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'section_product_card_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'section_product_card_border',
				'selector' 		=> '.wl {{WRAPPER}} .wlmc-modal-wrapper',
				'separator'		=> 'before'
			]
		);

		$this->add_control(
			'section_product_card_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor-pro' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wlmc-modal-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'section_product_card_shadow',
                'label'     => __( 'Box Shadow', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wlmc-modal-wrapper',
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_content_header',
			[
				'label' => __( 'Heading', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_product_content_header_alignment_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-count-text-panel',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'section_product_content_header_alignment_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-count-text-panel' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'section_product_content_header_alignment',
			[
				'label' => __( 'Alignment', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-count-text-panel' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_tabs_style',
			[
				'label' => __( 'Products', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_product_title_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Product Title', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item a' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'heading_product_price_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Product Price', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item .quantity' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_price_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item .quantity',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'heading_product_divider_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Divider', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => __( 'Style', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'woolementor-pro' ),
					'solid' => __( 'Solid', 'woolementor-pro' ),
					'double' => __( 'Double', 'woolementor-pro' ),
					'dotted' => __( 'Dotted', 'woolementor-pro' ),
					'dashed' => __( 'Dashed', 'woolementor-pro' ),
					'groove' => __( 'Groove', 'woolementor-pro' ),
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'border-bottom-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => __( 'Weight', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'divider_gap',
			[
				'label' => __( 'Spacing', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wlmc-modal-body ul li.woocommerce-mini-cart-item.mini_cart_item' => 'padding-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Remove Button', 'woolementor-pro' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_product_remove_button_size',
			[
				'label' => __( 'Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_area',
			[
				'label' => __( 'Area', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_line_height',
			[
				'label' => __( 'Line Height', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_product_remove_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'heading_product_remove_button_border',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body ul li a.remove.remove_from_cart_button',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_subtotal',
			[
				'label' => __( 'Subtotal', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_style_subtotal_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__total.total',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'section_style_subtotal_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__total.total' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'section_style_subtotal_color_alignment',
			[
				'label' => __( 'Alignment', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'space-between' => [
						'title' => __( 'Space Between', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'space-around' => [
						'title' => __( 'Space Around', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__total.total' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_buttons',
			[
				'label' => __( 'Buttons', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'buttons_layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline' 	=> __( 'Inline', 'woolementor-pro' ),
					'stacked' 	=> __( 'Grid', 'woolementor-pro' ),
				],
				'default' => 'inline',
				'prefix_class' => 'wlmc-menu-cart--buttons-',
			]
		);

		$this->add_control(
			'space_between_buttons',
			[
				'label' => __( 'Space Between', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons' => 'grid-column-gap: {{SIZE}}{{UNIT}}; grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_buttons_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 14 ] ],
		            'font_family' 	=> [ 'default' => 'Noto Sans' ],
		            'font_weight' 	=> [ 'default' => 400 ],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'view_cart_button_tabs_style' );
		$this->start_controls_tab( 'view_cart_button_tab_style', [ 'label' => __( 'Normal', 'elementor-pro' ) ] );

		$this->add_control(
			'heading_view_cart_button_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'View Cart', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'view_cart_button_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.wc-forward:first-child' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_cart_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.wc-forward:first-child' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'view_cart_border',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.wc-forward:first-child',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab( 'view_cart_button_tab_hover_style', [ 'label' => __( 'Hover', 'elementor-pro' ) ] );

		$this->add_control(
			'heading_view_cart_button_style_hover',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'View Cart', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'view_cart_button_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.wc-forward:first-child:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_cart_button_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.wc-forward:first-child:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'view_cart_border_hover',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.wc-forward:first-child:hover',
			]
		);

		$this->end_controls_tabs();

		$this->start_controls_tabs( 'checkout_button_tabs_style' );
		$this->start_controls_tab( 'checkout_button_tab_style', [ 'label' => __( 'Normal', 'elementor-pro' ) ] );

		$this->add_control(
			'heading_checkout_button_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Checkout', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'checkout_button_text_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'checkout_button_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'checkout_border',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward',
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab( 'checkout_button_tab_hover_style', [ 'label' => __( 'Hover', 'elementor-pro' ) ] );

		$this->add_control(
			'heading_checkout_button_style_hover',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Checkout', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'checkout_button_text_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'checkout_button_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'checkout_border_hover',
				'selector' => '.wl {{WRAPPER}} .wlmc-modal-body p.woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		if( !current_user_can( 'edit_pages' ) ) return;

		echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_title(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

		if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
		    echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
		}
	}
}