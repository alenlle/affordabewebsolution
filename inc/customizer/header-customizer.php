<?php
/**
 * Affordable Web Solution – Header Customizer Settings
 *
 * Adds Astra-style header customization panels:
 *   - Header Panel
 *     - Header Layout  (logo position, header width, sticky, transparent)
 *     - Header Colors  (background, text, border)
 *     - Logo Settings  (width/height responsive sliders, OceanWP-style)
 *     - Navigation     (menu color, hover color, font size)
 *     - Header CTA     (button text, URL, color overrides)
 *
 * All new settings are ADDITIVE — no existing settings are removed.
 *
 * @package Affordable_Web_Solution
 * @since   1.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register header customizer settings & controls.
 *
 * Hooked to customize_register via functions.php.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function aws_header_customizer( WP_Customize_Manager $wp_customize ): void {

	/* ================================================================
	   PANEL: Header
	================================================================ */
	$wp_customize->add_panel( 'aws_header_panel', [
		'title'    => __( 'Header', 'affordable-web-solution' ),
		'priority' => 25, // Appears before "Agency Settings" panel (30)
	] );

	/* ================================================================
	   SECTION 1: Header Layout
	================================================================ */
	$wp_customize->add_section( 'aws_header_layout', [
		'title' => __( 'Header Layout', 'affordable-web-solution' ),
		'panel' => 'aws_header_panel',
	] );

	// --- Logo Position ---
	$wp_customize->add_setting( 'aws_header_logo_position', [
		'default'           => 'left',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_choices',
	] );
	$wp_customize->add_control( 'aws_header_logo_position', [
		'label'   => __( 'Logo Position', 'affordable-web-solution' ),
		'section' => 'aws_header_layout',
		'type'    => 'radio',
		'choices' => [
			'left'   => __( 'Left (default)', 'affordable-web-solution' ),
			'center' => __( 'Center', 'affordable-web-solution' ),
		],
	] );

	// --- Header Width ---
	$wp_customize->add_setting( 'aws_header_width', [
		'default'           => 'contained',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_choices',
	] );
	$wp_customize->add_control( 'aws_header_width', [
		'label'   => __( 'Header Width', 'affordable-web-solution' ),
		'section' => 'aws_header_layout',
		'type'    => 'radio',
		'choices' => [
			'contained'  => __( 'Contained (max-width)', 'affordable-web-solution' ),
			'full-width' => __( 'Full Width', 'affordable-web-solution' ),
		],
	] );

	// --- Sticky Header ---
	$wp_customize->add_setting( 'aws_header_sticky', [
		'default'           => '1',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_header_sticky', [
		'label'   => __( 'Sticky Header (fixed on scroll)', 'affordable-web-solution' ),
		'section' => 'aws_header_layout',
		'type'    => 'checkbox',
	] );

	// --- Transparent Header on Homepage ---
	$wp_customize->add_setting( 'aws_header_transparent_home', [
		'default'           => '0',
		'transport'         => 'refresh',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_header_transparent_home', [
		'label'       => __( 'Transparent Header on Homepage', 'affordable-web-solution' ),
		'description' => __( 'Makes header background transparent on the front page only.', 'affordable-web-solution' ),
		'section'     => 'aws_header_layout',
		'type'        => 'checkbox',
	] );

	// --- Header Padding ---
	$wp_customize->add_setting( 'aws_header_padding_top', [
		'default'           => 16,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'aws_header_padding_top', [
		'label'       => __( 'Header Padding (px)', 'affordable-web-solution' ),
		'description' => __( 'Top and bottom padding inside the header bar.', 'affordable-web-solution' ),
		'section'     => 'aws_header_layout',
		'type'        => 'range',
		'input_attrs' => [
			'min'  => 4,
			'max'  => 60,
			'step' => 2,
		],
	] );

	/* ================================================================
	   SECTION 2: Header Colors
	================================================================ */
	$wp_customize->add_section( 'aws_header_colors', [
		'title' => __( 'Header Colors', 'affordable-web-solution' ),
		'panel' => 'aws_header_panel',
	] );

	// Background color
	$wp_customize->add_setting( 'aws_header_bg_color', [
		'default'           => '#10512A',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_header_bg_color', [
			'label'   => __( 'Header Background', 'affordable-web-solution' ),
			'section' => 'aws_header_colors',
		] )
	);

	// Scrolled/sticky background
	$wp_customize->add_setting( 'aws_header_scrolled_bg_color', [
		'default'           => '#183D2D',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_header_scrolled_bg_color', [
			'label'       => __( 'Scrolled Header Background', 'affordable-web-solution' ),
			'description' => __( 'Header background color after the user scrolls down.', 'affordable-web-solution' ),
			'section'     => 'aws_header_colors',
		] )
	);

	// Bottom border color
	$wp_customize->add_setting( 'aws_header_border_color', [
		'default'           => 'rgba(198,255,77,0.12)',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_color_rgba',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_header_border_color', [
			'label'   => __( 'Header Bottom Border Color', 'affordable-web-solution' ),
			'section' => 'aws_header_colors',
		] )
	);

	// Nav link color
	$wp_customize->add_setting( 'aws_nav_link_color', [
		'default'           => '#FFFFFF',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_nav_link_color', [
			'label'   => __( 'Navigation Link Color', 'affordable-web-solution' ),
			'section' => 'aws_header_colors',
		] )
	);

	// Nav link hover color
	$wp_customize->add_setting( 'aws_nav_link_hover_color', [
		'default'           => '#C6FF4D',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_nav_link_hover_color', [
			'label'   => __( 'Navigation Link Hover Color', 'affordable-web-solution' ),
			'section' => 'aws_header_colors',
		] )
	);

	/* ================================================================
	   SECTION 3: Logo Settings  (OceanWP-style responsive sliders)
	================================================================ */
	$wp_customize->add_section( 'aws_logo_settings', [
		'title' => __( 'Logo', 'affordable-web-solution' ),
		'panel' => 'aws_header_panel',
	] );

	// -- Logo Max Width: Desktop --
	$wp_customize->add_setting( 'aws_logo_max_width', [
		'default'           => 200,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'aws_logo_max_width', [
		'label'       => __( 'Logo Max Width – Desktop (px)', 'affordable-web-solution' ),
		'section'     => 'aws_logo_settings',
		'type'        => 'range',
		'input_attrs' => [
			'min'  => 40,
			'max'  => 500,
			'step' => 5,
		],
	] );

	// -- Logo Max Width: Tablet --
	$wp_customize->add_setting( 'aws_logo_max_width_tablet', [
		'default'           => 160,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'aws_logo_max_width_tablet', [
		'label'       => __( 'Logo Max Width – Tablet (px)', 'affordable-web-solution' ),
		'section'     => 'aws_logo_settings',
		'type'        => 'range',
		'input_attrs' => [
			'min'  => 40,
			'max'  => 400,
			'step' => 5,
		],
	] );

	// -- Logo Max Width: Mobile --
	$wp_customize->add_setting( 'aws_logo_max_width_mobile', [
		'default'           => 120,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'aws_logo_max_width_mobile', [
		'label'       => __( 'Logo Max Width – Mobile (px)', 'affordable-web-solution' ),
		'section'     => 'aws_logo_settings',
		'type'        => 'range',
		'input_attrs' => [
			'min'  => 40,
			'max'  => 300,
			'step' => 5,
		],
	] );

	// -- Logo Max Height: Desktop --
	$wp_customize->add_setting( 'aws_logo_max_height', [
		'default'           => 60,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'aws_logo_max_height', [
		'label'       => __( 'Logo Max Height – Desktop (px)', 'affordable-web-solution' ),
		'section'     => 'aws_logo_settings',
		'type'        => 'range',
		'input_attrs' => [
			'min'  => 20,
			'max'  => 200,
			'step' => 2,
		],
	] );

	/* ================================================================
	   SECTION 4: Navigation Settings
	================================================================ */
	$wp_customize->add_section( 'aws_nav_settings', [
		'title' => __( 'Navigation', 'affordable-web-solution' ),
		'panel' => 'aws_header_panel',
	] );

	// Nav font size
	$wp_customize->add_setting( 'aws_nav_font_size', [
		'default'           => 15,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control( 'aws_nav_font_size', [
		'label'       => __( 'Navigation Font Size (px)', 'affordable-web-solution' ),
		'section'     => 'aws_nav_settings',
		'type'        => 'range',
		'input_attrs' => [
			'min'  => 11,
			'max'  => 24,
			'step' => 1,
		],
	] );

	// Nav font weight
	$wp_customize->add_setting( 'aws_nav_font_weight', [
		'default'           => '500',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_choices',
	] );
	$wp_customize->add_control( 'aws_nav_font_weight', [
		'label'   => __( 'Navigation Font Weight', 'affordable-web-solution' ),
		'section' => 'aws_nav_settings',
		'type'    => 'select',
		'choices' => [
			'400' => __( 'Normal (400)', 'affordable-web-solution' ),
			'500' => __( 'Medium (500)', 'affordable-web-solution' ),
			'600' => __( 'Semibold (600)', 'affordable-web-solution' ),
			'700' => __( 'Bold (700)', 'affordable-web-solution' ),
		],
	] );

	// Dropdown background color
	$wp_customize->add_setting( 'aws_dropdown_bg_color', [
		'default'           => '',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_dropdown_bg_color', [
			'label'       => __( 'Dropdown Background Color', 'affordable-web-solution' ),
			'description' => __( 'Leave blank to keep the default white dropdown background.', 'affordable-web-solution' ),
			'section'     => 'aws_nav_settings',
		] )
	);

	/* ================================================================
	   SECTION 5: Header CTA Button
	================================================================ */
	$wp_customize->add_section( 'aws_header_cta', [
		'title' => __( 'Header CTA Button', 'affordable-web-solution' ),
		'panel' => 'aws_header_panel',
	] );

	// Show/hide phone number
	$wp_customize->add_setting( 'aws_header_show_phone', [
		'default'           => '1',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'aws_sanitize_checkbox',
	] );
	$wp_customize->add_control( 'aws_header_show_phone', [
		'label'   => __( 'Show Phone Number in Header', 'affordable-web-solution' ),
		'section' => 'aws_header_cta',
		'type'    => 'checkbox',
	] );

	// CTA button background color (override)
	$wp_customize->add_setting( 'aws_header_cta_bg_color', [
		'default'           => '#C6FF4D',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_header_cta_bg_color', [
			'label'       => __( 'CTA Button Background', 'affordable-web-solution' ),
			'description' => __( 'Overrides the default accent color for the header CTA button only.', 'affordable-web-solution' ),
			'section'     => 'aws_header_cta',
		] )
	);

	// CTA button text color
	$wp_customize->add_setting( 'aws_header_cta_text_color', [
		'default'           => '#102117',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	] );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'aws_header_cta_text_color', [
			'label'   => __( 'CTA Button Text Color', 'affordable-web-solution' ),
			'section' => 'aws_header_cta',
		] )
	);
}
add_action( 'customize_register', 'aws_header_customizer' );
