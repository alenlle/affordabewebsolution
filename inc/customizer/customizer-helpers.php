<?php
/**
 * Affordable Web Solution – Customizer Helpers
 *
 * Contains:
 *  1. Sanitization callbacks shared by header & footer customizers.
 *  2. Dynamic CSS generation from customizer values (output via wp_head).
 *  3. Live preview postMessage JS inline output.
 *
 * @package Affordable_Web_Solution
 * @since   1.1.0
 */

defined( 'ABSPATH' ) || exit;

/* ================================================================
   SANITIZATION HELPERS
================================================================ */

/**
 * Sanitize a value against a fixed list of allowed choices.
 *
 * @param  string               $value    The incoming value.
 * @param  WP_Customize_Setting $setting  The setting object.
 * @return string                          Sanitized value or default.
 */
function aws_sanitize_choices( string $value, WP_Customize_Setting $setting ): string {
	$control = $setting->manager->get_control( $setting->id );
	if ( $control && isset( $control->choices ) && array_key_exists( $value, $control->choices ) ) {
		return $value;
	}
	return $setting->default;
}

/**
 * Sanitize a checkbox: accepts '1' or '0'.
 *
 * @param  mixed $value Incoming value.
 * @return string       '1' or '0'.
 */
function aws_sanitize_checkbox( $value ): string {
	return ( '1' === $value || true === $value ) ? '1' : '0';
}

/**
 * Sanitize an rgba() or hex color string.
 * Falls through to sanitize_hex_color for plain hex values.
 *
 * @param  string $color Incoming color string.
 * @return string        Sanitized color or empty string.
 */
function aws_sanitize_color_rgba( string $color ): string {
	$color = trim( $color );

	// Accept rgba() values
	if ( preg_match( '/^rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(0|1|0?\.\d+)\s*\)$/', $color ) ) {
		return $color;
	}

	// Fall back to hex sanitization
	$hex = sanitize_hex_color( $color );
	return $hex ?? '';
}

/* ================================================================
   DYNAMIC CSS OUTPUT
================================================================ */

/**
 * Build and output dynamic CSS from customizer settings.
 * Hooked to wp_head at priority 99 so it overrides theme defaults.
 */
function aws_customizer_dynamic_css(): void {
	/* ── Header values ─────────────────────────────── */
	$header_bg        = sanitize_hex_color( get_theme_mod( 'aws_header_bg_color', '#10512A' ) );
	$header_scrolled  = sanitize_hex_color( get_theme_mod( 'aws_header_scrolled_bg_color', '#183D2D' ) );
	$header_border    = aws_sanitize_color_rgba( get_theme_mod( 'aws_header_border_color', 'rgba(198,255,77,0.12)' ) );
	$nav_color        = sanitize_hex_color( get_theme_mod( 'aws_nav_link_color', '#FFFFFF' ) );
	$nav_hover        = sanitize_hex_color( get_theme_mod( 'aws_nav_link_hover_color', '#C6FF4D' ) );
	$nav_fs           = absint( get_theme_mod( 'aws_nav_font_size', 15 ) );
	$nav_fw           = in_array( get_theme_mod( 'aws_nav_font_weight', '500' ), [ '400', '500', '600', '700' ], true )
	                    ? get_theme_mod( 'aws_nav_font_weight', '500' ) : '500';
	$dropdown_bg      = sanitize_hex_color( get_theme_mod( 'aws_dropdown_bg_color', '#183D2D' ) );
	$header_pad       = absint( get_theme_mod( 'aws_header_padding_top', 16 ) );
	$cta_bg           = sanitize_hex_color( get_theme_mod( 'aws_header_cta_bg_color', '#C6FF4D' ) );
	$cta_txt          = sanitize_hex_color( get_theme_mod( 'aws_header_cta_text_color', '#102117' ) );
	$show_phone       = get_theme_mod( 'aws_header_show_phone', '1' );

	/* ── Logo values ──────────────────────────────── */
	$logo_w           = absint( get_theme_mod( 'aws_logo_max_width', 200 ) );
	$logo_w_tablet    = absint( get_theme_mod( 'aws_logo_max_width_tablet', 160 ) );
	$logo_w_mobile    = absint( get_theme_mod( 'aws_logo_max_width_mobile', 120 ) );
	$logo_h           = absint( get_theme_mod( 'aws_logo_max_height', 60 ) );

	/* ── Footer values ────────────────────────────── */
	$footer_bg        = sanitize_hex_color( get_theme_mod( 'aws_footer_bg_color', '#0D3B1E' ) );
	$footer_head_clr  = sanitize_hex_color( get_theme_mod( 'aws_footer_heading_color', '#FFFFFF' ) );
	$footer_txt       = aws_sanitize_color_rgba( get_theme_mod( 'aws_footer_text_color', 'rgba(255,255,255,0.65)' ) );
	$footer_link      = aws_sanitize_color_rgba( get_theme_mod( 'aws_footer_link_color', 'rgba(255,255,255,0.65)' ) );
	$footer_link_h    = sanitize_hex_color( get_theme_mod( 'aws_footer_link_hover_color', '#C6FF4D' ) );
	$footer_bot_bg    = sanitize_hex_color( get_theme_mod( 'aws_footer_bottom_bg_color', '' ) );

	/* ── Header width class ───────────────────────── */
	$header_width = get_theme_mod( 'aws_header_width', 'contained' );
	$full_width_css = '';
	if ( 'full-width' === $header_width ) {
		$full_width_css = '.site-header .container { max-width: 100%; padding-left: 2rem; padding-right: 2rem; }';
	}

	/* ── Footer width class ───────────────────────── */
	$footer_width = get_theme_mod( 'aws_footer_width', 'contained' );
	$footer_full_css = '';
	if ( 'full-width' === $footer_width ) {
		$footer_full_css = '.site-footer .container { max-width: 100%; padding-left: 2rem; padding-right: 2rem; }';
	}

	/* ── Phone visibility ─────────────────────────── */
	$phone_css = '';
	if ( '0' === $show_phone || '' === $show_phone ) {
		$phone_css = '.btn-header-phone { display: none !important; }';
	}

	ob_start();
	?>
/* ── AWS Customizer Dynamic CSS ── */
:root {
	--aws-header-bg: <?php echo esc_attr( $header_bg ); ?>;
	--aws-header-scrolled-bg: <?php echo esc_attr( $header_scrolled ); ?>;
	--aws-header-border: <?php echo esc_attr( $header_border ); ?>;
	--aws-nav-color: <?php echo esc_attr( $nav_color ); ?>;
	--aws-nav-hover: <?php echo esc_attr( $nav_hover ); ?>;
	--aws-dropdown-bg: <?php echo esc_attr( $dropdown_bg ); ?>;
	--aws-footer-bg: <?php echo esc_attr( $footer_bg ); ?>;
	--aws-footer-head-color: <?php echo esc_attr( $footer_head_clr ); ?>;
	--aws-footer-txt: <?php echo esc_attr( $footer_txt ); ?>;
	--aws-footer-link: <?php echo esc_attr( $footer_link ); ?>;
	--aws-footer-link-hover: <?php echo esc_attr( $footer_link_h ); ?>;
}

/* Header */
.site-header {
	background: var(--aws-header-bg, <?php echo esc_attr( $header_bg ); ?>);
	border-bottom-color: var(--aws-header-border);
	padding: <?php echo esc_attr( $header_pad ); ?>px 0;
}
.site-header.scrolled {
	background: var(--aws-header-scrolled-bg, <?php echo esc_attr( $header_scrolled ); ?>);
}

/* Navigation */
.nav-link {
	color: var(--aws-nav-color) !important;
	font-size: <?php echo esc_attr( $nav_fs ); ?>px;
	font-weight: <?php echo esc_attr( $nav_fw ); ?>;
}
.nav-link:hover,
.nav-item:hover > .nav-link {
	color: var(--aws-nav-hover) !important;
}
/* Dropdown bg: only override if user explicitly changed it from the default white */
<?php
$dropdown_bg_raw = get_theme_mod( 'aws_dropdown_bg_color', '' );
if ( ! empty( $dropdown_bg_raw ) ) :
?>
.dropdown {
	background: <?php echo esc_attr( sanitize_hex_color( $dropdown_bg_raw ) ); ?> !important;
}
<?php endif; ?>

/* CTA Button (header) */
.btn-accent {
	background: <?php echo esc_attr( $cta_bg ); ?> !important;
	color: <?php echo esc_attr( $cta_txt ); ?> !important;
}

/* Logo sizing — Desktop */
.site-logo img,
.custom-logo {
	max-width: <?php echo esc_attr( $logo_w ); ?>px !important;
	max-height: <?php echo esc_attr( $logo_h ); ?>px !important;
	width: auto;
	height: auto;
}

/* Logo sizing — Tablet (≤1024px) */
@media (max-width: 1024px) {
	.site-logo img,
	.custom-logo {
		max-width: <?php echo esc_attr( $logo_w_tablet ); ?>px !important;
	}
}

/* Logo sizing — Mobile (≤767px) */
@media (max-width: 767px) {
	.site-logo img,
	.custom-logo {
		max-width: <?php echo esc_attr( $logo_w_mobile ); ?>px !important;
	}
}

/* Footer */
.site-footer {
	background: var(--aws-footer-bg) !important;
}
.footer-col h4,
.site-footer h4 {
	color: var(--aws-footer-head-color) !important;
}
.footer-desc,
.site-footer p {
	color: var(--aws-footer-txt) !important;
}
.footer-link {
	color: var(--aws-footer-link) !important;
}
.footer-link:hover {
	color: var(--aws-footer-link-hover) !important;
}
<?php if ( $footer_bot_bg ) : ?>
.footer-bottom {
	background: <?php echo esc_attr( $footer_bot_bg ); ?> !important;
}
<?php endif; ?>
<?php echo wp_kses_post( $full_width_css ); ?>
<?php echo wp_kses_post( $footer_full_css ); ?>
<?php echo wp_kses_post( $phone_css ); ?>
	<?php
	$css = ob_get_clean();

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS is already sanitized above
	echo '<style id="aws-customizer-css">' . $css . '</style>' . "\n";
}
add_action( 'wp_head', 'aws_customizer_dynamic_css', 99 );

/* ================================================================
   LIVE PREVIEW: postMessage JS
================================================================ */

/**
 * Enqueue the live-preview JS for postMessage transport settings.
 * Only loads inside the customizer preview frame.
 */
function aws_customizer_preview_js(): void {
	wp_enqueue_script(
		'aws-customizer-preview',
		AWS_URI . '/assets/js/customizer-preview.js',
		[ 'customize-preview', 'jquery' ],
		AWS_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'aws_customizer_preview_js' );
