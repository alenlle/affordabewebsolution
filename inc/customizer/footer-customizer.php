<?php
/**
 * Affordable Web Solution – Footer Customizer Settings
 *
 * Adds Astra-style footer customization panels:
 *   - Footer Panel
 *     - Footer Layout   (columns, widget areas)
 *     - Footer Colors   (background, text, link, border)
 *     - Footer Bottom Bar (copyright text, layout)
 *     - Footer CTA Strip (optional above-footer CTA band)
 *
 * All new settings are ADDITIVE — no existing settings are removed.
 *
 * @package Affordable_Web_Solution
 * @since   1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register footer customizer settings & controls.
 *
 * Hooked to customize_register via functions.php.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function aws_footer_customizer( WP_Customize_Manager $wp_customize ): void {

	/* ================================================================
	   PANEL: Footer
	================================================================ */
	$wp_customize->add_panel( 'aws_footer_panel', [
		'title'    => __( 'Footer', 'affordable-web-solution' ),
		'priority' => 26,
	] );

	/* ================================================================
	   SECTION 1: Footer Layout
	================================================================ */
	$wp_customize->add_section( 'aws_footer_layout', [
		'title' => __( 'Footer Layout', 'affordable-web-solution' ),
		'panel' => 'aws_footer_panel',
	] );

	// Footer columns
	$wp_customize->add_setting( 'aws_footer_columns', [
		'default'           => '4',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_choices',
	] );
	$wp_customize->add_control( 'aws_footer_columns', [
		'label'   => __( 'Footer Columns', 'affordable-web-solution' ),
		'section' => 'aws_footer_layout',
		'type'    => 'radio',
		'choices' => [
			'1' => __( '1 Column', 'affordable-web-solution' ),
			'2' => __( '2 Columns', 'affordable-web-solution' ),
			'3' => __( '3 Columns', 'affordable-web-solution' ),
			'4' => __( '4 Columns (default)', 'affordable-web-solution' ),
		],
	] );

	// Footer width
	$wp_customize->add_setting( 'aws_footer_width', [
		'default'           => 'contained',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_choices',
	] );
	$wp_customize->add_control( 'aws_footer_width', [
		'label'   => __( 'Footer Width', 'affordable-web-solution' ),
		'section' => 'aws_footer_layout',
		'type'    => 'radio',
		'choices' => [
			'contained'  => __( 'Contained (max-width)', 'affordable-web-solution' ),
			'full-width' => __( 'Full Width', 'affordable-web-solution' ),
		],
	] );

	// Footer brand description
	$wp_customize->add_setting( 'aws_footer_description', [
		'default'           => 'Premium WordPress web design & development agency. We build beautiful, high-performing websites that grow businesses across the United States.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'aws_footer_description', [
		'label'   => __( 'Footer Brand Description', 'affordable-web-solution' ),
		'section' => 'aws_footer_layout',
		'type'    => 'textarea',
	] );

	// Show footer logo in footer
	$wp_customize->add_setting( 'aws_footer_show_logo', [
		'default'           => '1',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_footer_show_logo', [
		'label'   => __( 'Show Logo in Footer', 'affordable-web-solution' ),
		'section' => 'aws_footer_layout',
		'type'    => 'checkbox',
	] );

	// Show social icons
	$wp_customize->add_setting( 'aws_footer_show_socials', [
		'default'           => '1',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_footer_show_socials', [
		'label'   => __( 'Show Social Icons in Footer', 'affordable-web-solution' ),
		'section' => 'aws_footer_layout',
		'type'    => 'checkbox',
	] );

	// Show stats row
	$wp_customize->add_setting( 'aws_footer_show_stats', [
		'default'           => '1',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_footer_show_stats', [
		'label'   => __( 'Show Stats Row in Footer', 'affordable-web-solution' ),
		'section' => 'aws_footer_layout',
		'type'    => 'checkbox',
	] );

	/* ================================================================
	   SECTION 2: Footer Colors
	================================================================ */
	$wp_customize->add_section( 'aws_footer_colors', [
		'title' => __( 'Footer Colors', 'affordable-web-solution' ),
		'panel' => 'aws_footer_panel',
	] );

	// Footer background
	$wp_customize->add_setting( 'aws_footer_bg_color', [
		'default'           => '#0D3B1E',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_bg_color', [
			'label'   => __( 'Footer Background Color', 'affordable-web-solution' ),
			'section' => 'aws_footer_colors',
		] )
	);

	// Footer heading color
	$wp_customize->add_setting( 'aws_footer_heading_color', [
		'default'           => '#FFFFFF',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_heading_color', [
			'label'   => __( 'Footer Heading Color', 'affordable-web-solution' ),
			'section' => 'aws_footer_colors',
		] )
	);

	// Footer text color
	$wp_customize->add_setting( 'aws_footer_text_color', [
		'default'           => 'rgba(255,255,255,0.65)',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_color_rgba',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_text_color', [
			'label'   => __( 'Footer Text / Description Color', 'affordable-web-solution' ),
			'section' => 'aws_footer_colors',
		] )
	);

	// Footer link color
	$wp_customize->add_setting( 'aws_footer_link_color', [
		'default'           => 'rgba(255,255,255,0.65)',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_color_rgba',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_link_color', [
			'label'   => __( 'Footer Link Color', 'affordable-web-solution' ),
			'section' => 'aws_footer_colors',
		] )
	);

	// Footer link hover color
	$wp_customize->add_setting( 'aws_footer_link_hover_color', [
		'default'           => '#C6FF4D',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_link_hover_color', [
			'label'   => __( 'Footer Link Hover Color', 'affordable-web-solution' ),
			'section' => 'aws_footer_colors',
		] )
	);

	/* ================================================================
	   SECTION 3: Footer Bottom Bar
	================================================================ */
	$wp_customize->add_section( 'aws_footer_bottom', [
		'title' => __( 'Footer Bottom Bar', 'affordable-web-solution' ),
		'panel' => 'aws_footer_panel',
	] );

	// Copyright text
	$wp_customize->add_setting( 'aws_footer_copyright', [
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'aws_footer_copyright', [
		'label'       => __( 'Copyright Text', 'affordable-web-solution' ),
		'description' => __( 'Leave blank to use: © [Year] [Agency Name]. All rights reserved.', 'affordable-web-solution' ),
		'section'     => 'aws_footer_bottom',
		'type'        => 'textarea',
	] );

	// Bottom bar background
	$wp_customize->add_setting( 'aws_footer_bottom_bg_color', [
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_bottom_bg_color', [
			'label'       => __( 'Bottom Bar Background', 'affordable-web-solution' ),
			'description' => __( 'Leave blank to inherit footer background.', 'affordable-web-solution' ),
			'section'     => 'aws_footer_bottom',
		] )
	);

	// Show legal links
	$wp_customize->add_setting( 'aws_footer_show_legal', [
		'default'           => '1',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_footer_show_legal', [
		'label'   => __( 'Show Privacy / Terms Links', 'affordable-web-solution' ),
		'section' => 'aws_footer_bottom',
		'type'    => 'checkbox',
	] );

	/* ================================================================
	   SECTION 4: Pre-Footer CTA Strip
	================================================================ */
	$wp_customize->add_section( 'aws_footer_cta_strip', [
		'title' => __( 'Pre-Footer CTA Strip', 'affordable-web-solution' ),
		'panel' => 'aws_footer_panel',
	] );

	// Enable CTA strip
	$wp_customize->add_setting( 'aws_footer_cta_enable', [
		'default'           => '0',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_footer_cta_enable', [
		'label'       => __( 'Enable Pre-Footer CTA Strip', 'affordable-web-solution' ),
		'description' => __( 'Shows a full-width call-to-action band above the footer.', 'affordable-web-solution' ),
		'section'     => 'aws_footer_cta_strip',
		'type'        => 'checkbox',
	] );

	// CTA strip heading
	$wp_customize->add_setting( 'aws_footer_cta_heading', [
		'default'           => 'Ready to Grow Your Business?',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'aws_footer_cta_heading', [
		'label'   => __( 'CTA Strip Heading', 'affordable-web-solution' ),
		'section' => 'aws_footer_cta_strip',
		'type'    => 'text',
	] );

	// CTA strip subtext
	$wp_customize->add_setting( 'aws_footer_cta_subtext', [
		'default'           => 'Get a free consultation and custom quote for your project.',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'aws_footer_cta_subtext', [
		'label'   => __( 'CTA Strip Subtext', 'affordable-web-solution' ),
		'section' => 'aws_footer_cta_strip',
		'type'    => 'text',
	] );

	// CTA strip button text
	$wp_customize->add_setting( 'aws_footer_cta_btn_text', [
		'default'           => 'Get a Free Quote',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'aws_footer_cta_btn_text', [
		'label'   => __( 'CTA Button Text', 'affordable-web-solution' ),
		'section' => 'aws_footer_cta_strip',
		'type'    => 'text',
	] );

	// CTA strip button URL
	$wp_customize->add_setting( 'aws_footer_cta_btn_url', [
		'default'           => '/contact/',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	] );
	$wp_customize->add_control( 'aws_footer_cta_btn_url', [
		'label'   => __( 'CTA Button URL', 'affordable-web-solution' ),
		'section' => 'aws_footer_cta_strip',
		'type'    => 'url',
	] );

	// CTA strip background color
	$wp_customize->add_setting( 'aws_footer_cta_bg_color', [
		'default'           => '#C6FF4D',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_footer_cta_bg_color', [
			'label'   => __( 'CTA Strip Background Color', 'affordable-web-solution' ),
			'section' => 'aws_footer_cta_strip',
		] )
	);
}
add_action( 'customize_register', 'aws_footer_customizer' );
