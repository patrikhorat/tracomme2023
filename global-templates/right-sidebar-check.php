<?php
/**
 * Right sidebar check
 *
 * @package Tracomme2023
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Closing the primary container from /global-templates/left-sidebar-check.php.
?>
</div><!-- #primary -->

<?php
$sidebar_pos = get_theme_mod( 'tracomme2023_sidebar_position' );

if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) {
	get_template_part( 'sidebar-templates/sidebar', 'right' );
}
