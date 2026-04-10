<?php
namespace SktThemes;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! class_exists( '\SktThemes\SktElementorWidget' ) ) {

	/**
	 * Elementor Widget: SKT Templates Browser
	 *
	 * This widget appears inside the "SKT Templates" category in the
	 * Elementor panel.  When dropped onto a page it renders a live
	 * template-browser with thumbnail grid, search box and one-click
	 * import — all inside the Elementor editor iframe via a custom
	 * panel control rendered by elementor-panel.js.
	 */
	class SktElementorWidget extends Widget_Base {

		public function get_name() {
			return 'skt_templates_browser';
		}

		public function get_title() {
			return __( 'SKT Templates', 'skt-templates' );
		}

		public function get_icon() {
			return 'eicon-library-open';
		}

		public function get_categories() {
			return array( 'skt-templates' );
		}

		public function get_keywords() {
			return array( 'skt', 'template', 'import', 'library', 'layout' );
		}

		protected function register_controls() {
			$this->start_controls_section(
				'skt_templates_section',
				array(
					'label' => __( 'SKT Template Library', 'skt-templates' ),
				)
			);

			$this->add_control(
				'skt_templates_notice',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						'<div class="skt-panel-browser-notice">
							<p>%s</p>
							<button class="elementor-button elementor-button-default skt-open-template-browser">
								%s
							</button>
						</div>',
						esc_html__( 'Launch Stunning Pages with Ready-to-Use SKT Templates', 'skt-templates' ),
						esc_html__( 'Open Template Library', 'skt-templates' )
					),
					'content_classes' => 'skt-panel-notice-wrap',
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			echo '<div class="skt-template-widget-placeholder">';
			echo '<p>' . esc_html__( 'SKT Template use the import button in the panel to replace this with your chosen template.', 'skt-templates' ) . '</p>';
			echo '</div>';
		}
	}
}