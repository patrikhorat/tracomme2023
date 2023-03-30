<?php
/**
 * Custom hooks
 *
 * @package Tracomme2023
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'tracomme2023_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function tracomme2023_site_info() {
		do_action( 'tracomme2023_site_info' );
	}
}

add_action( 'tracomme2023_site_info', 'tracomme2023_add_site_info' );
if ( ! function_exists( 'tracomme2023_add_site_info' ) ) {
	/**
	 * Add site info content.
	 */
	function tracomme2023_add_site_info() {
		$the_theme = wp_get_theme();

		$site_info = sprintf(
			'<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s(%4$s)',
			esc_url( __( 'https://wordpress.org/', 'tracomme2023' ) ),
			sprintf(
				/* translators: WordPress */
				esc_html__( 'Proudly powered by %s', 'tracomme2023' ),
				'WordPress'
			),
			sprintf(
				/* translators: 1: Theme name, 2: Theme author */
				esc_html__( 'Theme: %1$s by %2$s.', 'tracomme2023' ),
				$the_theme->get( 'Name' ), // @phpstan-ignore-line -- theme exists
				'<a href="' . esc_url( __( 'https://tracomme2023.com', 'tracomme2023' ) ) . '">tracomme2023.com</a>'
			),
			sprintf(
				/* translators: Theme version */
				esc_html__( 'Version: %s', 'tracomme2023' ),
				$the_theme->get( 'Version' ) // @phpstan-ignore-line -- theme exists
			)
		);

		// Check if customizer site info has value.
		if ( get_theme_mod( 'tracomme2023_site_info_override' ) ) {
			$site_info = get_theme_mod( 'tracomme2023_site_info_override' );
		}

		echo apply_filters( 'tracomme2023_site_info_content', $site_info ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
}
