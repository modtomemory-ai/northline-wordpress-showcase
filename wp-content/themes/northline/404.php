<?php
defined( 'ABSPATH' ) || exit;
get_header();
?><main id="main-content"><section class="page-hero"><div class="site-container"><span class="eyebrow">404 / <?php esc_html_e( 'Page not found', 'northline' ); ?></span><h1><?php esc_html_e( 'A different direction.', 'northline' ); ?></h1><p><?php esc_html_e( 'The page you requested could not be found. Take a look around instead.', 'northline' ); ?></p><a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return home', 'northline' ); ?> ↗</a></div></section></main><?php get_footer(); ?>
