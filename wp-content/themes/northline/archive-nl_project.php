<?php
/** Server-rendered custom post type archive with native taxonomy filtering. */
defined( 'ABSPATH' ) || exit;
get_header();
$terms        = get_terms( array( 'taxonomy' => 'nl_sector', 'hide_empty' => true ) );
$archive_link = get_post_type_archive_link( 'nl_project' );
?>
<main id="main-content"><section class="page-hero"><div class="site-container"><span class="eyebrow"><?php esc_html_e( 'Our portfolio', 'northline' ); ?></span><h1><?php esc_html_e( 'Selected projects.', 'northline' ); ?></h1><p><?php esc_html_e( 'Browse our project studies. Content is managed through a custom WordPress post type and taxonomy.', 'northline' ); ?></p></div></section><section class="section"><div class="site-container"><nav class="archive-filter" aria-label="<?php esc_attr_e( 'Filter projects by sector', 'northline' ); ?>"><a href="<?php echo esc_url( $archive_link ); ?>" class="is-active" aria-current="page"><?php esc_html_e( 'All projects', 'northline' ); ?></a><?php if ( ! is_wp_error( $terms ) ) : foreach ( $terms as $term ) : ?><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a><?php endforeach; endif; ?></nav><div class="projects-grid"><?php if ( have_posts() ) : $index = 0; while ( have_posts() ) : the_post(); northline_project_card( get_the_ID(), $index++ ); endwhile; else : get_template_part( 'template-parts/content', 'none' ); endif; ?></div><?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( '← Previous', 'northline' ), 'next_text' => __( 'Next →', 'northline' ) ) ); ?></div></section></main>
<?php get_footer(); ?>
