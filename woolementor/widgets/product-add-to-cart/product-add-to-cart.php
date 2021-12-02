<?php
namespace Codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

class Product_Add_To_Cart extends Widget_Base {

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
		return [ 'fancybox' ];
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
		 * Cart Content
		 */
		$this->start_controls_section(
			'add_to_cart_section',
			[
				'label' 		=> __( 'Add to Cart', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'add_to_cart_text',
			[
				'label' 		=> __( 'Button Text', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Add to Cart', 'woolementor' ),
				'placeholder' 	=> __( 'Type your title here', 'woolementor' ),
			]
		);

		$this->add_control(
			'_product_type',
			[
				'label' 		=> __( 'Product Type', 'woolementor' ),
				'type' 			=> Controls_Manager::HIDDEN,
				'show_external' => false,
				'default' 		=> $this->wcd_get_product_type(),
			]
		);

		$this->end_controls_section();

		if( $this->is_wl_single() ):
			/**
			 * Preview Mode
			 */
			$this->start_controls_section(
				'_preview_mode_section',
				[
					'label' => __( 'Preview Mode', 'woolementor' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'_preview_important_note',
				[
					'label' => __( '', 'woolementor' ),
					'type' => Controls_Manager::RAW_HTML,
					'raw' => __( 'Choose a product type to show preview for. Applicable for the edit and preview modes only. The live mode will show the appropriate components. (e.g. Quantity input field for Simple products, Variations\' selection for Variable products etc)', 'woolementor' ),
					'content_classes' => 'elementor-alert _preview_important_note',
				]
			);


			$this->add_control(
				'_preview_type',
				[
					'label' => __( 'Show Preview For', 'woolementor' ),
					'type' 	=> Controls_Manager::SELECT,
					'options' => [
						'simple' 	=> __( 'Simple', 'woolementor' ),
						'variable' 	=> __( 'Variable', 'woolementor' ),
						'grouped' 	=> __( 'Grouped', 'woolementor' ),
					],
					'default' => 'simple'
				]
			);

			$this->end_controls_section();

		endif;

		/**
		 * add to cart button
		 */
		$this->start_controls_section(
			'add_to_cart_style',
			[
				'label' => __( 'Button', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'add_to_cart_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
			'add_to_cart_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' 		=> [
					'unit' 	=> 'px',
					'top'	=> 15,
					'right'	=> 15,
					'bottom'=> 15,
					'left'	=> 15,
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'add_to_cart_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'add_to_cart_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'add_to_cart_box_shadow',
				'label' => __( 'Box Shadow', 'woolementor' ),
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->start_controls_tabs(
			'add_to_cart_button',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab( 
			'add_to_cart_normal',
			[
				'label' 	=> __( 'Normal', 'woolementor' ),
			]
		);

        $this->add_control(
			'add_to_cart_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'add_to_cart_bg',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'add_to_cart_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'add_to_cart_hover',
			[
				'label' 	=> __( 'Hover', 'woolementor' ),
			]
		);

        $this->add_control(
			'add_to_cart_hover_color',
			[
				'label' 	=> __( 'Text Color', 'woolementor' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'add_to_cart_hover_bg',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'add_to_cart_border_hover',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover',
			]
		);

		$this->add_control(
			'add_to_cart_hover_transition',
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
					'.wl {{WRAPPER}} .wl-atc-button-area .single_add_to_cart_button.button:hover' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * quantity Input
		 */
		$this->start_controls_section(
			'qty_input',
			[
				'label' => __( 'Quantity Input', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_product_type!' => 'external'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'qty_input_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-atc-button-area .quantity input,
								.wl {{WRAPPER}} .wl-atc-button-area .quantity input.qty',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'qty_input_align',
			[
				'label' 		=> __( 'Alignment', 'woolementor' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'left' => [
						'title' => __( 'Left', 'woolementor' ),
						'icon' 	=> 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' 	=> 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor' ),
						'icon' 	=> 'eicon-text-align-right',
					],
				],
				'default' 		=> 'center',
				'toggle' 		=> true,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'qty_input_width',
			[
				'label' 	=> __( 'Width', 'woolementor' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 110,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity' => 'width: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'width: 100%',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'qty_input_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-atc-button-area .quantity input',
			]
		);

		$this->add_responsive_control(
			'qty_input_border_radius',
			[
				'label'         => __( 'Border Radius', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'qty_input_margin',
			[
				'label'         => __( 'Margin', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before'
			]
		);

		$this->add_responsive_control(
			'qty_input_padding',
			[
				'label'         => __( 'Padding', 'woolementor' ),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => [ 'px', '%', 'em' ],
				'selectors'     => [
					'.wl {{WRAPPER}} .wl-atc-button-area .quantity input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' 		=> [
					'unit' 	=> 'px',
					'top' 	=> 17,
					'right' => 17,
					'bottom'=> 17,
					'left' 	=> 17,
					'isLinked' => true,
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Table Design
		 */
		$this->start_controls_section(
			'table_design',
			[
				'label' => __( 'Table Design', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'variable',
						],
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'grouped',
						],
						[
							'name' => '_preview_type',
							'operator' => '==',
							'value' => 'variable',
						],
						[
							'name' => '_preview_type',
							'operator' => '==',
							'value' => 'grouped',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-atc-button-area table',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table',
			]
		);

		$this->end_controls_section();

		/**
		 * Table row Design
		 */
		$this->start_controls_section(
			'table_row_design',
			[
				'label' => __( 'Table Row Design', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'variable',
						],
						[
							'name' => '_product_type',
							'operator' => '==',
							'value' => 'grouped',
						],
						[
							'name' => '_preview_type',
							'operator' => '==',
							'value' => 'variable',
						],
						[
							'name' => '_preview_type',
							'operator' => '==',
							'value' => 'grouped',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'table_content',
				'label' => __( 'Typography', 'woolementor' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr td',
			]
		);

		$this->add_control(
			'table_content_align',
			[
				'label' 		=> __( 'Vertical Alignment', 'woolementor' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'top' => [
						'title' => __( 'Top', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'woolementor' ),
						'icon' 	=> 'eicon-v-align-bottom',
					],
				],
				'default' 		=> 'top',
				'toggle' 		=> true,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area table tr td' => 'vertical-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_row_border',
				'label'         => __( 'Border', 'woolementor' ),
				'selector'      => '.wl {{WRAPPER}} .wl-atc-button-area table tr td',
			]
		);

        $this->start_controls_tabs( 
        	'table_content_design',
        	[
                'separator' => 'before'
            ] 
        );

        $this->start_controls_tab(
            'table_row_odd',
            [
                'label' => __( 'ODD Row', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_row_background_odd',
				'label' => __( 'Background 2', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td',
			]
		);

		$this->add_control(
            'table_row_text_odd',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td a' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n+1) td .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                ],
            ]
        );
		 
		$this->end_controls_tab();

		$this->start_controls_tab(
            'table_row_even',
            [
                'label' => __( 'Even Row', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_row_background_even',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td',
			]
		);

		$this->add_control(
            'table_row_text_even',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td' => 'color: {{VALUE}};',
                    '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td a' => 'color: {{VALUE}};',
                    '.wl {{WRAPPER}} .wl-atc-button-area table tr:nth-child(2n) td .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
            'table_row_hover',
            [
                'label' => __( 'Hover Row', 'woolementor' ),
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_row_background_hover',
				'label' => __( 'Background 2', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td',
			]
		);

		$this->add_control(
            'table_row_text_hover',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td a' => 'color: {{VALUE}};',
					'.wl {{WRAPPER}} .wl-atc-button-area table tr:hover td .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function is_wl_single(){
		if( !isset( $_GET['post'] ) || get_post_type( $_GET['post'] ) != 'elementor_library' ) return false;

		$template_type =  get_post_meta( $_GET['post'], '_elementor_template_type', true );

		if ( $template_type == 'wl-single' ) return true;

		return false;
	}

	protected function wcd_get_product_type() {

		$product_id = get_the_ID();
		$product 	= wc_get_product( $product_id );

		if ( $product ) {
			return $product->get_type();
		}

		return false;
	}

	protected function render() {

		$settings 	= $this->get_settings_for_display();

		$this->render_editing_attributes();

		$product_id = get_the_ID();
		$product 	= wc_get_product( $product_id );

		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$type 		= isset( $settings['_preview_type'] ) ? $settings['_preview_type'] : '';
			$product_id = wcd_get_product_id( $type );
			$product 	= wc_get_product( $product_id );
			$the_product = $product;
			global $product;

			if ( is_null( $product ) ) {
				$product = $the_product;
			}
		}

		if ( !$product ) {
			_e( 'This is not a product or an invalid ID is provided.', 'woolementor' );
			return;
		}

		if( wcd_is_live_mode() ) {
			wc_print_notices();
		}
		
		$product_type 	= $product->get_type();
		$button_text  	= $settings['add_to_cart_text'];
		$product_url 	= get_post_meta( $product_id, '_product_url', true );
		?>
		<div class="wl-atc-button-area">
			<?php
			$template = 'simple.php';

			if ( 'external' == $product_type ) {
				$template = 'external.php';
			}

			elseif ( 'grouped' == $product_type ) {
				$post = get_post( $product_id );
				$grouped_products = $product->get_children();
				$template = 'grouped.php';
			}

			elseif ( 'simple' == $product_type || 'subscription' == $product_type ) {
				$template = 'simple.php';
			}

			elseif ( 'variable' == $product_type || 'variable-subscription' == $product_type ) {
				$template = 'variable.php';
			}

			include dirname( __FILE__ ) . "/templates/{$template}";
			?>
		</div>

		<?php 
	}

	private function render_editing_attributes() {
		$this->add_inline_editing_attributes( 'add_to_cart_text', 'basic' );
		$this->add_render_attribute( 'add_to_cart_text', 'class', 'single_add_to_cart_button button al' );
	}
}
