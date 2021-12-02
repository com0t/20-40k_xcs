<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Product_Rating extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';
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
			'section_product_rating_style',
			[
				'label' => __( 'Style', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-product-rating' => 'display:flex;margin: 0;',
					'.wl {{WRAPPER}} .wcd-product-rating .woocommerce-product-rating' => 'margin: 0;',
				],
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'star_color',
			[
				'label' => __( 'Star Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-product-rating .star-rating' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wcd-product-rating .wcd-demo-product-rating dashicons.dashicons-star-filled::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'empty_star_color',
			[
				'label' => __( 'Empty Star Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-product-rating .star-rating::before' => 'color: {{VALUE}}',
					'.wl {{WRAPPER}} .wcd-product-rating .wcd-demo-product-rating dashicons.dashicons-star-empty::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => __( 'Link Color', 'woolementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-product-rating a.woocommerce-review-link' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '.wl {{WRAPPER}} .wcd-product-rating .woocommerce-review-link',
				'fields_options' 	=> [
					'typography' 	=> [ 'default' => 'yes' ],
					'font_size' 	=> [ 'default' => [ 'size' => 16 ] ],
				    'font_family' 	=> [ 'default' => 'Montserrat' ],
				    'font_weight' 	=> [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'star_size',
			[
				'label' => __( 'Star Size', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'em',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 4,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-product-rating .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'space_between',
			[
				'label' => __( 'Space Between', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default' => [
					'unit' => 'em',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 4,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'.wl:not(.rtl) {{WRAPPER}} .wcd-product-rating .star-rating' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.wl.rtl {{WRAPPER}} .wcd-product-rating .star-rating' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'woolementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'woolementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woolementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'woolementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' 	=> 'start',
				'selectors' => [
					'.wl {{WRAPPER}} .wcd-product-rating' => 'justify-content: {{VALUE}}'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! post_type_supports( 'product', 'comments' ) ) {
			return;
		}

		$product_id = get_the_ID();
		$product 	= wc_get_product( $product_id );

		echo "<div class='wcd-product-rating' >";
		if ( empty( $product ) && ( wcd_is_edit_mode() || wcd_is_preview_mode() ) ) {
			$product_id = wcd_get_product_id();
			$product 	= wc_get_product( $product_id );
			$rating_count = $product->get_rating_count();
			if ( $rating_count < 1 ) : 
			$review_count = 5;
			$average      = 5;
			?>
			<div class="wcd-demo-product-rating">
				<?php echo wcd_rating_html( 4 ); // WPCS: XSS ok. ?>
					<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
			</div>
			<?php endif;
		}

		if ( empty( $product ) ) {
			return;
		}
		wc_get_template( 'single-product/rating.php' );
		echo "</div>";
	}
}

