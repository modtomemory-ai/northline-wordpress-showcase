<?php
/** Archive for an individual sector term. */
defined( 'ABSPATH' ) || exit;
get_header();
$term = get_queried_object();
$terms = get_terms( array( 'taxonomy' => 'nl_sector', 'hide_empty' => true ) );
?>
<main id="main-content"><section class="page-hero"><div class="site-container"><span class="eyebrow"><?php esc_html_e( 'Project sector', 'northline' ); ?></span><h1><?php echo esc_html( single_term_title( '', false ) ); ?></h1><p><?php echo esc_html( term_description( $term->term_id ) ? wp_strip_all_tags( term_description( $term->term_id ) ) : __( 'Explore our projects in this design discipline.', 'northline' ) ); ?></p></div></section><section class="section"><div class="site-container"><nav class="archive-filter" aria-label="<?php esc_attr_e( 'Filter projects by sector', 'northline' ); ?>"><a href="<?php echo esc_url( get_post_type_archive_link( 'nl_project' ) ); ?>"><?php esc_html_e( 'All projects', 'northline' ); ?></a><?php if ( ! is_wp_error( $terms ) ) : foreach ( $terms as $other_term ) : ?><a class="<?php echo $term->term_id === $other_term->term_id ? 'is-active' : ''; ?>" <?php echo $term->term_id === $other_term->term_id ? 'aria-current="page"' : ''; ?> href="<?php echo esc_url( get_term_link( $other_term ) ); ?>"><?php echo esc_html( $other_term->name ); ?></a><?php endforeach; endif; ?></nav><div class="projects-grid"><?php if ( have_posts() ) : $index = 0; while ( have_posts() ) : the_post(); northline_project_card( get_the_ID(), $index++ ); endwhile; else : get_template_part( 'template-parts/content', 'none' ); endif; ?></div><?php the_posts_pagination(); ?></div></section></main>
<?php get_footer(); ?>
