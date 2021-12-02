<?php
namespace Codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Ask_For_Price extends Widget_Base {

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

	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'input_label', [
				'label' 	=> __( 'Input Label', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> __( 'New Section' , 'woolementor-pro' ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'hide_label',
			[
				'label'         => __( 'Hide Label', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'yes', 'woolementor-pro' ),
				'label_off'     => __( 'no', 'woolementor-pro' ),
				'return_value'  => true,
				'default'       => false,
			]
		);

		// $repeater->add_control(
		// 	'input_class', [
		// 		'label' 	=> __( 'Class Name', 'woolementor-pro' ),
		// 		'type' 		=> Controls_Manager::SELECT,
		// 		'default' 	=> 'form-row-wide',
		// 		'separator' 	=> 'before',
		// 		'options' 	=> [
		// 			'form-row-first' 	=> 'form-row-first',
		// 			'form-row-last' 	=> 'form-row-last',
		// 			'form-row-wide' 	=> 'form-row-wide',
		// 		],
		// 	]
		// );

		$repeater->add_control(
			'input_type', [
				'label' 	=> __( 'Input Type', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SELECT2,
				'default' 	=> 'text',
				'options' 	=> [
					'textarea'			=> __( 'Textarea', 'woolementor-pro' ),
					'checkbox'			=> __( 'Checkbox', 'woolementor-pro' ),
					'text'				=> __( 'Text', 'woolementor-pro' ),
					'password'			=> __( 'Password', 'woolementor-pro' ),
					'date'				=> __( 'Date', 'woolementor-pro' ),
					'number'			=> __( 'Number', 'woolementor-pro' ),
					'hidden'			=> __( 'Hidden', 'woolementor-pro' ),
					'email'				=> __( 'Email', 'woolementor-pro' ),
					'url'				=> __( 'Url', 'woolementor-pro' ),
					'tel'				=> __( 'Tel', 'woolementor-pro' ),
					'select'			=> __( 'Select', 'woolementor-pro' ),
					'radio'				=> __( 'Radio', 'woolementor-pro' ),
				],
			]
		);

		$repeater->add_control(
			'input_options', [
				'label' 	=> __( 'Options', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::TEXTAREA,
				'default' 	=> implode( PHP_EOL, [ __( 'Option 1', 'woolementor-pro' ), __( 'Option 2', 'woolementor-pro' ), __( 'Option 3', 'woolementor-pro' ) ] ),
				'label_block' 	=> true,
				'conditions' 	=> [
					'relation' 	=> 'or',
					'terms' 	=> [
						[
							'name' 		=> 'input_type',
							'operator' 	=> '==',
							'value' 	=> 'select',
						],
						[
							'name' 		=> 'input_type',
							'operator' 	=> '==',
							'value' 	=> 'radio',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'input_name', [
				'label' 		=> __( 'Field Name', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> 'name_' . rand( 111, 999 ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'input_placeholder', [
				'label' 		=> __( 'Placeholder', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Placeholder' , 'woolementor-pro' ),
				'label_block' 	=> true,
			]
		);

		$repeater->add_control(
			'input_required',
			[
				'label'         => __( 'Required', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'yes', 'woolementor-pro' ),
				'label_off'     => __( 'no', 'woolementor-pro' ),
				'return_value'  => true,
				'default'       => false,
			]
		);

		$this->add_control(
			'input_field_set',
			[
				'label' => __( 'Form Fields', 'woolementor-pro' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'input_label' 	=> __( 'First Name', 'woolementor-pro' ),
						// 'input_class' 	=> 'form-row-first',
						'input_type' 	=> 'text',
						'input_name' 	=> 'first_name',
						'input_placeholder' => 'First Name',
					],
					[
						'input_label' 	=> __( 'Last Name', 'woolementor-pro' ),
						// 'input_class' 	=> 'form-row-last',
						'input_type' 	=> 'text',
						'input_name' 	=> 'last_name',
						'input_placeholder' => 'Last Name',
					],
					[
						'input_label' 	=> __( 'Email', 'woolementor-pro' ),
						// 'input_class' 	=> 'form-row-last',
						'input_type' 	=> 'email',
						'input_name' 	=> 'email',
						'input_placeholder' => 'example@mail.com',
					],
				],
				'title_field' => '{{{ input_label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_button_content',
			[
				'label' => __( 'Button', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'section_form_button_text',
			[
				'label' 		=> __( 'Button Text', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Submit', 'woolementor-pro' ),
				'placeholder' 	=> __( 'Type your text here', 'woolementor-pro' ),
			]
		);


		$this->add_control(
			'section_form_button_align',
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
				],
				'default' => 'left',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-footer' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_settings',
			[
				'label' => __( 'Configuration', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'important_note',
			[
				'label' => __( 'Important Note', 'plugin-name' ),
				'type' 	=> Controls_Manager::RAW_HTML,
				'raw' 	=> sprintf( __( 'You can use any data from submitted form. use %s where you want to use submitted form data. %s will be replaced with actual form data', 'woolementor-pro' ), "<code>%%your_field_name%%</code>", "<code>%%your_field_name%%</code>" ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-success',
			]
		);

		$this->add_control(
			'admin_mail_subject',
			[
				'label'         => __( 'Admin Mail Subject', 'woolementor-pro' ),
				'type'          => Controls_Manager::TEXT,
				'label_block'	=> true,
				'default'		=> __( 'New response mail', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'enable_response_mail',
			[
				'label'         => __( 'Enable auto response mail', 'woolementor-pro' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'yes', 'woolementor-pro' ),
				'label_off'     => __( 'no', 'woolementor-pro' ),
				'return_value'  => 'yes',
				'default'       => false,
				'separator' 	=> 'before'
			]
		);

		$this->add_control(
			'customer_email_name',
			[
				'label'         => __( 'Customer Email Field name', 'woolementor-pro' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => 'email',
				'label_block'	=> true,
				'condition' 	=> [
					'enable_response_mail' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'email_subject',
			[
				'label'         => __( 'Email Subject', 'woolementor-pro' ),
				'type'          => Controls_Manager::TEXT,
				'label_block'	=> true,
				'default'		=> __( 'Email Subject', 'woolementor-pro' ),
				'description'	=> __( 'Thank you! We reach you soon', 'woolementor-pro' ),
				'condition' 	=> [
					'enable_response_mail' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'email_body',
			[
				'label'         => __( 'Email Body', 'woolementor-pro' ),
				'type'          => Controls_Manager::WYSIWYG,
				'label_block'	=> true,
				'default'		=> __( 'Thank you! We reach you soon', 'woolementor-pro' ),
				'condition' 	=> [
					'enable_response_mail' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'response_type_heading',
			[
				'label'         => __( 'On site action after submission', 'woolementor-pro' ),
				'type'          => Controls_Manager::HEADING,
				'separator' 	=> 'before'
			]
		);

		$this->add_control(
			'success_response_type',
			[
				'label'         => __( 'Response Type', 'woolementor-pro' ),
				'type'          => Controls_Manager::SELECT,
				'label_block'	=> true,
				'options'		=> [
					'message' 	=> __( 'Message', 'woolementor-pro' ),
					'redirect' 	=> __( 'Redirect', 'woolementor-pro' ),
					'both' 		=> __( 'Both', 'woolementor-pro' ),
				],
			]
		);

		$this->add_control(
			'success_response_type_message',
			[
				'label'         => __( 'Response Message', 'woolementor-pro' ),
				'type'          => Controls_Manager::WYSIWYG,
				'label_block'	=> true,
				'default'		=> __( 'Thank you! We reach you soon', 'woolementor-pro' ),
				'conditions' 	=> [
					'relation' 	=> 'or',
					'terms' 	=> [
						[
							'name' 		=> 'success_response_type',
							'operator' 	=> '==',
							'value' 	=> 'message',
						],
						[
							'name' 		=> 'success_response_type',
							'operator' 	=> '==',
							'value' 	=> 'both',
						],
					],
				],
			]
		);

		$this->add_control(
			'response_redir_url',
			[
				'label' 		=> __( 'Link', 'plugin-domain' ),
				'type' 			=> Controls_Manager::URL,
				'placeholder' 	=> __( 'https://your-link.com', 'plugin-domain' ),
				// 'show_external' => true,
				'default' 		=> [
					'url' 			=> '',
					'is_external' 	=> true,
					'nofollow' 		=> true,
				],
				'conditions' 	=> [
					'relation' 	=> 'or',
					'terms' 	=> [
						[
							'name' 		=> 'success_response_type',
							'operator' 	=> '==',
							'value' 	=> 'redirect',
						],
						[
							'name' 		=> 'success_response_type',
							'operator' 	=> '==',
							'value' 	=> 'both',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_style',
			[
				'label' => __( 'Container', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'wl_afp_form_bg',
				'label' 	=> __( 'Background', 'woolementor-pro' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '.wl {{WRAPPER}} .wl-afp-form-container',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'wl_afp_form_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-afp-form-container',
				'separator'	=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'wl_afp_form_section_gap',
			[
				'label' 	=> __( 'Gap Between Inputs', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range' 	=> [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1000,
						'step' 	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-inputs' 			=> 'margin-top: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-inputs' 			=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-radio-inputs' 	=> 'margin-top: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-radio-inputs' 	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-checkbox-inputs' 	=> 'margin-top: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-checkbox-inputs' 	=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-inputs:first-child' 				=> 'margin-top: 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-radio-inputs:first-child' 		=> 'margin-top: 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-checkbox-inputs:first-child' 		=> 'margin-top: 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-inputs:nth-last-child(2)' 		=> 'margin-bottom: 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-radio-inputs:nth-last-child(2)' 	=> 'margin-bottom: 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-checkbox-inputs:nth-last-child(2)'=> 'margin-bottom: 0{{UNIT}};'
				],
				'separator'		=> 'before',
			]
		);

		$this->add_control(
			'wl_afp_form_section_option_gap',
			[
				'label' 	=> __( 'Gap Between OPtions', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px' ],
				'range' 	=> [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1000,
						'step' 	=> 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-input.radio' 			=> 'margin-top: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-input.radio' 			=> 'margin-bottom: {{SIZE}}{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-options:nth-child(1)' => 'margin-top: 0{{UNIT}};',
					'.wl {{WRAPPER}} .wl-afp-form-options:last-child' 	=> 'margin-bottom: 0{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_label_style',
			[
				'label' => __( 'Labels', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default' => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-label,
					 .wl {{WRAPPER}} .wl-afp-form-checkbox,
					 .wl {{WRAPPER}} .wl-afp-form-options' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_styling_heading',
			[
				'label' 	=> __( 'Label Styling', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_form_label_typography',
				'label' => __( 'Label Typography', 'woolementor-pro' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wl-afp-form-label',
			]
		);

		$this->add_responsive_control(
			'wl_afp_label_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wl_afp_label_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'option_styling_heading',
			[
				'label' 	=> __( 'Options Styling', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::HEADING,
				'separator'		=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_form_option_typography',
				'label' => __( 'Option Typography', 'woolementor-pro' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wl-afp-form-options, .wl {{WRAPPER}} .wl-afp-form-checkbox',
			]
		);

		$this->add_responsive_control(
			'wl_afp_option_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-options,
					 .wl {{WRAPPER}} .wl-afp-form-checkbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wl_afp_option_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-options,
					 .wl {{WRAPPER}} .wl-afp-form-checkbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_input_style',
			[
				'label' => __( 'Inputs', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default' => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wl_afp_form_input_bg',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-afp-form-input',
				'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'wl_afp_form_input_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-afp-form-input',
				'separator'	=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_input_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wl_afp_form_input_width',
			[
				'label' 	=> __( 'Input Width', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%' ],
				'range' 	=> [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1000,
						'step' 	=> 1,
					],
					'%' => [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-input' => 'width: {{SIZE}}{{UNIT}};'
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_input_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_input_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_button_style',
			[
				'label' => __( 'Button', 'woolementor-pro' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_form_btn_typography',
				'label' => __( 'Typography', 'woolementor-pro' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '.wl {{WRAPPER}} .wl-afp-form-submit-btn',
			]
		);

		$this->add_control(
			'wl_afp_form_button_width',
			[
				'label' 	=> __( 'Button Width', 'woolementor-pro' ),
				'type' 		=> Controls_Manager::SLIDER,
				'size_units'=> [ 'px', '%' ],
				'range' 	=> [
					'px' => [
						'min' 	=> 0,
						'max' 	=> 1000,
						'step' 	=> 1,
					],
					'%' => [
						'min' 	=> 0,
						'max' 	=> 100,
						'step' 	=> 1,
					],
				],
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn' => 'width: {{SIZE}}{{UNIT}};'
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_button_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_button_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'wl_afp_form_button_style_tab',
			[
				'separator'	=> 'before',
			]
		);

		$this->start_controls_tab(
			'wl_afp_form_button_style_normal_tab',
			[
				'label' => __( 'Normal', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'section_form_btn_color',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default' => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wl_afp_form_button_bg',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-afp-form-submit-btn',
				'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'wl_afp_form_button_border',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-afp-form-submit-btn',
				'separator'	=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_button_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'wl_afp_form_button_style_hover_tab',
			[
				'label' => __( 'Hover', 'woolementor-pro' ),
			]
		);

		$this->add_control(
			'section_form_btn_color_hover',
			[
				'label' => __( 'Text Color', 'woolementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'default' => '#000',
				'selectors' => [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn:hover' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wl_afp_form_button_bg_hover',
				'label' => __( 'Background', 'woolementor-pro' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '.wl {{WRAPPER}} .wl-afp-form-submit-btn:hover',
				'separator'	=> 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'wl_afp_form_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor-pro' ),
				'selector' 	=> '.wl {{WRAPPER}} .wl-afp-form-submit-btn:hover',
				'separator'	=> 'before',
			]
		);

		$this->add_responsive_control(
			'wl_afp_form_button_border_radius_hover',
			[
				'label' 		=> __( 'Border Radius', 'woolementor-pro' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'.wl {{WRAPPER}} .wl-afp-form-submit-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
            echo "<img src='" . plugins_url( '/assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }
}