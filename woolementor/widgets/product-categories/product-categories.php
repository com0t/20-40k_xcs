<?php
namespace Codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Categories extends Widget_Base {

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

		/**
		 * Product Title
		 */
		$this->start_controls_section(
			'_sectio_cat',
			[
				'label' 		=> __( 'Content', 'woolementor' ),
				'tab' 			=> Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'product_cat_type',
			[
				'label' 		=> __( 'Content Source', 'woolementor' ),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> [
					'current_product'  	=> __( 'Current Product', 'woolementor' ),
					'custom_product'  	=> __( 'Custom Product', 'woolementor' ),
					'custom_cat' 		=> __( 'Custom Text', 'woolementor' ),
				],
				'default' 		=> 'current_product',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
            'product_id',
            [
                'label' 		=> __( 'Product Id', 'woolementor' ),
                'type' 			=> Controls_Manager::NUMBER,
                'default' 		=> 'Product id',
                'condition' 	=> [
                    'product_cat_type' => 'custom_product'
                ],
				'label_block' 	=> true,
            ]
        );

        $this->add_control(
            'cat_label',
            [
                'label' 		=> __( 'Label', 'woolementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> 'Category: ',                
				'label_block' 	=> true,
            ]
        );

        $repeater = new Repeater();

		$repeater->add_control(
			'cat_name', [
				'label' => __( 'Category Name', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New Category' , 'woolementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cat_link',
			[
				'label' 		=> __( 'Link', 'woolementor' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'woolementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'cat_list',
			[
				'label' => __( 'Category List', 'woolementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'cat_name' => __( 'Category #1', 'woolementor' ),
						'cat_link' => [
							'url' => 'https://codexpert.io/codesigner',
							'is_external' => false,
							'nofollow' => false,
						],
					],
					[
						'cat_name' => __( 'Category #2', 'woolementor' ),
						'cat_link' => [
							'url' => 'https://codexpert.io/codesigner',
							'is_external' => false,
							'nofollow' => false,
						],
					],
				],
                'condition' 	=> [
                    'product_cat_type' => 'custom_cat'
                ],
				'title_field' => '{{{ cat_name }}}',
			]
		);


        $this->add_responsive_control(
            'align',
            [
                'label' 		=> __( 'Alignment', 'woolementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'options' => [
					'left' => [
						'title' => __( 'Left', 'woolementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'woolementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
                'toggle' 		=> true,
                'default' 		=> 'left',
				'separator' 	=> 'before',
                'selectors' 	=> [
                    '.wl {{WRAPPER}} .wl-product-categories' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        /**
		 * Product sku label Style
		 */
		$this->start_controls_section(
			'section_style_cat_lable',
			[
				'label' => __( 'Label', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cat_label_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-product-categories .cat-label',
			]
		);

		$this->add_control(
			'cat_label_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'separator' => 'before',
				'default' => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'cat_lable_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-product-categories .cat-label',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
			'cat_label_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'cat_lable_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'cat_lable_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .cat-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		/**
		 * Product categories Style
		 */
		$this->start_controls_section(
			'section_style_cat',
			[
				'label' => __( 'Categories', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cat_default_style',
			[
				'label' => __( 'View', 'woolementor' ),
				'type' => Controls_Manager::HIDDEN,
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .posted_in a' => 'color: #E9345F;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cat_background',
				'label' => __( 'Background', 'woolementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a',
			]
		);

		$this->add_control(
			'cat_color',
			[
				'label' => __( 'Text Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'separator' => 'before',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'cat_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
			'cat_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'after',
			]
		);

		$this->add_responsive_control(
			'cat_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'cat_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-product-categories .categories_wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'cat_label', 'basic' );
		$this->add_render_attribute( 'cat_label', 'class', 'cat-label' );
		$product_cat_type = $settings['product_cat_type'];
        ?>

        <div class="wl-product-categories">

        	<?php do_action( 'wcd_product_cat_start' );

        	if( $product_cat_type == 'current_product' || $product_cat_type == 'custom_product' ): 
    			if( $product_cat_type == 'current_product' ) {
    				$product = wc_get_product( get_the_ID() );
    				if ( wcd_is_edit_mode() || wcd_is_preview_mode() ) {
    					$product_id = wcd_get_product_id();
    					$product = wc_get_product( $product_id );
    				}
    			}

    			if( $product_cat_type == 'custom_product' ) {
    				$product_id = sanitize_number( $settings['product_id'] );
    				$product 	= $product_id != '' ? wc_get_product( $product_id ) : '';

    				if( $product_id == '' || !$product ) {
    					echo "Input valid Product ID"; return;
    				}
    			}
        		?>

	        	<span class="categories_wrapper">
		        	<?php 
		        	if ( $product ) {
		        		echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '<span '. $this->get_render_attribute_string( 'cat_label' ) .'>'.esc_html( $settings['cat_label'] ).'</span>', '<span '. $this->get_render_attribute_string( 'cat_label' ) .'>'.esc_html( $settings['cat_label'] ).'</span>', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); 
		        	}
		        	?>
		        </span>

	        <?php elseif( $product_cat_type == 'custom_cat' ): ?>
	        	<span class="categories_wrapper">

	        		<?php 
        			printf( '<span %s>%s</span>',
						$this->get_render_attribute_string( 'cat_label' ),
						esc_html( $settings['cat_label'] )
					);
        			?>

	        		<span class="cat-items">
	        			<?php 
	        			$last_item = end( $settings['cat_list'] );
	        			foreach ($settings['cat_list'] as $key => $category) {
	        				$separator 	= isset( $category['_id'] ) && $category['_id'] != $last_item['_id'] ? ', ' : '';
	        				$target 	= isset( $category['is_external'] ) && $category['is_external'] ? ' target="_blank"' : '';
    						$nofollow 	= isset( $category['nofollow'] ) && $category['nofollow'] ? ' rel="nofollow"' : '';
	        				echo '<a href="'. $category['cat_link']['url'] .'" '. $target . $nofollow .' class="cat-item">'.  $category['cat_name'] . $separator .'</a>';
	        			}
	        			 ?>
	        		</span>
	        	</span>

	        <?php endif;

	        do_action( 'wcd_product_cat_end' ); ?>

        </div>

        <?php
	}
}

