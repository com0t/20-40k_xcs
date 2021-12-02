<?php
namespace Codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Product_Gallery extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = wcd_get_widget_id( __CLASS__ );
	    $this->widget = wcd_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", "fancybox" ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", "fancybox" ];
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
			'payment_section_title',
			[
				'label' => __( 'Sale', 'woolementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'sale_flash',
			[
				'label' => __( 'Sale Flash', 'woolementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'woolementor' ),
				'label_off' => __( 'Hide', 'woolementor' ),
				'render_type' => 'template',
				'return_value' => 'yes',
				'default' => 'yes',
				'prefix_class' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_gallery_style',
			[
				'label' => __( 'Thumbnail', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// start default style
		$this->add_control(
			'product_gallery_default_styles',
			[
				'label' 	=> __( 'Display', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HIDDEN,
				'selectors' => [
					'.wl {{WRAPPER}} .wl-product-gallery .woocommerce-product-gallery' => 'width: 100%;',
				],
				'default' => 'traditional',
			]
		);
		// end default css

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '.wl {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
				.wl {{WRAPPER}} .flex-viewport, .wl {{WRAPPER}} .flex-control-thumbs img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.wl {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
					.wl {{WRAPPER}} .flex-viewport' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label' => __( 'Spacing', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .flex-viewport:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_thumbs_style',
			[
				'label' => __( 'Thumbnails', 'woolementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'thumbs_border',
				'selector' => '.wl {{WRAPPER}} .flex-control-thumbs img',
			]
		);

		$this->add_responsive_control(
			'thumbs_border_radius',
			[
				'label' => __( 'Border Radius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.wl {{WRAPPER}} .flex-control-thumbs img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'spacing_thumbs',
			[
				'label' => __( 'Spacing', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'.wl {{WRAPPER}} .flex-control-thumbs li' => 'padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: {{SIZE}}{{UNIT}}',
					'.wl {{WRAPPER}} .flex-control-thumbs' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2)',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		global $product;

		$product = wc_get_product();

		if ( empty( $product ) ) {
			return;
		}

		wp_enqueue_style( 'woocommerce-general' );

		echo '<div class="wl-product-gallery product">';

		if ( 'yes' === $settings['sale_flash'] ) {
			wc_get_template( 'loop/sale-flash.php' );
		}

		wc_get_template( 'single-product/product-image.php' );

		echo '</div>';

        /**
         * Load Script
         */
        $this->render_script();
	}

	protected function render_script() {
		if ( wp_doing_ajax() ) {
			?>
			<script>
				jQuery( '.woocommerce-product-gallery' ).each( function() {
					jQuery( this ).wc_product_gallery();
				} );
			</script>
			<?php
		}
    }
}