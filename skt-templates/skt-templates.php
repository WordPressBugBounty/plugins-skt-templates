<?php
/**
 * Plugin Name: SKT Templates
 * Plugin URI: https://www.sktthemes.org/shop/ready-to-import-wordpress-sites/
 * Description: SKT Templates is an Elementor and Gutenberg themes library and allows you to select from over 100s of designs to choose from. All you need to do is view the demo and then select import and install. It takes care of the importing and allows you to edit the template from within your dashboard. It works with any popular theme or you can choose to use any theme from our <a href="https://www.sktthemes.org/product-category/free-wordpress-themes/" rel="nofollow ugc">SKT Themes free.</a> These templates allow you to import them into your existing website and edit them and use them to build professional websites. Importing a single page template is very easy and you can do it on your existing WordPress website as well.
 * Version: 6.4
 * Author: SKT Themes
 * Author URI: https://www.sktthemes.org
 * Text Domain: skt-templates
 *
 * @package SKT Templates
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'st_fs' ) ) {
	function st_fs() {
		global $st_fs;
		if ( ! isset( $st_fs ) ) {
			require_once dirname(__FILE__) . '/freemius/start.php';
			$st_fs = fs_dynamic_init( array(
				'id'         => '9291',
				'slug'       => 'skt-templates',
				'type'       => 'plugin',
				'public_key' => 'pk_6353fc4cd917b8f995b2c4a5ddac7',
				'is_premium' => false,
				'has_addons' => false,
				'has_paid_plans' => false,
				'menu'       => array(
					'first-path' => 'admin.php?page=skt_template_directory',
					'account'    => false,
					'support'    => false,
				),
			) );
		}
		return $st_fs;
	}
	st_fs();
	do_action( 'st_fs_loaded' );
}

// Set up the activation redirect
register_activation_hook( __FILE__, 'skt_templates_activate' );
add_action( 'admin_init', 'skt_templates_activation_redirect' );

function skt_templates_activate() {
	if (
		( isset( $_REQUEST['action'] ) && 'activate-selected' === $_REQUEST['action'] ) &&
		( isset( $_POST['checked'] ) && count( $_POST['checked'] ) > 1 )
	) {
		return;
	}
	add_option( 'skt_templates_activation_redirect', wp_get_current_user()->ID );
}

/**
 * Redirects the user after plugin activation.
 */
function skt_templates_activation_redirect() {
	if ( is_user_logged_in() && intval( get_option( 'skt_templates_activation_redirect', false ) ) === wp_get_current_user()->ID ) {
		delete_option( 'skt_templates_activation_redirect' );
		wp_safe_redirect( admin_url( '/admin.php?page=skt_template_directory' ) );
		exit;
	}
}

// Register custom rewrite rule and query var
add_action( 'init', 'skt_templates_register_xml_endpoint' );
function skt_templates_register_xml_endpoint() {
	add_rewrite_tag( '%skt_templates_xml%', '1' );
	add_rewrite_rule( '^skt-templates\.xml$', 'index.php?skt_templates_xml=1', 'top' );
}

// Register query var
add_filter( 'query_vars', 'skt_templates_add_query_var' );
function skt_templates_add_query_var( $vars ) {
	$vars[] = 'skt_templates_xml';
	return $vars;
}

// Auto flush rewrite rules once
add_action( 'init', 'skt_templates_maybe_flush_rules', 99 );
function skt_templates_maybe_flush_rules() {
	if ( get_option( 'skt_templates_rules_flushed' ) === '1' ) {
		return;
	}
	$rules = get_option( 'rewrite_rules' );
	if ( ! isset( $rules['^skt-templates\.xml$'] ) ) {
		flush_rewrite_rules();
		update_option( 'skt_templates_rules_flushed', '1' );
	}
}

// Reset flush flag on plugin deactivation
register_deactivation_hook( __FILE__, function() {
	delete_option( 'skt_templates_rules_flushed' );
});

add_action( 'wp_head', 'skt_templates_add_link_to_head' );
function skt_templates_add_link_to_head() {
	echo '<link rel="alternate" type="application/xml" href="' . esc_url( home_url( '/skt-templates.xml' ) ) . '" />';
}

// Render custom HTML output for /skt-templates.xml
add_action( 'template_redirect', 'skt_templates_render_custom_html' );
function skt_templates_render_custom_html() {	
	if ( get_query_var( 'skt_templates_xml' ) ) {
		header( 'Content-Type: text/html; charset=utf-8' );
		?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php esc_html_e( 'Build Beautiful Websites with SKT Templates Plugin', 'skt-templates' ); ?></title>
    <meta name="description" content="<?php esc_html_e( 'SKT Templates helps you build websites without writing any code. You can choose from over 100 designs. These designs are called templates.', 'skt-templates' ); ?>" />
	<style>
		body {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
			background: #fff;
			color: #333;
			line-height: 1.6;
			margin: 0;
		}
		#skt-templates-description {
			background: #0196d6;
			color: #fff;
			padding: 30px 20px;
		}
		#skt-templates-description h1 {
			margin: 0;
			font-size: 28px;
			text-align: center;
		}
		#skt-templates-description p {
			margin: 10px 0;
			font-size: 16px;
		}
		#skt-templates-description a,
		#skt-templates-content a {
			color: #003be3;
			text-decoration: none;
		}
		#skt-templates-description a:hover,
		#skt-templates-content a:hover {
			color: #f98315;
			text-decoration: underline;
		}
		#skt-templates-content {
			padding: 15px 20px;
			background: #f9f9f9;
		}
	</style>
</head>
<body>
	<div id="skt-templates-description">
		<h1><?php esc_html_e( 'Build Beautiful Websites with SKT Templates Plugin', 'skt-templates' ); ?></h1>
	</div>
	<div id="skt-templates-content">
		<?php
		$paragraphs = array(
			sprintf(
				__( '<a href="%1$s" target="_blank">SKT Templates plugin</a> is made for WordPress. It helps you build websites without writing any code. You can choose from over 100 designs. These designs are called templates. You just need to look at the demo. Then you can click to import and install it. The process is simple and fast.', 'skt-templates' ),
				esc_url( 'https://wordpress.org/plugins/skt-templates/' )
			),
			__( 'You can use SKT Templates with any theme. It works well with all popular WordPress themes. You can also use it with free SKT Themes. It supports both Elementor and Gutenberg editors. This gives you more choice and freedom. You do not need any design skills. Everything is ready to use.', 'skt-templates' ),
			__( 'The plugin helps you import full pages. You can add them to your existing website. Or you can start with a fresh site. It is your choice. Just click and the page gets added. You can then edit it inside your WordPress dashboard. No need to leave the website. No need to touch any code.', 'skt-templates' ),
			__( 'All the templates are hosted on the SKT Themes test server. This makes the import fast and safe. The designs cover many types of websites. You can use them for business or personal use. There are templates for hotels and spas. Some are for fitness and medical sites. You will find designs for blogs and charities too. Even pet care and home repair sites are included.', 'skt-templates' ),
			__( 'The plugin is easy to use. Just see the demo. Choose the one you like. Click import. Your page is ready. You can change text and images using Elementor. You can also change colors and layout. Make it look the way you want. It is fun and simple.', 'skt-templates' ),
			sprintf(
				__( 'You can also extend the design. Use a free SKT theme. This will help you use the full features. This means the header and footer will match the template. You can make your site look just like the demo. If you want more pages and full theme features you can buy the theme. Visit the <a href="%1$s" target="_blank">SKT Themes</a> website to see all the options.', 'skt-templates' ),
				esc_url( 'https://www.sktthemes.org/' )
			),
			__( 'There is a full guide on how to use the plugin. You can check the documentation link. It will help you step by step. You do not need any special training.', 'skt-templates' ),
			__( 'Many people ask if the plugin works with their current theme. Yes it does. It will work unless your theme has a problem with Elementor. All the templates in the plugin are free. In the beginning there are 60 templates. Soon there will be more than 100.', 'skt-templates' ),
			__( 'You can import a template into any website. But it is better to test it on a new WordPress install. If your site has many plugins it may create some problems. So always take a backup before you try.', 'skt-templates' ),
			__( 'Once you import and finish your design you can turn off the plugin. Your site will keep working. You can keep editing with Elementor as usual.', 'skt-templates' ),
			__( 'Try SKT Templates plugin today. Build a great site with ease.', 'skt-templates' ),
		);

		foreach ( $paragraphs as $para ) {
			echo '<p>' . wp_kses_post( $para ) . '</p>';
		}
		?>
	</div>
</body>
</html>
		<?php
		exit;
	}
}

function run_skt_templates() {
	define( 'SKTB_URL', plugins_url( '/', __FILE__ ) );
	define( 'SKB_PATH', dirname( __FILE__ ) );
	$plugin = new Skt_Templates();
	$plugin->run();
	$vendor_file = SKB_PATH . '/vendor/autoload.php';
	if ( is_readable( $vendor_file ) ) {
		require_once $vendor_file;
	}
	add_filter( 'sktthemes_sdk_products', function ( $products ) {
		$products[] = __FILE__;
		return $products;
	} );
	add_filter( 'sktthemes_companion_friendly_name', function( $name ) {
		return 'SKT Templates';
	} );
}

require 'class-autoloader.php';
SktAutoloader::set_plugins_path( plugin_dir_path( __DIR__ ) );
SktAutoloader::define_namespaces( array( 'Skt_Templates', 'SKTB', 'SKTB_Module' ) );
spl_autoload_register( array( 'SktAutoloader', 'loader' ) );

function skt_template_styles() {
	wp_enqueue_style( 'templaters', plugin_dir_url( __FILE__ ) . 'css/templaters.css' );
}
add_action( 'wp_enqueue_scripts', 'skt_template_styles' );

// Start plugin
run_skt_templates();