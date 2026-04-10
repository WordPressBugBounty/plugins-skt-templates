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
?>
<div class="sktb-wrapper sktb-header">
	<div class="sktb-header-content">
		<img src="<?php echo esc_url( SKTB_URL ); ?>/images/logo.png" title="<?php echo esc_html( 'SKT Templates'); ?>" class="sktb-logo"/>
		<h1><?php esc_attr_e( 'SKT Templates', 'skt-templates' ); ?></h1><span class="powered"> <?php echo esc_html( 'by'); ?> <a
					href="<?php echo esc_url('https://www.sktthemes.org/');?>" target="_blank"><b><?php echo esc_html( 'SKT Themes'); ?></b></a></span>
	</div>
</div>
    <div class="sktb-full-page-container">
        <div class="sktb-wrapper" id="sktb-modules-wrapper">
        <h2><center><?php esc_attr_e( 'How to use SKT Templates?' ,'skt-templates') ?></center></h2>
       <div class="skt-video-wrapper">
        <iframe 
            src="https://www.youtube.com/embed/2QVEhff55d4" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>
     <!-- About -->
        <div style="background:#fff;border:1px solid #eee;border-radius:8px;padding:1.25rem;margin-bottom:2rem;">
            <h2><?php esc_html_e( 'What is SKT Templates?', 'skt-templates' ); ?></h2>
            <p><?php esc_html_e( 'SKT Templates gives you ready-to-import, professionally designed websites built with Elementor and Gutenberg. Import any template into a fresh or existing WordPress site in just a few clicks no coding needed.', 'skt-templates' ); ?></p>             
        </div>

        <!-- How it works -->
        <div style="background:#fff;border:1px solid #eee;border-radius:8px;padding:1.25rem;margin-bottom:2rem;">
    <h2><?php esc_html_e( 'How it works', 'skt-templates' ); ?></h2>

    <div style="display:flex;flex-direction:column;gap:16px;">

        <!-- Step 1 -->
        <div style="display:flex;gap:14px;align-items:flex-start;">
            <div style="width:30px;height:30px;border-radius:50%;background:#0073aa;color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;">1</div>
            <div>
                <strong><?php esc_html_e( 'Browse templates', 'skt-templates' ); ?></strong><br>
                <span style="font-size:13px;color:#666;">
                    <?php esc_html_e( 'Go to SKT Templates → Elementor Templates and explore 200+ professionally designed ready-to-use templates.', 'skt-templates' ); ?>
                </span>
            </div>
        </div>

        <!-- Step 2 -->
        <div style="display:flex;gap:14px;align-items:flex-start;">
            <div style="width:30px;height:30px;border-radius:50%;background:#0073aa;color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;">2</div>
            <div>
                <strong><?php esc_html_e( 'Preview & choose', 'skt-templates' ); ?></strong><br>
                <span style="font-size:13px;color:#666;">
                    <?php esc_html_e( 'Click "More Details" to preview the live demo and choose the perfect design for your website.', 'skt-templates' ); ?>
                </span>
            </div>
        </div>

        <!-- Step 3 -->
        <div style="display:flex;gap:14px;align-items:flex-start;">
            <div style="width:30px;height:30px;border-radius:50%;background:#0073aa;color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;">3</div>
            <div>
                <strong><?php esc_html_e( 'Import & edit instantly in Elementor', 'skt-templates' ); ?></strong><br>
                <span style="font-size:13px;color:#666;">
                    <?php esc_html_e( 'Import templates directly inside the Elementor editor — no page switching required. Open any page in Elementor and click the "SKT Templates" button at the top left to instantly browse and import 200+ templates. The selected design loads directly into your page, ready to customize.', 'skt-templates' ); ?>
                </span>
            </div>
        </div>

        <!-- Step 4 (NEW - Value Add) -->
        <div style="display:flex;gap:14px;align-items:flex-start;">
            <div style="width:30px;height:30px;border-radius:50%;background:#0073aa;color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0;">4</div>
            <div>
                <strong><?php esc_html_e( 'Customize & publish', 'skt-templates' ); ?></strong><br>
                <span style="font-size:13px;color:#666;">
                    <?php esc_html_e( 'Edit text, images, colors, and layout using Elementor’s drag-and-drop builder, then publish your page in minutes.', 'skt-templates' ); ?>
                </span>
            </div>
        </div>

    </div>
</div>
    <p class="sktb-banner-center"><a href="<?php echo esc_url('https://www.sktthemes.org/themes/');?>" target="_blank"><img src="<?php echo esc_url( SKTB_URL ); ?>/images/skt-template-banner.jpg" title="<?php echo esc_html( 'SKT Themes'); ?>"/></a></p>
	</div>
</div>