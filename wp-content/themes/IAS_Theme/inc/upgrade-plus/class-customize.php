<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class event_Customize {

	/**
	 * Returns the instance.
	 *
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'inc/upgrade-plus/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Event_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Event_Customize_Section_Pro(
				$manager,
				'event',
				array(
					'title'    => esc_html__( 'Event', 'event' ),
					'pro_text' => esc_html__( 'Upgrade To Plus',         'event' ),
					'pro_url'  => 'https://themefreesia.com/plugins/event-plus/',
					'priority' => 1
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'event-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/js/customizer-custom-scripts.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'event-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/js/event-customizer.css' );
	}
}

// Doing this customizer thang!
event_Customize::get_instance();
