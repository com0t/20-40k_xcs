<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class My_Account extends Widget_Base {

	public $id;
	protected $form_close='';

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}" ];
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

	protected function _register_controls() {

		$this->start_controls_section(
			'content',
			[
				'label' => __( 'Content', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_img',
			[
				'label' 		=> __( 'Show Image', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'show_name',
			[
				'label' 		=> __( 'Show Name', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
				'separator'		=> 'before',
			]
		);

		$this->add_control(
			'user_data',
			[
				'label' => __( 'Display User\'s ', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'display_name',
				'options' => [
					'display_name'  => __( 'Display Name', 'woolementor' ),
					'user_nicename' => __( 'Nice Name', 'woolementor' ),
					'user_login' 	=> __( 'Username', 'woolementor' ),
					'user_email' 	=> __( 'Email', 'woolementor' ),
				],
				'condition' => [
					'show_name' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		// Card styling
		$this->start_controls_section(
			'card_style',
			[
				'label' => __( 'Profile Card', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_name' => 'yes',
					'show_img' => 'yes',
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'flex;',
				'options' => [
					'flex;'  		=> __( 'Flex', 'woolementor' ),
					'flex;flex-direction: row-reverse'  => __( 'Reverse Flex', 'woolementor' ),
					'' => __( 'Normal', 'woolementor' )
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'display:{{VALUE}}'
				]
			]
		);

		$this->add_control(
			'content_position',
			[
				'label' => __( 'Position', 'woolementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Top', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-middle',
					],
					'end' => [
						'title' => __( 'Bottom', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'condition' => [
					'layout!' => '',
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'align-items:{{VALUE}}'
				]
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => __( 'Content Gap', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout!' => '',
				],
			]
		);

		$this->add_control(
			'Card_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'card_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wcd-customer-box',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wcd-customer-box',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wcd-customer-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		//image styling
		$this->start_controls_section(
			'img_style',
			[
				'label' => __( 'Image', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_img' => 'yes',
				],
			]
		);

		$this->add_control(
			'img_default_style',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img img' => 'height: 100%; width:100%;',
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'overflow:hidden;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'img_width',
			[
				'label' => __( 'Width', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'img_height',
			[
				'label' => __( 'Height', 'woolementor' ),
				'type' 	=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'img_margin',
			[
				'label' => __( 'Margin', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'img_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'img_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'img_border',
				'label' => __( 'Border', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img',
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' 	=> [
					'unit' 	=> '%',
					'top' 	=> 50,
					'right' => 50,
					'bottom'=> 50,
					'left' 	=> 50,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//content part styling
		$this->start_controls_section(
			'name_style',
			[
				'label' => __( 'Name', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __( 'Position', 'woolementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
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
				'default' 	=> 'left',
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-ab-name' => 'text-align:{{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-name',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default'   => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-customer-box .wcd-ab-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'tab_area_style',
			[
				'label' => __( 'Tab Area', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'tab_area_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation',
			]
		);

		$this->add_control(
			'tab_area_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_area_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'tab_area_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation',
			]
		);

		$this->add_control(
			'tab_area_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tab_area_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation',
			]
		);

		$this->add_control(
			'gap_with_content',
			[
				'label' => __( 'Gap with content', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-my-account-left .woocommerce-MyAccount-navigation' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-my-account-top .woocommerce-MyAccount-navigation' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'menu_style',
			[
				'label' => __( 'Tab Design', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_position',
			[
				'label' => __( 'Tab Position', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'plugin-domain' ),
						'icon' => 'eicon-v-align-top',
					],
				],
				'default' => 'left',
				'toggle' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'menu_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'menu_text_color',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li a',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'menu_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li',
			]
		);

		$this->add_control(
			'menu_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'menu_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'menu_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li',
			]
		);

		$this->add_control(
			'menu_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li',
			]
		);
		$this->end_controls_section();

		// active tab design
		$this->start_controls_section(
			'active_tab_style',
			[
				'label' => __( 'Active Tab Design', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'active_menu_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'active_menu_text_color',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active a',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'active_menu_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active',
			]
		);

		$this->add_control(
			'active_menu_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'active_menu_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'active_menu_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active',
			]
		);

		$this->add_control(
			'active_menu_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-navigation ul li.is-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// content part design
		$this->start_controls_section(
			'content_tab_style',
			[
				'label' => __( 'Content Section', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'tab_content_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-content',
			]
		);

		$this->add_control(
			'tab_content_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_content_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'tab_content_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '.wl {{WRAPPER}} .woocommerce-MyAccount-content',
			]
		);

		$this->add_control(
			'tab_content_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'.wl {{WRAPPER}} .woocommerce-MyAccount-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tab_content_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .woocommerce-MyAccount-content',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {		
		$settings = $this->get_settings_for_display();
		extract( $settings );
		?>

		<div class="wl-my-account wl-my-account-<?php echo $tab_position; ?>">
			<?php 
			$user_id 	= get_current_user_id();
			if ( $user_id ) {
				$image_html = $name_html = '';

				if ( $settings['show_img'] == 'yes' ){
					$avatar_url = get_avatar_url( $user_id );
					$image_html = "<div class='wcd-ab-img'><img src='{$avatar_url}'></div>";
				}

				if ( $settings['show_name'] == 'yes' ){
					$user 		= get_user_by( 'ID', $user_id )->data;
					$data_type 	= $settings['user_data'];
					$data 		= $user->$data_type;
					$name_html 	= "<div class='wcd-ab-name'>{$data}</div>";
				}

				echo "<div class='wcd-customer-box'>{$image_html}{$name_html}</div>";
			}
			echo do_shortcode( '[woocommerce_my_account]' ); ?>
		</div>

		<?php
	}
}

