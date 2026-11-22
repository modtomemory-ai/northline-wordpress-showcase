<?php
/** Single project details sourced from the Northline Core plugin. */
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) : the_post();
	$project_id = get_the_ID();
	$details = array(
		__( 'Client', 'northline' ) => get_post_meta( $project_id, '_nl_client', true ),
		__( 'Location', 'northline' ) => get_post_meta( $project_id, '_nl_location', true ),
		__( 'Year', 'northline' ) => get_post_meta( $project_id, '_nl_year', true ),
		__( 'Scope', 'northline' ) => get_post_meta( $project_id, '_nl_scope', true ),
	);
	?>
	<main id="main-content"><section class="page-hero"><div class="site-container"><span class="eyebrow"><?php esc_html_e( 'Selected Project / Case Study', 'northline' ); ?></span><h1><?php the_title(); ?></h1><p><?php echo esc_html( get_the_excerpt() ); ?></p></div></section><div class="site-container"><div class="project-hero-visual"><?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'full', array( 'alt' => get_the_title() ) ); else : ?><img src="<?php echo esc_url( northline_project_illustration( $project_id ) ); ?>" alt="" width="1200" height="840" /><?php endif; ?></div><dl class="project-details"><?php foreach ( $details as $label => $value ) : if ( '' !== $value ) : ?><div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div><?php endif; endforeach; ?></dl></div><article class="article-wrap" style="margin-top:50px"><div class="entry-content"><?php the_content(); wp_link_pages(); ?></div><p><a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'nl_project' ) ); ?>"><?php esc_html_e( '← Back to all projects', 'northline' ); ?></a></p></article></main>
	<?php
endwhile;
get_footer();
