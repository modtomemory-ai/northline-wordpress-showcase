<?php
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) : the_post();
	?><main id="main-content"><article <?php post_class( 'article-wrap' ); ?>><span class="eyebrow"><?php esc_html_e( 'Northline Studio', 'northline' ); ?></span><h1><?php the_title(); ?></h1><div class="entry-content"><?php the_content(); wp_link_pages(); ?></div></article></main><?php
endwhile;
get_footer();
