<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Basic_Menu extends Widget_Base {

	public $id;
	protected $nav_menu_index = 1;

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

	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label' => __( 'Menu', 'woolementor-pro' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'woolementor-pro' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no menus in your site.', 'woolementor-pro' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'woolementor-pro' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'woolementor-pro' ),
					'vertical' => __( 'Vertical', 'woolementor-pro' ),
					'dropdown' => __( 'Dropdown', 'woolementor-pro' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'align_items',
			[
				'label' => __( 'Align', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Stretch', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'elementor-nav-menu__align-',
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);

		$this->add_control(
			'pointer',
			[
				'label' => __( 'Pointer', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [
					'none' => __( 'None', 'woolementor-pro' ),
					'underline' => __( 'Underline', 'woolementor-pro' ),
					'overline' => __( 'Overline', 'woolementor-pro' ),
					'double-line' => __( 'Double Line', 'woolementor-pro' ),
					'framed' => __( 'Framed', 'woolementor-pro' ),
					'background' => __( 'Background', 'woolementor-pro' ),
					'text' => __( 'Text', 'woolementor-pro' ),
				],
				'style_transfer' => true,
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);

		$this->add_control(
			'animation_line',
			[
				'label' => __( 'Animation', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'slide' => 'Slide',
					'grow' => 'Grow',
					'drop-in' => 'Drop In',
					'drop-out' => 'Drop Out',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label' => __( 'Animation', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'draw' => 'Draw',
					'corners' => 'Corners',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_background',
			[
				'label' => __( 'Animation', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sweep-left' => 'Sweep Left',
					'sweep-right' => 'Sweep Right',
					'sweep-up' => 'Sweep Up',
					'sweep-down' => 'Sweep Down',
					'shutter-in-vertical' => 'Shutter In Vertical',
					'shutter-out-vertical' => 'Shutter Out Vertical',
					'shutter-in-horizontal' => 'Shutter In Horizontal',
					'shutter-out-horizontal' => 'Shutter Out Horizontal',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label' => __( 'Animation', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grow',
				'options' => [
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sink' => 'Sink',
					'float' => 'Float',
					'skew' => 'Skew',
					'rotate' => 'Rotate',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'pointer' => 'text',
				],
			]
		);

		$this->add_control(
			'indicator',
			[
				'label' => __( 'Submenu Indicator', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'none' => __( 'None', 'woolementor-pro' ),
					'classic' => __( 'Classic', 'woolementor-pro' ),
					'chevron' => __( 'Chevron', 'woolementor-pro' ),
					'angle' => __( 'Angle', 'woolementor-pro' ),
					'plus' => __( 'Plus', 'woolementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--indicator-',
			]
		);

		$this->add_control(
			'heading_mobile_dropdown',
			[
				'label' => __( 'Mobile Dropdown', 'woolementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);

		$breakpoints = Responsive::get_breakpoints();

		$this->add_control(
			'dropdown',
			[
				'label' => __( 'Breakpoint', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tablet',
				'options' => [
					/* translators: %d: Breakpoint number. */
					'mobile' => sprintf( __( 'Mobile (< %dpx)', 'woolementor-pro' ), $breakpoints['md'] ),
					/* translators: %d: Breakpoint number. */
					'tablet' => sprintf( __( 'Tablet (< %dpx)', 'woolementor-pro' ), $breakpoints['lg'] ),
					'none' => __( 'None', 'woolementor-pro' ),
				],
				'prefix_class' => 'woolementor-nav-menu--dropdown-',
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => __( 'Align', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'aside',
				'options' => [
					'aside' => __( 'Aside', 'woolementor-pro' ),
					'center' => __( 'Center', 'woolementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu__text-align-',
				'condition' => [
					'dropdown!' => 'none',
				],
			]
		);

		$this->add_control(
			'toggle',
			[
				'label' => __( 'Toggle Button', 'woolementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'burger',
				'options' => [
					'' => __( 'None', 'woolementor-pro' ),
					'burger' => __( 'Hamburger', 'woolementor-pro' ),
				],
				'prefix_class' => 'elementor-nav-menu--toggle elementor-nav-menu--',
				'render_type' => 'template',
				'frontend_available' => true,
				'condition' => [
					'dropdown!' => 'none',
				],
			]
		);

		$this->add_control(
			'toggle_align',
			[
				'label' => __( 'Toggle Align', 'woolementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor-pro' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				// 'selectors_dictionary' => [
				// 	'left' => 'margin-right: auto',
				// 	'center' => 'margin: 0 auto',
				// 	'right' => 'margin-left: auto',
				// ],
				'selectors' => [
					'.wl {{WRAPPER}} .elementor-menu-toggle.woolementor-menu-toggle' => 'justify-content: {{VALUE}}',
				],
				'condition' => [
					'toggle!' => '',
					'dropdown!' => 'none',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => __( 'Main Menu', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'dropdown',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-nav-menu .elementor-item',
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main .elementor-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main .elementor-item:hover,
					{{WRAPPER}} .woolementor-nav-menu--main .elementor-item.woolementor-item-active,
					{{WRAPPER}} .woolementor-nav-menu--main .elementor-item.highlighted,
					{{WRAPPER}} .woolementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => 'background',
				],
			]
		);

		$this->add_control(
			'color_menu_item_hover_pointer_bg',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main .elementor-item:hover,
					{{WRAPPER}} .woolementor-nav-menu--main .elementor-item.woolementor-item-active,
					{{WRAPPER}} .woolementor-nav-menu--main .elementor-item.highlighted,
					{{WRAPPER}} .woolementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_hover',
			[
				'label' => __( 'Pointer Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:before,
					{{WRAPPER}} .woolementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .elementor-item:before,
					{{WRAPPER}} .e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => __( 'Active', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'color_menu_item_active',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main .elementor-item.woolementor-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_active',
			[
				'label' => __( 'Pointer Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.woolementor-item-active:before,
					{{WRAPPER}} .woolementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.woolementor-item-active:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .elementor-item.woolementor-item-active:before,
					{{WRAPPER}} .e--pointer-framed .elementor-item.woolementor-item-active:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		/* This control is required to handle with complicated conditions */
		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'pointer_width',
			[
				'label' => __( 'Pointer Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .e--pointer-framed .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--pointer-underline .elementor-item:after,
					 {{WRAPPER}} .e--pointer-overline .elementor-item:before,
					 {{WRAPPER}} .e--pointer-double-line .elementor-item:before,
					 {{WRAPPER}} .e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
				],
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label' => __( 'Horizontal Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
                'default'       => [
                    'top'           => '10',
                    'bottom'        => '10',
                ],
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label' => __( 'Vertical Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
                'default'       => [
                    'top'           => '10',
                    'bottom'        => '10',
                ],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label' => __( 'Space Between', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .woolementor-nav-menu--main:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius_menu_item',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label' => __( 'Dropdown', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dropdown_description',
			[
				'raw' => __( 'On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', 'woolementor-pro' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_item_style' );

		$this->start_controls_tab(
			'tab_dropdown_item_normal',
			[
				'label' => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'color_dropdown_item',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a, {{WRAPPER}} .elementor-menu-toggle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_hover',
			[
				'label' => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'color_dropdown_item_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a:hover,
					{{WRAPPER}} .woolementor-nav-menu--dropdown a.woolementor-item-active,
					{{WRAPPER}} .woolementor-nav-menu--dropdown a.highlighted,
					{{WRAPPER}} .elementor-menu-toggle:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a:hover,
					{{WRAPPER}} .woolementor-nav-menu--dropdown a.woolementor-item-active,
					{{WRAPPER}} .woolementor-nav-menu--dropdown a.highlighted' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_active',
			[
				'label' => __( 'Active', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'color_dropdown_item_active',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a.woolementor-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item_active',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a.woolementor-item-active' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'dropdown_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'exclude' => [ 'line_height' ],
				'selector' => '{{WRAPPER}} .woolementor-nav-menu--dropdown .elementor-item, {{WRAPPER}} .woolementor-nav-menu--dropdown  .woolementor-sub-item',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dropdown_border',
				'selector' => '{{WRAPPER}} .woolementor-nav-menu--dropdown',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dropdown_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .woolementor-nav-menu--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .woolementor-nav-menu--dropdown li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'dropdown_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .woolementor-nav-menu--main .woolementor-nav-menu--dropdown, {{WRAPPER}} .woolementor-nav-menu__container.woolementor-nav-menu--dropdown',
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_dropdown_item',
			[
				'label' => __( 'Horizontal Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',

			]
		);

		$this->add_responsive_control(
			'padding_vertical_dropdown_item',
			[
				'label' => __( 'Vertical Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_dropdown_divider',
			[
				'label' => __( 'Divider', 'woolementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dropdown_divider',
				'selector' => '{{WRAPPER}} .woolementor-nav-menu--dropdown li:not(:last-child)',
				'exclude' => [ 'width' ],
			]
		);

		$this->add_control(
			'dropdown_divider_width',
			[
				'label' => __( 'Border Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_divider_border!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_top_distance',
			[
				'label' => __( 'Distance', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woolementor-nav-menu--main > .elementor-nav-menu > li > .woolementor-nav-menu--dropdown, {{WRAPPER}} .woolementor-nav-menu__container.woolementor-nav-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'style_toggle',
			[
				'label' => __( 'Toggle Button', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'toggle!' => '',
					'dropdown!' => 'none',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_style' );

		$this->start_controls_tab(
			'tab_toggle_style_normal',
			[
				'label' => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.elementor-menu-toggle' => 'color: {{VALUE}}', // Harder selector to override text color control
				],
			]
		);

		$this->add_control(
			'toggle_background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_style_hover',
			[
				'label' => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'toggle_color_hover',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.elementor-menu-toggle:hover' => 'color: {{VALUE}}', // Harder selector to override text color control
				],
			]
		);

		$this->add_control(
			'toggle_background_color_hover',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_size',
			[
				'label' => __( 'Size', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'toggle_border_width',
			[
				'label' => __( 'Border Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo wcd_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_title(), '<a href="https://codexpert.io/codesigner" target="_blank">CoDesigner Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( '/assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}

