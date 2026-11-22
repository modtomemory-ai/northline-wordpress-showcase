<?php
/** Default blog / archive fallback. */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main-content"><section class="page-hero"><div class="site-container"><span class="eyebrow"><?php esc_html_e( 'Ideas & Insights', 'northline' ); ?></span><h1><?php echo esc_html( is_home() ? __( 'The journal.', 'northline' ) : get_the_archive_title() ); ?></h1><p><?php esc_html_e( 'Thoughts on craftsmanship, space and design.', 'northline' ); ?></p></div></section><section class="section"><div class="site-container"><div class="post-card-list"><?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><article <?php post_class( 'post-card' ); ?>><span class="article-meta"><?php echo esc_html( get_the_date() ); ?></span><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p><a class="text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'northline' ); ?> ↗</a></article><?php endwhile; else : get_template_part( 'template-parts/content', 'none' ); endif; ?></div><?php the_posts_pagination(); ?></div></section></main>
<?php get_footer(); ?>
