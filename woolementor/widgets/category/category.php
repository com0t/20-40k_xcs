<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class category extends Widget_Base {

    public $id;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->id = wcd_get_widget_id( __CLASS__ );
        $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [ 'fancybox' ];
	}

	public function get_style_depends() {
		return [ 'fancybox' ];
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

		/**
		 * Settings controls
		 */
		$this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Layout', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_responsive_control(
            'columns',
            [
                'label'     => __( 'Columns', 'woolementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    1 => __( '1 Column', 'woolementor' ),
                    2 => __( '2 Columns', 'woolementor' ),
                    3 => __( '3 Columns', 'woolementor' ),
                    4 => __( '4 Columns', 'woolementor' ),
                    5 => __( '5 Columns', 'woolementor' ),
                    6 => __( '6 Columns', 'woolementor' ),
                ],
                'desktop_default'   => 3,
                'tablet_default'    => 2,
                'mobile_default'    => 1,
                'style_transfer'    => true,
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
			'alignment',
			[
				'label'		=> __( 'Content Layout', 'woolementor-pro' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'left' 	=> [
						'title' 	=> __( 'Image Left', 'woolementor-pro' ),
						'icon' 		=> 'eicon-text-align-left',
					],
					'full' 	=> [
						'title' 	=> __( 'Image Full Width', 'woolementor-pro' ),
						'icon' 		=> 'eicon-cursor-move',
					],
                    'right'     => [
                        'title'     => __( 'Image Right', 'woolementor-pro' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
				],
				'default' 	=> 'left',
                'toggle'    => false,
			]
		);

		$this->end_controls_section();

        /**
         * Query controls
         */
        $this->start_controls_section(
            '_query_settings',
            [
                'label' => __( 'Query', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'order',
            [
                'label'         => __( 'Order', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'ASC',
                'options'       => [
                    'ASC'       => __( 'ASC', 'woolementor-pro' ),
                    'DESC'      => __( 'DESC', 'woolementor-pro' ),
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'         => __( 'Order By', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'default'       => 'name',
                'options'       => wcd_order_options(),
            ]
        );

        $this->add_control(
            'hide_empty',
            [
                'label'         => __( 'Hide empty categories', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor-pro' ),
                'label_off'     => __( 'No', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'custom_query',
            [
                'label'         => __( 'Custom Query', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        );

        $this->start_controls_tabs(
            'custom_query_controlls',
            [
                'condition'     => [
                    'custom_query' => 'yes'
                ],
            ]
        );

        $this->start_controls_tab(
            'custom_query_tab',
            [
                'label'     => __( 'Custom Query', 'woolementor-pro' ),
                
            ]
        );

        $this->add_control(
            'exclude',
            [
                'label'     => __( 'Exclude Category', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => wcd_get_terms(),
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $parent_options = [ 0 => __( 'Only Top Level', 'woolementor-pro' ) ] + wcd_get_terms();
        $this->add_control(
            'child_of',
            [
                'label'     => __( 'Parent Category', 'woolementor-pro' ),
                'description'    => __( 'Show only child categories of this category.', 'woolementor-pro' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $parent_options,
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

		/**
		 * Image controls
		 */
		$this->start_controls_section(
            'section_content_product_image',
            [
                'label' => __( 'Product Image', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'image_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Sale Ribbon controls
		 */
		$this->start_controls_section(
            'section_content_product_count',
            [
                'label' => __( 'Product Count', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'product_count',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor-pro' ),
				'label_off' 	=> __( 'Hide', 'woolementor-pro' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Category Style controls
		 */
		$this->start_controls_section(
            'style_section_box',
            [
                'label' => __( 'Card', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // start default style
        $this->add_control(
            'sale_notification_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-category' => 'background: #fff;align-items: center;',
                    '.wl {{WRAPPER}} .wl-category.flex' => 'display: flex; gap:20px',
                    '.wl {{WRAPPER}} .wl-category.flex .wl-ctgry-content.right' => 'margin-right: 5%;',
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-img' => 'width: 25%;',
                    '.wl {{WRAPPER}} .wl .wl-category .wl-ctgry-img.full,
                     .wl {{WRAPPER}} .wl-category .wl-ctgry-content.full' => 'width: 100%;',
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-img img' => 'width: 60px;',
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-content' => 'width: 75%;',
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-title' => 'margin-bottom: 5px;margin-top: 0;',
                ],
                'default' => 'traditional',
            ]
        );
        // end default css

        $this->add_responsive_control(
            'widget_card_height',
            [
                'label'     => __( 'Card Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-category' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'widget_card_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-category',
			]
		);

		$this->add_responsive_control(
			'widget_card_shadow_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '15',
                    'right'         => '15',
                    'bottom'        => '15',
                    'left'          => '15',
                ],
			]
		);

        
        $this->add_responsive_control(
            'gap',
            [
                'label'     => __( 'Gap Row', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
            ]
        );

        $this->add_responsive_control(
            'gap_column',
            [
                'label'     => __( 'Gap Column', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
            ]
        );

        $this->start_controls_tabs(
            'card_hover_section',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab( 
            'card_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_card_background',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wl-category',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'widget_card_border',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-category',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                            'isLinked'  => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#efefef',
                    ],
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 
            'card_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_card_background_hover',
                'label'     => __( 'Background', 'woolementor-pro' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wl-category:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'widget_card_border_hover',
                'label'     => __( 'Border', 'woolementor-pro' ),
                'selector'  => '.wl {{WRAPPER}} .wl-category:hover',
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'       => [
                    'top'           => '10',
                    'right'         => '10',
                    'bottom'        => '10',
                    'left'          => '10',
                ],
            ]
        );

		$this->end_controls_section();

        /**
         * Category Image
         */
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Image', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'widget_image_height',
            [
                'label'     => __( 'Image Height', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-img.left img' => 'height: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-img.right img' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],

                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
            ]
        );

        $this->add_responsive_control(
            'widget_image_width',
            [
                'label'     => __( 'Image Width', 'woolementor-pro' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-img.left img' => 'width: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-category .wl-ctgry-img.right img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 500
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 30
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 60,
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor-pro' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-ctgry-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Category Title
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Title', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor-pro' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-title',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    'font_family'   => [ 'default' => 'Noto Sans' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
			]
		);
        $this->start_controls_tabs(
            'title_hover_section',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab( 
            'title_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'title_color',
                'selector'  => '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-title',
                'fields_options' => [
                    'color' => [ 'default' => 'var(--wl-black)' ], 
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 
            'title_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'title_color_hover',
                'selector'  => '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-title:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        /**
         * Category Description
         */
        $this->start_controls_section(
            'section_style_count',
            [
                'label' => __( 'Product Count', 'woolementor-pro' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => __( 'Typography', 'woolementor-pro' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-desc',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 13 ] ],
                    'font_family'   => [ 'default' => 'Noto Sans' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );
        $this->start_controls_tabs(
            'desc_hover_section',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab( 
            'desc_normal',
            [
                'label'     => __( 'Normal', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'desc_color',
                'selector'  => '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-desc',
                'fields_options' => [
                    'color' => [ 'default' => 'var(--wl-black)' ], 
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab( 
            'desc_hover',
            [
                'label'     => __( 'Hover', 'woolementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'desc_color_hover',
                'selector'  => '.wl {{WRAPPER}} .wl-category .wl-ctgry-content .wl-ctgry-desc:hover',
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