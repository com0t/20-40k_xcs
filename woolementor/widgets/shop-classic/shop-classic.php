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

class Shop_Classic extends Widget_Base {

    public $id;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->id = wcd_get_widget_id( __CLASS__ );
        $this->widget = wcd_get_widget( $this->id );
        
        // Are we in debug mode?
        $min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
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
                'label' => __( 'Layout', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_responsive_control(
            'columns',
            [
                'label'     => __( 'Columns', 'woolementor' ),
                'type' 	    => Controls_Manager::SELECT,
                'options'   => [
                    1 => __( '1 Column', 'woolementor' ),
                    2 => __( '2 Columns', 'woolementor' ),
                    3 => __( '3 Columns', 'woolementor' ),
                    4 => __( '4 Columns', 'woolementor' ),
                ],
                'desktop_default' 	=> 3,
                'tablet_default' 	=> 2,
                'mobile_default' 	=> 1,
                'style_transfer' 	=> true,
                'selectors' => [
                    '.wl {{WRAPPER}} .cx-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(100px,1fr));',
                ],
            ]
        );

        $this->add_control(
			'alignment',
			[
				'label'		=> __( 'Content Alignment', 'woolementor' ),
				'type' 		=>Controls_Manager::CHOOSE,
				'options' 	=> [
					'wl-sc-left' 	=> [
						'title' 	=> __( 'Left', 'woolementor' ),
						'icon' 		=> 'eicon-text-align-left',
					],
					'wl-sc-center' 	=> [
						'title' 	=> __( 'Center', 'woolementor' ),
						'icon' 		=> 'eicon-text-align-center',
					],
                    'wl-sc-right'   => [
                        'title'     => __( 'Right', 'woolementor' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
				],
				'default' 	=> 'wl-sc-left',
                'toggle'    => false,
			]
		);

		$this->end_controls_section();

        /**
         * Get query controls
         * 
         * @author Jakaria Istauk <jakariamd35@gmail.com>
         * 
         * @since 3.0
        */
        Helper::get_shop_query_controls( $this );
        

		/**
		 * Image controls
		 */
		$this->start_controls_section(
            'section_content_product_image',
            [
                'label' => __( 'Product Image', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'image_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

        $this->add_control(
            'image_on_click',
            [
                'label'     => __( 'On Click', 'woolementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'          => __( 'None', 'woolementor' ),
                    'zoom'          => __( 'Zoom', 'woolementor' ),
                    'product_page'  => __( 'Product Page', 'woolementor' ),
                ],
                'default'   => 'none',
                'condition' => [
                    'image_show_hide' => 'yes'
                ],
            ]
        );

		$this->end_controls_section();

		/**
		 * Sale Ribbon controls
		 */
		$this->start_controls_section(
            'section_content_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'sale_ribbon_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->add_control(
			'sale_ribbon_text',
			[
				'label' 		=> __( 'On Sale Test', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Sale', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
                'condition'     => [
                    'sale_ribbon_show_hide' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

        /**
         * Sale Ribbon controls
         */
        $this->start_controls_section(
            'section_content_stock',
            [
                'label' => __( 'Stock Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'stock_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'stock_ribbon_text',
            [
                'label'         => __( 'Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Out Of Stock', 'woolementor' ),
                'placeholder'   => __( 'Type your text here', 'woolementor' ),
                'condition' => [
                    'stock_show_hide' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

		/**
		 * Cart controls
		 */
		$this->start_controls_section(
            'section_content_cart',
            [
                'label' => __( 'Cart', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'cart_show_hide',
			[
				'label' 		=> __( 'Show/Hide', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'woolementor' ),
				'label_off' 	=> __( 'Hide', 'woolementor' ),
				'return_value' 	=> 'yes',
				'default' 		=> 'yes',
			]
		);

		$this->end_controls_section();

        /**
         * Wishlist controls
         */
        $this->start_controls_section(
            'section_content_wishlist',
            [
                'label' => __( 'Wishlist', 'woolementor' ) . wcd_pro_text(),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'wishlist_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Pagination controls
         */
        $this->start_controls_section(
            'section_content_pagination',
            [
                'label' => __( 'Pagination', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
                'condition' =>[
                    'product_source' => 'shop'
                ]
            ]
        );

        $this->add_control(
            'pagination_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

		/**
		 * Product Style controls
		 */
		$this->start_controls_section(
            'style_section_box',
            [
                'label' => __( 'Card', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'widget_card_default_styles',
            [
                'label'     => __( 'Default', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-style .button' => 'background: transparent;padding: 0px;',
                    '.wl {{WRAPPER}} .wl-sc-product-style' => 'display: flex;justify-content: center; flex-wrap: wrap;',
                    '.wl {{WRAPPER}} .wl-sc-single-widget' => 'text-align: center;margin: auto;position: relative;overflow: hidden;border-radius: 0;',
                    '.wl {{WRAPPER}} .wl-sc-single-product' => 'float: left;width: 100%;',
                ],
                'default' => 'traditional',
            ]
        );

        $this->add_responsive_control(
            'widget_card_height',
            [
                'label'     => __( 'Card Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-single-widget' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 1000
                    ],
                    'em'    => [
                        'min'   => 1,
                        'max'   => 50
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'widget_card_background',
                'label'     => __( 'Background', 'woolementor' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '.wl {{WRAPPER}} .wl-sc-single-widget',
                'fields_options' => [
                    'background' =>[
                        'default' => 'classic'
                    ],
                    'color' =>[
                        'default' => '#fff'
                    ]
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'widget_card_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-single-widget',
                'separator' => 'before',
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
                            'isLinked'  => true,
                        ],
                    ],
                    'color' => [
                        'default' => 'var(--wl-light-gray)',
                    ],
                ],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'widget_card_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-single-widget',
                'fields_options' =>
                [
                    'box_shadow_type' =>
                    [ 
                        'default' =>'yes' 
                    ],
                    'box_shadow' => [
                        'default' =>
                            [
                                'horizontal' => 2,
                                'vertical'  => 7,
                                'blur'      => 8,
                                'spread'    => -12,
                                'color'     => 'rgb(175 175 175 / 60%)'
                            ]
                    ]
                ]
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
                    'size' => 25,
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
                    'size' => 25,
                ],
            ]
        );

		$this->end_controls_section();

        /**
         * Product Title
         */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Product Title', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-name a' => 'letter-spacing: 1.3px; margin-bottom: 10px;display: inline-block;',
                ],
                'default' => 'traditional',
            ]
        );

        $this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name'      => 'title_color',
                'selector'  => '.wl {{WRAPPER}} .wl-gradient-heading',

                'fields_options' => [
                    'color' => [ 'default' => 'var(--wl-black)' ], 
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-name a',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 16 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
			]
		);

        $this->end_controls_section();

        /**
         * Product Price
         */
        $this->start_controls_section(
            'section_style_price',
            [
                'label' => __( 'Product Price', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'price_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ins' => 'background: transparent;text-decoration: none;',
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del' => 'display: none;padding-right: 10px;',
                ],
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ins .amount' => 'color: {{VALUE}}',
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price > .amount' => 'color: {{VALUE}}',
                ],
                'default' => 'color: var(--wl-gray);'
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price ins,
                                .wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price > .amount',
			]
		);

		$this->add_control(
			'sale_price_show_hide',
			[
				'label'			=> __( 'Show Sale Price', 'woolementor' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' 		=> __( 'Show', 'your-plugin' ),
				'label_off' 	=> __( 'Hide', 'your-plugin' ),
				'return_value' 	=> 'block',
				'default' 		=> 'none',
				'separator' 	=> 'before',
				'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del' => 'display: {{VALUE}}',
                ],
			]
		);

        $this->add_control(
            'sale_price_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del .amount' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'sale_price_show_hide' => 'block'
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'sale_price_size_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-info h2.wl-sc-price del',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
				'condition' => [
                    'sale_price_show_hide' => 'block'
                ],
			]
		);

        $this->end_controls_section();

        /**
         * Product Currency Symbol
         */
        $this->start_controls_section(
            'section_style_currency',
            [
                'label' => __( 'Currency Symbol', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_currency',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
                'default'  => 'color: var(--wl-gray);'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' 		=> 'price_currency_typography',
                'label' 	=> __( 'Typography', 'woolementor' ),
                'scheme' 	=> Typography::TYPOGRAPHY_3,
                'selector' 	=> '.wl {{WRAPPER}} .woocommerce-Price-currencySymbol',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 14 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 500 ],
                ],
            ]
        );

        $this->end_controls_section();

		/**
		 * Product Image controls
		 */
		$this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Product Image', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' 	=> [
                    'image_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'mage_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img' => 'overflow: hidden; height: auto; display: flex; align-items: center; justify-content: center;',
                    '.wl {{WRAPPER}} .wl-sc-product-img img' => 'max-width: 100%;',
                ],
                'default' => 'traditional',
            ]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 		=> 'image_thumbnail',
				'exclude' 	=> [],
				'include' 	=> [],
				'default' 	=> 'woolementor-thumb',
			]
		);

        $this->add_responsive_control(
            'image_width',
            [
                'label' 	=> __( 'Image Width', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img img' => 'width: {{SIZE}}{{UNIT}}',
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

        $this->add_responsive_control(
            'image_height',
            [
                'label' 	=> __( 'Image Height', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img img' => 'height: {{SIZE}}{{UNIT}}',
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

        $this->add_responsive_control(
            'image_box_height',
            [
                'label' 	=> __( 'Image Box Height', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img' => 'height: {{SIZE}}{{UNIT}}',
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

		$this->add_responsive_control(
			'image_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sc-product-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator' 	=> 'before',
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sc-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'image_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-img img',
			]
		);

		$this->add_responsive_control(
            'image_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sc-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' 		=> 'image_box_shadow',
				'label' 	=> __( 'Box Shadow', 'woolementor' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-img img',
			]
		);

		$this->start_controls_tabs(
            'image_effects',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'image_effects_normal',
            [
                'label' 	=> __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' 	=> __( 'Opacity', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
                'range' 	=> [
                    'px' 	=> [
                        'max' 	=> 1,
                        'min' 	=> 0.10,
                        'step' 	=> 0.01,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' 		=> 'image_css_filters',
                'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-img img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'image_hover',
            [
                'label' 	=> __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' 	=> __( 'Opacity', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
                'range' 	=> [
                    'px' 	=> [
                        'max' 	=> 1,
                        'min' 	=> 0.10,
                        'step' 	=> 0.01,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img img:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' 		=> 'image_css_filters_hover',
                'selector' 	=> '.wl {{WRAPPER}} .wl-sc-product-img img:hover',
            ]
        );

        $this->add_control(
            'image_hover_transition',
            [
                'label' 	=> __( 'Transition Duration', 'woolementor' ),
                'type' 		=> Controls_Manager::SLIDER,
                'range' 	=> [
                    'px' 	=> [
                        'max' 	=> 3,
                        'step' 	=> 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-img img:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();

        /**
        * Sale Ribbon Styleing 
        */

		$this->start_controls_section(
            'section_style_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ribbon_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'position: absolute;text-align: center;letter-spacing: 1px;z-index: 100;top:27px',
                    '.wl {{WRAPPER}} .wl-sc-right .wl-sc-corner-ribbon' => 'right: 0;',
                    '.wl {{WRAPPER}} .wl-sc-left .wl-sc-corner-ribbon' => 'left: 0;',
                ],
                'default' => 'traditional',
            ]
        );

		$this->add_control(
            'sale_ribbon_offset_toggle',
            [
                'label' 		=> __( 'Offset', 'woolementor' ),
                'type' 			=> Controls_Manager::POPOVER_TOGGLE,
                'label_off' 	=> __( 'None', 'woolementor' ),
                'label_on' 		=> __( 'Custom', 'woolementor' ),
                'return_value' 	=> 'yes',
                'default'  => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'media_offset_x',
            [
                'label' 		=> __( 'Offset Left', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -1000,
                        'max' 	=> 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-left .wl-sc-corner-ribbon' => 'left: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sc-right .wl-sc-corner-ribbon' => 'right: {{SIZE}}{{UNIT}}'
                ],
                'render_type' 	=> 'ui',
            ]
        );

        $this->add_responsive_control(
            'media_offset_y',
            [
                'label' 		=> __( 'Offset Top', 'woolementor' ),
                'type' 			=> Controls_Manager::SLIDER,
                'size_units' 	=> ['px'],
                'condition' 	=> [
                    'sale_ribbon_offset_toggle' => 'yes'
                ],
                'range' 		=> [
                    'px' 		=> [
                        'min' 	=> -1000,
                        'max' 	=> 1000,
                    ],
                ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 27,
                ]
            ]
        );
        $this->end_popover();

        $this->add_responsive_control(
            'sale_ribbon_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $this->add_responsive_control(
            'sale_ribbon_transform',
            [
                'label'     => __( 'Transform', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-corner-ribbon' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $this->add_control(
            'sale_ribbon_font_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
                'default'   => '#ffffff'
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'content_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-sc-corner-ribbon',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 12 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
			]
		);

		$this->add_control(
			'sale_ribbon_background',
			[
				'label' 		=> __( 'Background', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'background: {{VALUE}}',
				],
                'default'       => 'var(--wl-black)'
			]
		);

		$this->add_responsive_control(
			'sale_ribbon_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'default'       => [
                    'top'           => '0',
                    'right'         => '12',
                    'bottom'        => '0',
                    'left'          => '12',
                ],
                'separator' => 'after'
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 			=> 'sale_ribbon_border',
				'label' 		=> __( 'Border', 'woolementor' ),
				'selector' 		=> '.wl {{WRAPPER}} .wl-sc-corner-ribbon',
			]
		);

		$this->add_responsive_control(
            'sale_ribbon_border_radius',
            [
                'label' 		=> __( 'Border Radius', 'woolementor' ),
                'type' 			=> Controls_Manager::DIMENSIONS,
                'size_units' 	=> [ 'px', '%' ],
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-sc-corner-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /**
        * Stock Ribbon Styleing 
        */

        $this->start_controls_section(
            'section_style_stock_ribbon',
            [
                'label' => __( 'Stock Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'stock_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'stock_ribbon_default_styles',
            [
                'label'     => __( 'Display', 'woolementor-pro' ),
                'type'      => Controls_Manager::HIDDEN,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'position: absolute;text-align: center;letter-spacing: 1px;z-index: 100;top:53px',
                    '.wl {{WRAPPER}} .wl-sc-right .wl-sc-stock' => 'right: 0;',
                    '.wl {{WRAPPER}} .wl-sc-left .wl-sc-stock' => 'left: 0;',
                ],
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'stock_offset_toggle',
            [
                'label'         => __( 'Offset', 'woolementor' ),
                'type'          => Controls_Manager::POPOVER_TOGGLE,
                'label_off'     => __( 'None', 'woolementor' ),
                'label_on'      => __( 'Custom', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'stock_media_offset_x',
            [
                'label'         => __( 'Offset Left', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'stock_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-right .wl-sc-stock' => 'right: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sc-left .wl-sc-stock' => 'left: {{SIZE}}{{UNIT}}'
                ],
                'default'   => [
                    'unit' => 'px',
                    'size' => 0
                ],
                'render_type'   => 'ui',
            ]
        );

        $this->add_responsive_control(
            'stock_media_offset_y',
            [
                'label'         => __( 'Offset Top', 'woolementor' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'condition'     => [
                    'stock_offset_toggle' => 'yes'
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1000,
                        'max'   => 1000,
                    ],
                ],
                'default' =>[
                    'unit' => 'px',
                    'size' => 53
                ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();

        $this->add_responsive_control(
            'stock_ribbon_width',
            [
                'label'     => __( 'Width', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', '%', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 50,
                        'max'   => 500
                    ]
                ],
            ]
        );

        $this->add_responsive_control(
            'stock_ribbon_transform',
            [
                'label'     => __( 'Transform', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => '-webkit-transform: rotate({{SIZE}}deg); transform: rotate({{SIZE}}deg);',
                ],
                'range'     => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 360
                    ]
                ],
            ]
        );

        $this->add_control(
            'stock_ribbon_font_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'color: {{VALUE}}',
                ],
                'default'   => '#fff',
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'stock_content_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_3,
                'selector'  => '.wl {{WRAPPER}} .wl-sc-stock',
                'fields_options'    => [
                    'typography'    => [ 'default' => 'yes' ],
                    'font_size'     => [ 'default' => [ 'size' => 12 ] ],
                    // 'line_height'   => [ 'default' => [ 'size' => 37 ] ],
                    'font_family'   => [ 'default' => 'Montserrat' ],
                    'font_weight'   => [ 'default' => 400 ],
                ],
            ]
        );

        $this->add_control(
            'stock_ribbon_background',
            [
                'label'         => __( 'Background', 'woolementor' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'background: {{VALUE}}',
                ],
                'default'       => '#ccc'
            ]
        );

        $this->add_responsive_control(
            'stock_ribbon_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'top' => 3,
                    'right' => 10,
                    'bottom' => 3,
                    'left' => 10,
                    'isLinked' => false
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'stock_ribbon_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-stock',
            ]
        );

        $this->add_responsive_control(
            'stock_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-stock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ], 
            ]
        );

        $this->end_controls_section();

        /**
         * Cart Button
         */
        $this->start_controls_section(
            'section_style_cart',
            [
                'label' => __( 'Cart Button', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'cart_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'cart_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'eicon-cart-solid',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'luggage-cart',
                        'opencart',
                    ],
                    'fa-solid'  => [
                        'shopping-cart',
                        'cart-arrow-down',
                        'cart-plus',
                        'luggage-cart',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'cart_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_area_size',
            [
                'label'     => __( 'Area Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.wl {{WRAPPER}} .wl-sc-info-icons a.added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'cart_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'cart_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-product-cart i',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-cart i:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-product-cart i:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_view_cart',
            [
                'label'     => __( 'View Cart', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color_view_cart',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

         $this->add_responsive_control(
            'cart_icon_view_cart_top',
            [
                'label'     => __( 'Margin Top', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_icon_view_cart_left',
            [
                'label'     => __( 'Margin Left', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .added_to_cart.wc-forward::after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Wishlist Button
         */
        $this->start_controls_section(
            'section_style_wishlist',
            [
                'label' => __( 'Wishlist Button', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' 	=> [
                    'wishlist_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'eicon-heart',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'heart',
                    ],
                    'fa-solid'  => [
                        'heart',
                        'heart-broken',
                        'heartbeat',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'wishlist_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_area_size',
            [
                'label'     => __( 'Area Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'wishlist__separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'wishlist_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-product-fav',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-product-fav:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-product-fav:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Pagination
         */
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => __( 'Pagination', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'product_source'        => 'shop',
                    'pagination_show_hide'  => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pagination_alignment',
            [
                'label'     => __( 'Alignment', 'woolementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'      => [
                        'title'     => __( 'Left', 'woolementor' ),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title'     => __( 'Center', 'woolementor' ),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title'     => __( 'Right', 'woolementor' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_gap',
            [
                'label'     => __( 'Gap with shop', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                'default' =>[
                    'unit' => 'px',
                    'size' => 20
                ]
            ]
        );

        $this->add_control(
            'pagination_left_icon',
            [
                'label'     => __( 'Left Icon', 'woolementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-chevron-left',
                    'library'   => 'solid',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'pagination_right_icon',
            [
                'label'     => __( 'Right Icon', 'woolementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'eicon-chevron-right',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_icon_size',
            [
                'label'     => __( 'Font Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_area',
            [
                'label'     => __( 'Area Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_line_height',
            [
                'label'     => __( 'Line Height', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_item_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'pagination_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'pagination_normal_item',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers',
            ]
        );

        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_current_item',
            [
                'label'     => __( 'Active', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pagination_current_item_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_current_item_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_current_item_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current',
            ]
        );

        $this->add_responsive_control(
            'pagination_current_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'pagination_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pagination_hover_item_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_item_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_hover_item_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover',
            ]
        );

        $this->add_responsive_control(
            'pagination_hover_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-sc-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	}

	protected function render() {  

		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes( 'sale_ribbon_text', 'basic' );
        $this->add_render_attribute( 'title_gradient_color', 'class', 'wl-gradient-heading' );
        $empty_message = __( 'No Product Found!', 'woolementor' );
        extract( $settings );

        if ( !wcd_is_pro_activated() && !wcd_is_preview_mode() && !wcd_is_edit_mode() ) {
            $wishlist_show_hide = 'no';
        }
        
        $products = wcd_query_products( $settings );        
        $user_id  = get_current_user_id();
        $wishlist = wcd_get_wishlist( $user_id );
        ?>

		<div class="wl-sc-product-style">
			<div class="cx-container">
                <div class="cx-grid">
                <?php
                if( $products->have_posts()) : 
                    while( $products->have_posts()) : $products->the_post();
                        $product_id = get_the_ID();
                        $product    = wc_get_product( $product_id );
                        $thumbnail  = get_the_post_thumbnail_url( $product_id, $image_thumbnail_size );
                        $fav_product= in_array( $product_id, $wishlist );

                        if ( !empty( $fav_product ) ) {
                            $fav_item = 'fav-item';
                        }
                        else{
                            $fav_item = '';
                        }
                        ?>

                        <div class="wl-sc-single-product <?php echo esc_attr( $alignment ); ?>">
                            <div class="wl-sc-single-widget">
                                <?php if ( 'yes' == $sale_ribbon_show_hide && $product->is_on_sale() ): ?>
                                    <div class="wl-sc-corner-ribbon">
                                        <?php
                                        printf( '<span %1$s>%2$s</span>',
                                            $this->get_render_attribute_string( 'sale_ribbon_text' ),
                                            esc_html( $settings['sale_ribbon_text' ] )
                                        );
                                        ?>
                                    </div>
                                <?php endif;

                                if ( 'yes' == $image_show_hide ): ?>
                                    <div class="wl-sc-product-img">

                                        <?php if ( 'none' == $image_on_click ): ?>
                                            <img src="<?php echo esc_html( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>  
                                        <?php elseif ( 'zoom' == $image_on_click ) : ?>
                                            <a class="wl-sc-product-image-zoom" href="<?php echo esc_url( $thumbnail ); ?>"><img src="<?php echo esc_url( $thumbnail ); ?>" alt=""/></a>
                                        <?php elseif ( 'product_page' == $image_on_click ) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>"/>                              
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                <?php endif;

                                if( 'outofstock' == $product->get_stock_status() && 'yes' == $stock_show_hide ): ?>
                                    <div class="wl-sc-stock">
                                        <?php echo esc_html( $stock_ribbon_text ); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="wl-sc-product-details">
                                    <div class="wl-sc-product-info">
                                        <div class="wl-sc-product-name"><a <?php echo $this->get_render_attribute_string( 'title_gradient_color' ); ?> href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a></div>

                                        <h2 class="wl-sc-price"><?php echo $product->get_price_html(); ?></h2>
                                    </div>
                                    <div class="wl-sc-info-icons">
                                        <?php if ( 'yes' == $wishlist_show_hide ): ?>
                                            <div class="wl-sc-product-fav ajax_add_to_wish <?php echo esc_attr( $fav_item ); ?>" data-product_id="<?php echo $product_id; ?>">
                                                <i class="<?php echo esc_attr( $wishlist_icon['value'] ); ?>"></i>
                                            </div>
                                        <?php endif;

                                        if ( 'yes' == $cart_show_hide ): ?>
                                            <?php if ( 'simple' == $product->get_type() ): ?>
                                                <div class="wl-cart-area">
                                                    <a href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" class="wl-sc-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?> add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                                </div>
                                            <?php else: ?>
                                                <div class="wl-cart-area">
                                                    <a href="<?php echo get_permalink( $product_id ); ?>" data-quantity="1" class="wl-sc-product-cart button product_type_<?php echo esc_attr( $product->get_type() ); ?>" data-product_id="<?php echo $product_id; ?>" ><i class="<?php echo esc_attr( $cart_icon['value'] ); ?>"></i></a>
                                                </div>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; wp_reset_query(); else: 

                    echo "<p>{$empty_message}</p>";

                endif; ?>
                </div>
			</div> 
		</div>

        <?php 
        if ( 'yes' == $pagination_show_hide ):

            echo '<div class="wl-sc-pagination">';

            /**
            * woolementor pagination
            */
            wcd_pagination( $products, $pagination_left_icon, $pagination_right_icon ); 

            echo '</div>';

            /**
             * Load Script
             */
            $this->render_script();

        endif;
	}

    protected function render_script() {
        ?>
        <script>
            jQuery(function($){
                $(".wl-sc-product-image-zoom").fancybox({
                    arrows: true,
                    'transitionIn'  :   'elastic',
                    'transitionOut' :   'elastic',
                    'speedIn'       :   600, 
                    'speedOut'      :   200, 
                    'overlayShow'   :   false

                }).attr('data-fancybox', 'gallery');
            })
        </script>
        <?php
    }
}