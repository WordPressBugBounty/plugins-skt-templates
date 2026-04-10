<?php
namespace SktThemes;

if ( ! class_exists( '\SktThemes\SktElementorPanel' ) ) {

	/**
	 * Registers SKT Templates inside the Elementor editor panel as a
	 * dedicated "SKT Templates" category — just like Layout, Basic, etc.
	 *
	 * How it works:
	 *  1. A custom Elementor Widget is registered.  It has no actual
	 *     drag-and-drop controls — its job is to render a full template-
	 *     browser UI inside the Elementor panel sidebar.
	 *  2. An AJAX endpoint returns the template list as JSON so the panel
	 *     widget can render thumbnails + an Import button without a full
	 *     page reload.
	 *  3. Clicking "Import" inside the panel calls the existing REST
	 *     endpoint (/templates-directory/import_elementor) and then
	 *     redirects the editor to the newly-created page — exactly the
	 *     same flow as the admin-page import.
	 */
	class SktElementorPanel {

		/** @var SktElementorPanel */
		protected static $instance = null;

		protected function init() {
			// Register the widget only when Elementor is ready.
			add_action( 'elementor/widgets/register', array( $this, 'register_widget' ) );
			// Register a dedicated widget category.
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
			// Enqueue panel-specific assets inside the Elementor editor.
			add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_panel_assets' ) );
			// AJAX handler that returns the template list as JSON.
			add_action( 'wp_ajax_skt_get_elementor_templates', array( $this, 'ajax_get_templates' ) );
		}

		// ------------------------------------------------------------------ //
		//  Category
		// ------------------------------------------------------------------ //

		public function register_category( $elements_manager ) {
			$elements_manager->add_category(
				'skt-templates',
				array(
					'title' => __( 'SKT Templates', 'skt-templates' ),
					'icon'  => 'fa fa-plug',
				)
			);
		}

		// ------------------------------------------------------------------ //
		//  Widget
		// ------------------------------------------------------------------ //

		public function register_widget( $widgets_manager ) {
			require_once dirname( __FILE__ ) . '/class-skt-elementor-widget.php';
			$widgets_manager->register( new SktElementorWidget() );
		}

		// ------------------------------------------------------------------ //
		//  Assets
		// ------------------------------------------------------------------ //

		public function enqueue_panel_assets() {
			$base_url = plugin_dir_url( __FILE__ );

			wp_enqueue_style(
				'skt-elementor-panel',
				$base_url . 'css/elementor-panel.css',
				array(),
				'1.0.0'
			);

			wp_enqueue_script(
				'skt-elementor-panel',
				$base_url . 'js/elementor-panel.js',
				array( 'jquery', 'elementor-editor' ),
				'1.0.0',
				true
			);

			wp_localize_script(
				'skt-elementor-panel',
				'sktElementorPanel',
				array(
					'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
					'importUrl'       => rest_url( 'templates-directory/import_elementor' ),
				'importIntoPageUrl' => rest_url( 'templates-directory/import_into_page' ),
					'nonce'      => wp_create_nonce( 'wp_rest' ),
					'ajaxNonce'  => wp_create_nonce( 'skt_elementor_panel' ),
					'strings'    => array(
						'importing'   => __( 'Importing…', 'skt-templates' ),
						'import'      => __( 'Import', 'skt-templates' ),
						'preview'     => __( 'Preview', 'skt-templates' ),
						'noTemplates' => __( 'No templates found.', 'skt-templates' ),
						'loading'     => __( 'Loading templates…', 'skt-templates' ),
						'searchPlaceholder' => __( 'Find Your Template', 'skt-templates' ),
					),
				)
			);
		}

		// ------------------------------------------------------------------ //
		//  AJAX – return template list as JSON
		// ------------------------------------------------------------------ //

		public function ajax_get_templates() {
			check_ajax_referer( 'skt_elementor_panel', 'nonce' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( 'Unauthorized', 403 );
			}

			$directory = PageTemplatesDirectory::instance();
			$templates  = $directory->templates_list();

			$response = array();
			foreach ( $templates as $slug => $data ) {
				$response[] = array(
					'slug'        => $slug,
					'title'       => isset( $data['title'] ) ? $data['title'] : $slug,
					'screenshot'  => isset( $data['screenshot'] ) ? $data['screenshot'] : '',
					'demo_url'    => isset( $data['demo_url'] ) ? $data['demo_url'] : '#',
					'import_file' => isset( $data['import_file'] ) ? $data['import_file'] : '',
					'keywords'    => isset( $data['keywords'] ) ? $data['keywords'] : '',
				);
			}

			wp_send_json_success( $response );
		}

		// ------------------------------------------------------------------ //
		//  Singleton
		// ------------------------------------------------------------------ //

		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
				self::$instance->init();
			}
			return self::$instance;
		}

		public function __clone() {
			_doing_it_wrong( __FUNCTION__, 'Cloning is forbidden.', '1.0.0' );
		}

		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, 'Unserializing is forbidden.', '1.0.0' );
		}
	}
}