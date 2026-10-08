<?php
/**
 * The About Page for SKT Templates.
 *
 * @link       https://www.sktthemes.org
 * @since      1.0.0
 *
 * @package    Skt_Templates
 * @subpackage Skt_Templates/app/views
 * @codeCoverageIgnore
 */

	$sktb_bf_all_url      = 'https://www.sktthemes.org/shop/all-themes/';
	$sktb_bf_lifetime_url = 'https://www.sktthemes.org/shop/lifetime-access-wordpress-themes/';

	$sktb_docs_url    = 'https://sktthemesdemo.net/documentation/skt-templates-plugin-doc';
	$sktb_support_url = 'https://wordpress.org/support/plugin/skt-templates/';
	$sktb_review_url  = 'https://wordpress.org/support/plugin/skt-templates/reviews/#new-post';
	$sktb_contact_url = 'https://www.sktthemes.org/contact/';
	$sktb_themes_url  = 'https://www.sktthemes.org/themes/';
	$sktb_video_id    = '2QVEhff55d4';

	$sktb_featured_themes = array(
		array(
			'name' => 'SKT Launch Pro',
			'img'  => 'https://www.sktthemes.org/wp-content/uploads/2022/05/ebook-Author-WordPress-Theme-472x430.webp',
			'demo' => 'https://sktthemesdemo.net/ebookauthor/',
			'buy'  => 'https://www.sktthemes.org/shop/ebook-author-wordpress-theme/',
		),		
		array(
			'name' => 'Fashion Trends',
			'img'  => 'https://www.sktthemes.org/wp-content/uploads/2025/06/Clothing-Brand-WordPress-Theme-472x430.webp',
			'demo' => 'https://sktperfectdemo.com/demos/fashion/',
			'buy'  => 'https://www.sktthemes.org/shop/clothing-brand-wordpress-theme/',
		),
		array(
			'name' => 'SKT Plain Pro',
			'img'  => 'https://www.sktthemes.org/wp-content/uploads/2025/02/minimalistic-wordpress-theme-472x430.webp',
			'demo' => 'https://sktperfectdemo.com/demos/skt-minimalistic/',
			'buy'  => 'https://www.sktthemes.org/shop/minimalistic-wordpress-theme/',
		),
		array(
			'name' => 'SKT Glistening',
			'img'  => 'https://www.sktthemes.org/wp-content/uploads/2025/06/Sleek-WordPress-Theme-472x430.webp',
			'demo' => 'https://demosktthemes.com/free/saturnwp/',
			'buy'  => 'https://www.sktthemes.org/shop/sleek-wordpress-theme/',
		),
		array(
			'name' => 'SKT Thrive',
			'img'  => 'https://www.sktthemes.org/wp-content/uploads/2025/07/Business-Consulting-WordPress-Theme-472x430.webp',
			'demo' => 'https://sktperfectdemo.com/demos/business-consulting/',
			'buy'  => 'https://www.sktthemes.org/shop/business-consulting-wordpress-theme/',
		)		
	);

	$sktb_resources = array(
		array(
			'icon'  => 'dashicons-media-document',
			'title' => __( 'Documentation', 'skt-templates' ),
			'desc'  => __( 'Guides for importing & customizing templates.', 'skt-templates' ),
			'url'   => $sktb_docs_url,
		),
		array(
			'icon'  => 'dashicons-format-chat',
			'title' => __( 'Support Forum', 'skt-templates' ),
			'desc'  => __( 'Ask questions or report an issue on WordPress.org.', 'skt-templates' ),
			'url'   => $sktb_support_url,
		),
		array(
			'icon'  => 'dashicons-video-alt3',
			'title' => __( 'Video Tutorial', 'skt-templates' ),
			'desc'  => __( 'Watch the full walkthrough on YouTube.', 'skt-templates' ),
			'url'   => 'https://www.youtube.com/watch?v=' . $sktb_video_id,
		),
		array(
			'icon'  => 'dashicons-admin-appearance',
			'title' => __( 'Premium Themes', 'skt-templates' ),
			'desc'  => __( 'Browse 420+ professionally designed themes.', 'skt-templates' ),
			'url'   => $sktb_themes_url,
		),
	);
?>
<div class="sktb-about-page">

<div class="sktb-template-dir wrap">
<div class="sktb-bf-banner">
	<div class="sktb-bf-left">
		<div class="sktb-bf-tags">
			<span class="sktb-bf-tag"><?php esc_html_e( '420+ premium themes', 'skt-templates' ); ?></span>
		</div>
		<h3 class="sktb-bf-title"><?php esc_html_e( 'WordPress Themes Bundle', 'skt-templates' ); ?></h3>
		<p class="sktb-bf-desc">
			<?php esc_html_e( 'Get access to 420+ premium WordPress themes for every kind of business, with regular updates and dedicated support.', 'skt-templates' ); ?>
		</p>
		<ul class="sktb-bf-features">
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Customization flexibility', 'skt-templates' ); ?></li>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Dedicated support', 'skt-templates' ); ?></li>
		</ul>
	</div>

	<div class="sktb-bf-image">
		<img src="<?php echo esc_url( SKTB_URL . 'images/bf-themes.png' ); ?>" alt="<?php esc_attr_e( 'SKT Themes Bundle', 'skt-templates' ); ?>">
	</div>

	<div class="sktb-bf-plans">
		<div class="sktb-bf-card">
			<span class="sktb-bf-plan-name"><?php esc_html_e( 'All Themes', 'skt-templates' ); ?></span>
			<span class="sktb-bf-price">
				<del class="sktb-bf-old-price"><?php echo esc_html( '$199.00' ); ?></del>
				<ins class="sktb-bf-new-price"><?php echo esc_html( '$69.00' ); ?></ins>
			</span>
			<span class="sktb-bf-plan-note"><?php esc_html_e( '1 year of updates & support', 'skt-templates' ); ?></span>
			<a class="sktb-bf-btn" href="<?php echo esc_url( $sktb_bf_all_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Buy Now', 'skt-templates' ); ?></a>
		</div>
		<div class="sktb-bf-card">
			<span class="sktb-bf-plan-name"><?php esc_html_e( 'Lifetime', 'skt-templates' ); ?></span>
			<span class="sktb-bf-price">
				<del class="sktb-bf-old-price"><?php echo esc_html( '$399.00' ); ?></del>
				<ins class="sktb-bf-new-price"><?php echo esc_html( '$199.00' ); ?></ins>
			</span>
			<span class="sktb-bf-plan-note"><?php esc_html_e( 'Lifetime updates & support', 'skt-templates' ); ?></span>
			<a class="sktb-bf-btn" href="<?php echo esc_url( $sktb_bf_lifetime_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Buy Now', 'skt-templates' ); ?></a>
		</div>
	</div>
</div>
</div>

<div class="sktb-template-dir wrap" id="sktb-modules-wrapper">
		<div class="sktb-themes-promo">
			<div class="sktb-themes-head">
				<div>
					<h2><?php esc_html_e( 'Premium WordPress Themes', 'skt-templates' ); ?></h2>
					<p><?php esc_html_e( 'Powerful WordPress themes built for Elementor, Gutenberg & FSE responsive, customizable, and packed with one-click demo import to launch your website faster.', 'skt-templates' ); ?></p>
				</div>
				<a class="sktb-btn" href="<?php echo esc_url( $sktb_themes_url ); ?>" target="_blank" rel="noopener">
					<?php esc_html_e( 'View All Themes', 'skt-templates' ); ?><span class="dashicons dashicons-arrow-right-alt"></span>
				</a>
			</div>

			<div class="sktb-themes-grid">
				<?php foreach ( $sktb_featured_themes as $theme ) : ?>
					<div class="sktb-theme-card">
						<a href="<?php echo esc_url( $theme['buy'] ); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url( $theme['img'] ); ?>" alt="<?php echo esc_attr( $theme['name'] ); ?>" loading="lazy">
						</a>
						<div class="sktb-theme-body">
							<h3><?php echo esc_html( $theme['name'] ); ?></h3>							 
							<div class="sktb-theme-price">
								<del><?php echo esc_html( '$69.00' ); ?></del>
								<ins><?php echo esc_html( '$39.00' ); ?></ins>
							</div>
							<div class="sktb-theme-actions">
								<a class="sktb-btn sktb-btn-outline" href="<?php echo esc_url( $theme['demo'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Demo', 'skt-templates' ); ?></a>
								<a class="sktb-btn" href="<?php echo esc_url( $theme['buy'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Buy Now', 'skt-templates' ); ?></a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="sktb-about-grid">

			<!-- LEFT COLUMN -->
			<div class="sktb-about-main">

				<!-- Video -->
				<div class="sktb-card">
					<div class="sktb-video-head">
						<div class="sktb-icon"><span class="dashicons dashicons-controls-play"></span></div>
						<div>
							<h2><?php esc_html_e( 'How to use SKT Templates', 'skt-templates' ); ?></h2>
							<p><?php esc_html_e( 'A quick walkthrough of browsing, importing and customizing templates.', 'skt-templates' ); ?></p>
						</div>
					</div>
					<div class="sktb-video-frame">
						<div class="sktb-video-ratio">
							<iframe
								src="<?php echo esc_url( 'https://www.youtube.com/embed/' . $sktb_video_id . '?rel=0' ); ?>"
								title="<?php esc_attr_e( 'How to use SKT Templates', 'skt-templates' ); ?>"
								loading="lazy"
								allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
								allowfullscreen>
							</iframe>
						</div>
					</div>
					<div class="sktb-video-foot">
						<div class="sktb-video-tags">
							<span><?php esc_html_e( 'Elementor', 'skt-templates' ); ?></span>
							<span><?php esc_html_e( 'Gutenberg', 'skt-templates' ); ?></span>
							<span><?php esc_html_e( 'Beginner friendly', 'skt-templates' ); ?></span>
						</div>
						<a class="sktb-btn sktb-btn-outline" href="<?php echo esc_url( 'https://www.youtube.com/watch?v=' . $sktb_video_id ); ?>" target="_blank" rel="noopener">
							<span class="dashicons dashicons-external"></span><?php esc_html_e( 'Watch on YouTube', 'skt-templates' ); ?>
						</a>
					</div>
				</div>

				<!-- About -->
				<div class="sktb-card">
					<div class="sktb-card-body">
						<h2><?php esc_html_e( 'What is SKT Templates?', 'skt-templates' ); ?></h2>
						<p><?php esc_html_e( 'SKT Templates gives you ready-to-import, professionally designed websites built with Elementor and Gutenberg. Import any template into a fresh or existing WordPress site in just a few clicks no coding needed.', 'skt-templates' ); ?></p>
					</div>
				</div>

				<!-- How it works -->
				<div class="sktb-card">
					<div class="sktb-card-body">
						<h2><?php esc_html_e( 'How it works', 'skt-templates' ); ?></h2>
						<?php
						$sktb_steps = array(
							array( __( 'Browse templates', 'skt-templates' ), __( 'Go to SKT Templates → Elementor Templates and explore 200+ professionally designed ready-to-use templates.', 'skt-templates' ) ),
							array( __( 'Preview & choose', 'skt-templates' ), __( 'Click "More Details" to preview the live demo and choose the perfect design for your website.', 'skt-templates' ) ),
							array( __( 'Import & edit instantly in Elementor', 'skt-templates' ), __( 'Import templates directly inside the Elementor editor — no page switching required. Open any page in Elementor and click the "SKT Templates" button at the top left to instantly browse and import 200+ templates. The selected design loads directly into your page, ready to customize.', 'skt-templates' ) ),
							array( __( 'Customize & publish', 'skt-templates' ), __( 'Edit text, images, colors, and layout using Elementor’s drag-and-drop builder, then publish your page in minutes.', 'skt-templates' ) ),
						);
						?>
						<div class="sktb-steps">
							<?php foreach ( $sktb_steps as $i => $step ) : ?>
								<div class="sktb-step">
									<div class="sktb-step-num"><?php echo esc_html( $i + 1 ); ?></div>
									<div>
										<strong><?php echo esc_html( $step[0] ); ?></strong>
										<span><?php echo esc_html( $step[1] ); ?></span>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

			</div>

			<!-- RIGHT COLUMN -->
			<aside class="sktb-about-side">

				<!-- Help & Resources -->
				<div class="sktb-card">
					<h3 class="sktb-side-title"><?php esc_html_e( 'Help & Resources', 'skt-templates' ); ?></h3>
					<ul class="sktb-res-list">
						<?php foreach ( $sktb_resources as $res ) : ?>
							<li>
								<a class="sktb-res-link" href="<?php echo esc_url( $res['url'] ); ?>" target="_blank" rel="noopener">
									<span class="sktb-res-icon"><span class="dashicons <?php echo esc_attr( $res['icon'] ); ?>"></span></span>
									<span class="sktb-res-text">
										<strong><?php echo esc_html( $res['title'] ); ?></strong>
										<small><?php echo esc_html( $res['desc'] ); ?></small>
									</span>
									<span class="dashicons dashicons-arrow-right-alt2 sktb-res-arrow"></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<!-- Customer Care -->
				<div class="sktb-card">
					<div class="sktb-care-head">
						<h3><?php esc_html_e( 'Customer Care', 'skt-templates' ); ?></h3>
						<p><?php esc_html_e( 'Stuck somewhere? Our team is happy to help you get your website live.', 'skt-templates' ); ?></p>
					</div>
					<div class="sktb-care-body">
						<p class="sktb-care-label"><?php esc_html_e( 'Quick checks before contacting', 'skt-templates' ); ?></p>
						<ul class="sktb-care-checks">
							<li><span class="dashicons dashicons-yes-alt"></span><?php esc_html_e( 'Update SKT Templates, Elementor and WordPress to the latest versions.', 'skt-templates' ); ?></li>
							<li><span class="dashicons dashicons-yes-alt"></span><?php esc_html_e( 'Clear your cache plugin and browser cache after importing.', 'skt-templates' ); ?></li>
							<li><span class="dashicons dashicons-yes-alt"></span><?php esc_html_e( 'Import failing? Temporarily disable other plugins and retry.', 'skt-templates' ); ?></li>
						</ul>
						<div class="sktb-care-actions">
							<a class="sktb-btn" href="<?php echo esc_url( $sktb_contact_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Contact Us', 'skt-templates' ); ?></a>
							<a class="sktb-btn sktb-btn-outline" href="<?php echo esc_url( $sktb_support_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open Ticket', 'skt-templates' ); ?></a>
						</div>						
					</div>
				</div>

			</aside>
		</div>

	</div>

</div> 