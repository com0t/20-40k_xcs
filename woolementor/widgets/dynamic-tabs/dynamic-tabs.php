<?php
namespace Codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Dynamic_Tabs extends Widget_Base {

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

	protected function _register_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Tabs', 'woolementor-pro' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title & Description', 'woolementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab Title', 'woolementor-pro' ),
				'placeholder' => __( 'Tab Title', 'woolementor-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content_source',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'static_texts'	=> __( 'Static Texts', 'woolementor' ),
					'template'  	=> __( 'Templates', 'woolementor' ),
				],
				'default' 		=> 'static_texts',
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' 		=> __( 'Content', 'woolementor' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' , 'woolementor' ),
				'condition' => [
                    'tab_content_source' => 'static_texts'
                ],
				'show_label' 	=> false,
			]
		);

		$repeater->add_control(
			'tab_template',
			[
				'label' 		=> __( 'Tab Templates', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> wcd_get_template_list(),
				'condition' 	=> [
                    'tab_content_source' => 'template'
                ],
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Tabs Items', 'woolementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Tab #1', 'woolementor-pro' ),
						'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'woolementor-pro' ),
					],
					[
						'tab_title' => __( 'Tab #2', 'woolementor-pro' ),
						'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'woolementor-pro' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'woolementor-pro' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'navigation_position',
			[
				'label'		 	=> __( 'Navigation Position', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'top',
				'options' 		=> [
					'top' 		=> __( 'Top', 'woolementor-pro' ),
					'left' 		=> __( 'Left', 'woolementor-pro' ),
					'right' 	=> __( 'Right', 'woolementor-pro' ),
				],
				'prefix_class' 	=> 'wl-dynamic-tabs-view-',
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'navigation_position_align',
			[
				'label' 		=> __( 'Alignment', 'plugin-domain' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'flex-start' 		=> [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' 	=> [
						'title' => __( 'Center', 'plugin-domain' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'flex-end' 	=> [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'condition' => [
					'navigation_position' => 'top',
				],
				'selectors' => [
                    '.wl {{WRAPPER}} .wl-dynamic-tabs-wrapper' => 'justify-content: {{VALUE}};',
                ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => __( 'Tabs', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'woolementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tab_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-title, {{WRAPPER}} .wl-dynamic-tab-title a' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label' => __( 'Active Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-title.wl-dynamic-tab-active a' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'selector' => '.wl {{WRAPPER}} .wl-dynamic-tab-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'title_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'navigation_width',
			[
				'label' => __( 'Navigation Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation_position' => 'left',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'woolementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-title, {{WRAPPER}} .wl-dynamic-tab-title:before, {{WRAPPER}} .wl-dynamic-tab-title:after, {{WRAPPER}} .wl-dynamic-tab-content, {{WRAPPER}} .wl-dynamic-tabs-content-wrapper' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-mobile-title, {{WRAPPER}} .wl-dynamic-tab-desktop-title.wl-dynamic-tab-active, {{WRAPPER}} .wl-dynamic-tab-title:before, {{WRAPPER}} .wl-dynamic-tab-title:after, {{WRAPPER}} .wl-dynamic-tab-content, {{WRAPPER}} .wl-dynamic-tabs-content-wrapper' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-desktop-title.wl-dynamic-tab-active' => 'background-color: {{VALUE}};',
					// '.wl {{WRAPPER}} .wl-dynamic-tabs-content-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

        // content styling
        $this->start_controls_section(
        	'section_Content_style',
        	[
        		'label' => __( 'Content', 'woolementor-pro' ),
        		'tab' => Controls_Manager::TAB_STYLE,
        	]
        );

        $this->add_control(
			'content_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-content' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

        $this->add_control(
			'content_bg_color',
			[
				'label' => __( 'Background Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-content' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '.wl {{WRAPPER}} .wl-dynamic-tab-content',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Padding', 'woolementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-dynamic-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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