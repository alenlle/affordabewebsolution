/**
 * Affordable Web Solution – Customizer Live Preview
 *
 * Handles postMessage transport for real-time preview in the
 * WordPress Customizer without full page reloads.
 *
 * Settings using transport: 'postMessage' update the preview instantly.
 * Settings using transport: 'refresh' will still work, just trigger a
 * full reload.
 *
 * @package Affordable_Web_Solution
 * @since   1.1.0
 */

( function ( $, api ) {
	'use strict';

	/* ─── Utility: inject or update a <style> block ────────────────── */
	function setCss( id, css ) {
		var el = $( '#aws-live-' + id );
		if ( ! el.length ) {
			$( 'head' ).append( '<style id="aws-live-' + id + '">' + css + '</style>' );
		} else {
			el.html( css );
		}
	}

	/* ─── Header: background color ─────────────────────────────────── */
	api( 'aws_header_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'header-bg', '.site-header { background: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Header: scrolled background color ────────────────────────── */
	api( 'aws_header_scrolled_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'header-scrolled-bg', '.site-header.scrolled { background: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Header: bottom border color ──────────────────────────────── */
	api( 'aws_header_border_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'header-border', '.site-header { border-bottom-color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Header: padding ───────────────────────────────────────────── */
	api( 'aws_header_padding_top', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'header-pad', '.site-header { padding: ' + newval + 'px 0 !important; }' );
		} );
	} );

	/* ─── Navigation: link color ────────────────────────────────────── */
	api( 'aws_nav_link_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'nav-color', '.nav-link { color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Navigation: hover color ───────────────────────────────────── */
	api( 'aws_nav_link_hover_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'nav-hover',
				'.nav-link:hover, .nav-item:hover > .nav-link { color: ' + newval + ' !important; }'
			);
		} );
	} );

	/* ─── Navigation: font size ─────────────────────────────────────── */
	api( 'aws_nav_font_size', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'nav-fs', '.nav-link { font-size: ' + newval + 'px !important; }' );
		} );
	} );

	/* ─── Navigation: font weight ───────────────────────────────────── */
	api( 'aws_nav_font_weight', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'nav-fw', '.nav-link { font-weight: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Dropdown background ───────────────────────────────────────── */
	api( 'aws_dropdown_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			if ( newval ) {
				setCss( 'dropdown-bg', '.dropdown, ul.primary-menu .sub-menu { background: ' + newval + ' !important; }' );
			} else {
				$( '#aws-live-dropdown-bg' ).remove();
			}
		} );
	} );

	/* ─── CTA button ────────────────────────────────────────────────── */
	api( 'aws_header_cta_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'cta-bg', '.btn-accent { background: ' + newval + ' !important; }' );
		} );
	} );

	api( 'aws_header_cta_text_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'cta-txt', '.btn-accent { color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Logo sizing: Desktop ──────────────────────────────────────── */
	api( 'aws_logo_max_width', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'logo-w', '.site-logo img, .custom-logo { max-width: ' + newval + 'px !important; }' );
		} );
	} );

	api( 'aws_logo_max_height', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'logo-h', '.site-logo img, .custom-logo { max-height: ' + newval + 'px !important; }' );
		} );
	} );

	/* ─── Logo sizing: Tablet ───────────────────────────────────────── */
	api( 'aws_logo_max_width_tablet', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'logo-w-tablet',
				'@media (max-width:1024px){ .site-logo img, .custom-logo { max-width: ' + newval + 'px !important; } }'
			);
		} );
	} );

	/* ─── Logo sizing: Mobile ───────────────────────────────────────── */
	api( 'aws_logo_max_width_mobile', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'logo-w-mobile',
				'@media (max-width:767px){ .site-logo img, .custom-logo { max-width: ' + newval + 'px !important; } }'
			);
		} );
	} );

	/* ─── Footer: background ────────────────────────────────────────── */
	api( 'aws_footer_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'footer-bg', '.site-footer { background: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Footer: heading color ─────────────────────────────────────── */
	api( 'aws_footer_heading_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'footer-head', '.footer-col h4, .site-footer h4 { color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Footer: text color ────────────────────────────────────────── */
	api( 'aws_footer_text_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'footer-txt', '.footer-desc, .site-footer p { color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Footer: link color ────────────────────────────────────────── */
	api( 'aws_footer_link_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'footer-link', '.footer-link { color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Footer: link hover color ──────────────────────────────────── */
	api( 'aws_footer_link_hover_color', function ( value ) {
		value.bind( function ( newval ) {
			setCss( 'footer-link-hover', '.footer-link:hover { color: ' + newval + ' !important; }' );
		} );
	} );

	/* ─── Footer: bottom bar background ────────────────────────────── */
	api( 'aws_footer_bottom_bg_color', function ( value ) {
		value.bind( function ( newval ) {
			if ( newval ) {
				setCss( 'footer-bot-bg', '.footer-bottom { background: ' + newval + ' !important; }' );
			} else {
				$( '#aws-live-footer-bot-bg' ).remove();
			}
		} );
	} );

	/* ─── Footer: CTA strip heading ─────────────────────────────────── */
	api( 'aws_footer_cta_heading', function ( value ) {
		value.bind( function ( newval ) {
			$( '.aws-footer-cta-heading' ).text( newval );
		} );
	} );

	/* ─── Footer: CTA strip subtext ─────────────────────────────────── */
	api( 'aws_footer_cta_subtext', function ( value ) {
		value.bind( function ( newval ) {
			$( '.aws-footer-cta-subtext' ).text( newval );
		} );
	} );

	/* ─── Footer: CTA button text ───────────────────────────────────── */
	api( 'aws_footer_cta_btn_text', function ( value ) {
		value.bind( function ( newval ) {
			$( '.aws-footer-cta-btn' ).text( newval );
		} );
	} );

	/* ─── Footer: description ───────────────────────────────────────── */
	api( 'aws_footer_description', function ( value ) {
		value.bind( function ( newval ) {
			$( '.footer-desc' ).first().text( newval );
		} );
	} );

} )( jQuery, wp.customize );
