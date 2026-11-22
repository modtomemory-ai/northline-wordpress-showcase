<?php
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) : the_post();
	?><main id="main-content"><article <?php post_class( 'article-wrap' ); ?>><div class="article-meta"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( get_the_author() ); ?></div><h1><?php the_title(); ?></h1><?php if ( has_post_thumbnail() ) : ?><figure class="article-featured"><?php the_post_thumbnail( 'large' ); ?></figure><?php endif; ?><div class="entry-content"><?php the_content(); wp_link_pages(); ?></div><?php if ( comments_open() || get_comments_number() ) comments_template(); ?></article></main><?php
endwhile;
get_footer();
