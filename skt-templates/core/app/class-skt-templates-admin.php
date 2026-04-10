<?php
/**
 * The admin-specific functionality of the plugin.
 * @package    Skt_Templates
 * @subpackage Skt_Templates/app
 */

class Skt_Templates_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	public function enqueue_styles() {
		$screen = get_current_screen();
		if ( empty( $screen ) ) {
			return;
		}
		if ( in_array( $screen->id, array( 'toplevel_page_skt_template_about' ), true ) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/skt-templates-admin.css', array(), $this->version, 'all' );
		}
		if ( in_array( $screen->id, array( 'toplevel_page_skt_template_import' ), true ) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/skt-templates-admin.css', array(), $this->version, 'all' );
		}
		do_action( 'sktb_admin_enqueue_styles' );
	}

	public function enqueue_scripts() {
		$screen = get_current_screen();
		if ( empty( $screen ) ) {
			return;
		}
		do_action( 'sktb_admin_enqueue_scripts' );
	}

	public function menu_pages() {
		add_menu_page(
			__( 'SKT Templates', 'skt-templates' ),
			__( 'SKT Templates', 'skt-templates' ),
			'manage_options',
			'skt_template_about',
			array( $this, 'page_modules_render' ),
			SKTB_URL . 'images/skt-template-icon.svg',
			'75'
		);
		add_submenu_page( 'skt_template_about', __( 'SKT Templates General Options', 'skt-templates' ), __( 'About Templates', 'skt-templates' ), 'manage_options', 'skt_template_about' );

		add_menu_page(
			__( 'SKT Templates', 'skt-templates' ),
			__( 'SKT Templates', 'skt-templates' ),
			'manage_options',
			'skt_template_import',
			array( $this, 'page_import_tempate' ),
			'99'
		);
		add_submenu_page( 'skt_template_import', __( 'SKT Templates General Options', 'skt-templates' ), __( 'Import Templates', 'skt-templates' ), 'manage_options', 'skt_template_import' );
	}

	/**
	 * Welcome banner shown at the top of the SKT Templates admin page.
	 * Replaces the old plain text notice entirely.
	 * Dismissed permanently per-user via AJAX.
	 */
	public function visit_dashboard_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$user_id = get_current_user_id();

		// Use ONE meta key for everything if dismissed, never show again until re-activation.
		if ( get_user_meta( $user_id, 'skt_welcome_dismissed', true ) ) {
			return;
		}

		// Only show the full banner on the SKT template directory page.
		$page = isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '';
		if ( $page !== 'skt_template_directory' ) {
			// On every OTHER admin page show a compact one-line dismissible notice instead.
			$dir_url = admin_url( 'admin.php?page=skt_template_directory' );
			?>
			<div class="notice notice-info skt-compact-notice" style="display:flex;align-items:center;justify-content:space-between;padding:10px 16px;gap:12px;">
				<p style="margin:0;font-size:13px;">
					<strong>SKT Templates</strong> <?php echo sprintf(
						esc_html__( 'Import 200+ free website templates directly into Elementor. %s', 'skt-templates' ),
						'<a href="' . esc_url( $dir_url ) . '">' . esc_html__( 'Browse Templates', 'skt-templates' ) . '</a>'
					); ?>
				</p>
				<button type="button" class="skt-notice-dismiss" style="background:none;border:none;cursor:pointer;font-size:18px;color:#888;line-height:1;padding:0 4px;" aria-label="Dismiss">&#x2715;</button>
			</div>
			<script>
			(function($){
				$('.skt-notice-dismiss').on('click', function(){
					$(this).closest('.skt-compact-notice').fadeOut(300);
					$.post(ajaxurl, { action: 'skt_dismiss_welcome', nonce: '<?php echo esc_js( wp_create_nonce('skt_dismiss_welcome') ); ?>' });
				});
			})(jQuery);
			</script>
			<?php
			return;
		}

		// Full welcome banner on the template directory page
		$plugin_url = defined('SKTB_URL') ? SKTB_URL : plugin_dir_url( dirname( dirname( __FILE__ ) ) );
		$nonce      = wp_create_nonce( 'skt_dismiss_welcome' );
		$ajax_url   = admin_url( 'admin-ajax.php' );
		$dir_url    = admin_url( 'admin.php?page=skt_template_directory' );
		$gb_url     = admin_url( 'admin.php?page=skt_template_gutenberg' );
		?>

<style>
#skt-welcome-wrap{position:relative;margin:20px 20px 28px 0;border-radius:14px;overflow:hidden;font-family:-apple-system,'Segoe UI',system-ui,sans-serif;box-shadow:0 6px 32px rgba(1,150,214,.14),0 1px 4px rgba(0,0,0,.06);background:#fff;border:1px solid #d8edf8}
#skt-welcome-wrap::before{content:'';display:block;height:5px;background:linear-gradient(90deg,#0196d6,#f98315,#0196d6,#34a85e,#0196d6);background-size:300% 100%;animation:sktstripe 4s linear infinite}
@keyframes sktstripe{0%{background-position:0 50%}100%{background-position:300% 50%}}
#skt-welcome-dismiss{position:absolute;top:12px;right:14px;background:rgba(0,0,0,.07);border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;font-size:16px;line-height:28px;text-align:center;color:#666;z-index:10;transition:background .2s,color .2s}
#skt-welcome-dismiss:hover{background:#e74c3c;color:#fff}
.skt-wb-inner{display:flex;align-items:stretch}
.skt-wb-graphic{flex:0 0 280px;background:linear-gradient(145deg,#0a1628 0%,#0d2444 55%,#0a3060 100%);display:flex;align-items:center;justify-content:center;padding:32px 24px;position:relative;overflow:hidden}
.skt-wb-graphic::after{content:'';position:absolute;bottom:-50px;right:-50px;width:160px;height:160px;background:radial-gradient(circle,rgba(1,150,214,.2) 0%,transparent 70%);border-radius:50%}
.skt-wb-content{flex:1;padding:30px 38px 28px 34px}
.skt-wb-badge{display:inline-flex;align-items:center;gap:5px;background:#e8f7ff;color:#0177aa;border:1px solid #c0e4f8;border-radius:20px;padding:3px 13px;font-size:11px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;margin-bottom:11px}
.skt-wb-headline{font-size:18px;font-weight:800;color:#0d1f3c;line-height:1.25;margin:0 0 9px;letter-spacing:-.3px}
.skt-wb-headline em{color:#0196d6;font-style:normal;position:relative}
.skt-wb-headline em::after{content:'';position:absolute;bottom:1px;left:0;width:100%;height:3px;background:linear-gradient(90deg,#0196d6,#f98315);border-radius:2px;opacity:.45}
.skt-wb-lead{font-size:13.5px;color:#4a5568;line-height:1.65;margin:0 0 20px;}
.skt-wb-feats{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:22px}
.skt-wb-feat{display:flex;align-items:center;gap:6px;background:#f7fafe;border:1px solid #ddeef8;border-radius:8px;padding:5px 12px;font-size:12px;color:#2d3748;font-weight:500}
.skt-wb-feat-icon{width:20px;height:20px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
.fi-blue{background:#e3f3fd}.fi-orange{background:#fff0e0}.fi-green{background:#e3f9ec}.fi-purple{background:#f0eaff}
.skt-wb-actions{display:flex;align-items:center;gap:11px;flex-wrap:wrap}
.skt-wb-btn-p{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#0196d6,#0177aa);color:#fff!important;text-decoration:none!important;padding:10px 20px;border-radius:7px;font-size:13px;font-weight:700;box-shadow:0 3px 12px rgba(1,150,214,.3);transition:transform .15s,box-shadow .15s;border:none;cursor:pointer}
.skt-wb-btn-p:hover{transform:translateY(-1px);box-shadow:0 5px 18px rgba(1,150,214,.4);color:#fff!important}
.skt-wb-btn-s{display:inline-flex;align-items:center;gap:5px;color:#0196d6!important;text-decoration:none!important;font-size:12px;font-weight:600;padding:9px 14px;border-radius:7px;border:1px solid #b8dff5;transition:background .15s,border-color .15s}
.skt-wb-btn-s:hover{background:#f0f9ff;border-color:#0196d6;color:#0196d6!important}
.skt-wb-proof{display:flex;align-items:center;gap:14px;margin-top:18px;padding-top:16px;border-top:1px solid #eef3f8;flex-wrap:wrap}
.skt-wb-proof-item{display:flex;align-items:center;gap:5px;font-size:11px;color:#718096}
.skt-wb-proof-item strong{color:#2d3748;font-weight:700}
.skt-wb-proof-dot{width:3px;height:3px;border-radius:50%;background:#cbd5e0}
@media(max-width:820px){.skt-wb-inner{flex-direction:column}.skt-wb-graphic{flex:none;width:100%;min-height:160px;padding:24px}.skt-wb-content{padding:24px 20px}.skt-wb-headline{font-size:19px}}
</style>

<div id="skt-welcome-wrap">
	<button id="skt-welcome-dismiss" title="<?php esc_attr_e('Dismiss','skt-templates'); ?>">&#x2715;</button>
	<div class="skt-wb-inner">

		<!-- Animated SVG panel -->
		<div class="skt-wb-graphic">
			<svg viewBox="0 0 190 190" fill="none" xmlns="http://www.w3.org/2000/svg" width="180" height="180" style="position:relative;z-index:1">
				<defs>
					<linearGradient id="sktg1" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#0196d6"/><stop offset="100%" stop-color="#34a85e"/></linearGradient>
					<linearGradient id="sktg2" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#f98315"/><stop offset="100%" stop-color="#e74c3c"/></linearGradient>
				</defs>
				<!-- Orbiting rings -->
				<circle cx="95" cy="95" r="80" stroke="rgba(1,150,214,0.14)" stroke-width="1" stroke-dasharray="6 4">
					<animateTransform attributeName="transform" type="rotate" from="0 95 95" to="360 95 95" dur="20s" repeatCount="indefinite"/>
				</circle>
				<circle cx="95" cy="95" r="58" stroke="rgba(249,131,21,0.11)" stroke-width="1" stroke-dasharray="4 6">
					<animateTransform attributeName="transform" type="rotate" from="360 95 95" to="0 95 95" dur="14s" repeatCount="indefinite"/>
				</circle>
				<!-- Browser chrome -->
				<rect x="28" y="40" width="134" height="96" rx="7" fill="#1a2f50"/>
				<rect x="28" y="40" width="134" height="18" rx="7" fill="#0d2040"/>
				<rect x="28" y="48" width="134" height="10" fill="#0d2040"/>
				<circle cx="40" cy="49" r="3" fill="#e74c3c" opacity=".9"/>
				<circle cx="50" cy="49" r="3" fill="#f98315" opacity=".9"/>
				<circle cx="60" cy="49" r="3" fill="#34a85e" opacity=".9"/>
				<rect x="70" y="44" width="70" height="10" rx="5" fill="rgba(255,255,255,0.08)"/>
				<!-- Animated content blocks -->
				<rect x="38" y="66" width="114" height="26" rx="4" fill="url(#sktg1)" opacity="0">
					<animate attributeName="opacity" values="0;.9;.9" keyTimes="0;.2;1" dur="3s" repeatCount="indefinite" begin=".3s"/>
				</rect>
				<rect x="50" y="73" width="52" height="5" rx="2.5" fill="rgba(255,255,255,0.9)" opacity="0">
					<animate attributeName="opacity" values="0;.9;.9" keyTimes="0;.3;1" dur="3s" repeatCount="indefinite" begin=".5s"/>
				</rect>
				<rect x="56" y="82" width="38" height="4" rx="2" fill="rgba(255,255,255,0.55)" opacity="0">
					<animate attributeName="opacity" values="0;.7;.7" keyTimes="0;.35;1" dur="3s" repeatCount="indefinite" begin=".7s"/>
				</rect>
				<!-- Cards row -->
				<rect x="38" y="100" width="32" height="22" rx="4" fill="rgba(1,150,214,0.45)" opacity="0">
					<animate attributeName="opacity" values="0;.85;.85" keyTimes="0;.45;1" dur="3s" repeatCount="indefinite" begin=".9s"/>
				</rect>
				<rect x="76" y="100" width="32" height="22" rx="4" fill="rgba(249,131,21,0.55)" opacity="0">
					<animate attributeName="opacity" values="0;.85;.85" keyTimes="0;.5;1" dur="3s" repeatCount="indefinite" begin="1.1s"/>
				</rect>
				<rect x="114" y="100" width="32" height="22" rx="4" fill="rgba(52,168,94,0.5)" opacity="0">
					<animate attributeName="opacity" values="0;.85;.85" keyTimes="0;.55;1" dur="3s" repeatCount="indefinite" begin="1.3s"/>
				</rect>
				<!-- Footer -->
				<rect x="38" y="128" width="114" height="7" rx="3" fill="rgba(255,255,255,0.07)" opacity="0">
					<animate attributeName="opacity" values="0;.5;.5" keyTimes="0;.6;1" dur="3s" repeatCount="indefinite" begin="1.5s"/>
				</rect>
				<!-- Bouncing Import badge -->
				<rect x="108" y="29" width="48" height="20" rx="10" fill="url(#sktg2)">
					<animate attributeName="y" values="29;23;29" dur="2.4s" repeatCount="indefinite"/>
				</rect>
				<text x="116" y="43" font-size="9" fill="white" font-family="sans-serif" font-weight="700">Import</text>
				<!-- Sparkles -->
				<circle cx="25" cy="86" r="2.5" fill="#0196d6" opacity=".7"><animate attributeName="opacity" values=".7;.1;.7" dur="2s" repeatCount="indefinite"/></circle>
				<circle cx="168" cy="114" r="2" fill="#f98315" opacity=".8"><animate attributeName="opacity" values=".8;.2;.8" dur="2.8s" repeatCount="indefinite" begin=".5s"/></circle>
				<circle cx="148" cy="34" r="1.8" fill="#34a85e" opacity=".7"><animate attributeName="opacity" values=".7;.15;.7" dur="1.8s" repeatCount="indefinite" begin="1s"/></circle>
			</svg>
		</div>

		<!-- Text content -->
		<div class="skt-wb-content">
    <div class="skt-wb-badge"><?php esc_html_e("Plugin Activated - You're Ready!", 'skt-templates'); ?></div>
    <h2 class="skt-wb-headline">
        <?php esc_html_e('Now Import & Use Templates Directly Inside the Elementor Editor —', 'skt-templates'); ?> <em><?php esc_html_e('No Page Switching Needed!', 'skt-templates'); ?></em>
    </h2>
    <p class="skt-wb-lead">
        <?php esc_html_e('To import a template, you had to leave the Elementor editor and go to a separate page. Now, we have added a new feature that allows you to import and use templates directly from within the Elementor editor itself, without switching to any other page.', 'skt-templates'); ?>
    </p>
    <p class="skt-wb-lead" style="color:#2e7d32;">
        <?php esc_html_e('Open any page in Elementor you will see the "SKT Templates" button at the top left of the editor. Click it to instantly browse and import 200+ free templates without leaving the editor or switching any page.', 'skt-templates'); ?>
    </p>    
    <ul class="skt-wb-list">
    <li style="background:#e8f5e9; border-left: 4px solid #2e7d32; padding: 10px 15px; margin-bottom: 8px; border-radius: 4px; font-weight: 600; color: #2e7d32;">
        <?php esc_html_e('New: Import templates directly inside the Elementor editor (no page switching)', 'skt-templates'); ?>
    </li>
    <li style="background:#e3f2fd; border-left: 4px solid #1565c0; padding: 10px 15px; margin-bottom: 8px; border-radius: 4px; font-weight: 600; color: #1565c0;">
        <?php esc_html_e('Previous: The separate page import functionality is still available as before', 'skt-templates'); ?>
    </li>
</ul>
</div>
	</div>
</div>

<script>
(function($){
	var $wrap = $('#skt-welcome-wrap');
	// Entrance animation
	$wrap.css({opacity:0,transform:'translateY(12px)',transition:'opacity .45s ease,transform .45s ease'});
	setTimeout(function(){ $wrap.css({opacity:1,transform:'translateY(0)'}); }, 100);

	// Dismiss
	$('#skt-welcome-dismiss').on('click', function(){
		$wrap.css({transition:'opacity .35s,transform .35s',opacity:0,transform:'translateY(-8px)'});
		setTimeout(function(){ $wrap.remove(); }, 380);
		$.post('<?php echo esc_js($ajax_url); ?>', {
			action : 'skt_dismiss_welcome',
			nonce  : '<?php echo esc_js($nonce); ?>'
		});
	});
})(jQuery);
</script>
		<?php
	}

	/**
	 * Dismiss handler kept for backward compat (old URL-based dismiss).
	 */
	public function visit_dashboard_notice_dismiss() {
		// Legacy URL-based dismiss now handled by AJAX, but keep redirect working.
		if ( isset( $_GET['skt_templates_ignore_visit_dashboard_notice'] ) && '0' == $_GET['skt_templates_ignore_visit_dashboard_notice'] ) {
			$user_id = get_current_user_id();
			update_user_meta( $user_id, 'skt_welcome_dismissed', '1' );
			// Also set old meta for backward compat.
			add_user_meta( $user_id, 'skt_templates_ignore_visit_dashboard_notice', 'true', true );
			wp_safe_redirect( admin_url( 'admin.php?page=skt_template_directory' ) );
			exit;
		}
	}

	/**
	 * AJAX: permanently dismiss the welcome banner for this user.
	 */
	public function ajax_dismiss_welcome() {
		check_ajax_referer( 'skt_dismiss_welcome', 'nonce' );
		update_user_meta( get_current_user_id(), 'skt_welcome_dismissed', '1' );
		// Also dismiss the old notice meta so nothing ever re-appears.
		add_user_meta( get_current_user_id(), 'skt_templates_ignore_visit_dashboard_notice', 'true', true );
		wp_send_json_success();
	}

	public function page_import_tempate() {
		$gbimport = isset($_POST['gbimport']) ? $_POST['gbimport']: '';
		if($gbimport=="import"){
		?>
		<style>body.toplevel_page_skt_template_import{display:block;}</style>
		<?php }
		if($gbimport=="import"){
			$json_url = isset($_POST['json_url']) ? $_POST['json_url']: '';
			$template_name = isset($_POST['template_name']) ? $_POST['template_name']: '';

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $json_url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 60);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			$content = curl_exec($curl);
			$response = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);

			if($response != 200){ return false; }
			$data = json_decode($content, true);
			$page_content = $data['original_content'];
			$insertId = $data['id'];

			$new_template_page = array(
				'post_type'     => 'page',
				'post_title'    => $template_name,
				'post_status'   => 'publish',
				'post_content'  => $page_content,
				'page_template' => apply_filters( 'template_directory_default_template', 'templates/builder-fullwidth-gb.php' )
			);

			$post_id = wp_insert_post( $new_template_page );
			$redirect_url = add_query_arg( array('post' => $post_id, 'action' => 'edit'), admin_url( 'post.php' ) );
			echo("<script>document.location.href = '".$redirect_url."'</script>");
			exit;
		}
		?>
		<?php
	}

	public function load_modules() {
		do_action( 'skt_templates_modules' );
	}

	public function page_modules_render() {
		$global_settings = new Skt_Templates_Global_Settings();
		$modules = $global_settings::$instance->module_objects;
		$rdh           = new Skt_Templates_Render_Helper();
		$panels        = '';
		foreach ( $modules as $slug => $module ) {
			if ( $module->enable_module() ) {
				$module_options = $module->get_options();
				$options_fields = '';
				if ( ! empty( $module_options ) ) {
					foreach ( $module_options as $option ) {
						$options_fields .= $rdh->render_option( $option, $module );
					}
					$panels .= $rdh->get_partial(
						'module-panel',
						array(
							'slug'           => $slug,
							'name'           => $module->name,
							'active'         => $module->get_is_active(),
							'description'    => $module->description,
							'show'           => $module->show,
							'no_save'        => $module->no_save,
							'options_fields' => $options_fields,
						)
					);
				}
			}
		}
		$data   = array('panels' => $panels);
		$output = $rdh->get_view( 'modules', $data );
		echo $output;
	}

}