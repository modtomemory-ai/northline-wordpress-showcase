<?php
/** Escaped, reusable template helpers. */
defined( 'ABSPATH' ) || exit;

function northline_setting( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

function northline_asset_url( $filename ) {
	return get_template_directory_uri() . '/assets/images/' . rawurlencode( $filename );
}

function northline_brand() {
	?>
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%s, homepage', 'northline' ), get_bloginfo( 'name' ) ) ); ?>">
		<span class="brand__mark" aria-hidden="true"></span>
		<span><span class="brand__text">NORTHLINE</span><span class="brand__sub">DESIGN STUDIO</span></span>
	</a>
	<?php
}

function northline_fallback_menu() {
	?>
	<ul class="site-nav__list">
		<li><a href="<?php echo esc_url( get_post_type_archive_link( 'nl_project' ) ? get_post_type_archive_link( 'nl_project' ) : home_url( '/#work' ) ); ?>"><?php esc_html_e( 'Projects', 'northline' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/#approach' ) ); ?>"><?php esc_html_e( 'Approach', 'northline' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/#journal' ) ); ?>"><?php esc_html_e( 'Journal', 'northline' ); ?></a></li>
	</ul>
	<?php
}

/** Choose a consistent visual when a project has no assigned featured image. */
function northline_project_illustration( $index = 0 ) {
	$images = array( 'project-residence.svg', 'project-gallery.svg', 'project-retreat.svg', 'project-courtyard.svg' );
	return northline_asset_url( $images[ absint( $index ) % count( $images ) ] );
}

function northline_project_card( $post_id, $index = 0 ) {
	$post_id = absint( $post_id );
	$title   = get_the_title( $post_id );
	$url     = get_permalink( $post_id );
	$terms   = get_the_terms( $post_id, 'nl_sector' );
	$sector  = is_array( $terms ) && ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->name : __( 'Selected work', 'northline' );
	$year    = get_post_meta( $post_id, '_nl_year', true );
	?>
	<a class="project-card" href="<?php echo esc_url( $url ); ?>">
		<div class="project-card__visual">
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $post_id, 'northline-card', array( 'loading' => 'lazy', 'alt' => $title ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WordPress thumbnail HTML. ?>
			<?php else : ?>
				<img src="<?php echo esc_url( northline_project_illustration( $index ) ); ?>" alt="" loading="lazy" width="1200" height="840" />
			<?php endif; ?>
			<span class="project-card__number"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
		</div>
		<div class="project-card__details"><div><div class="project-card__meta"><?php echo esc_html( $sector ); ?><?php echo $year ? ' · ' . esc_html( $year ) : ''; ?></div><h3 class="project-card__title"><?php echo esc_html( $title ); ?></h3><p class="project-card__excerpt"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p></div><span class="project-card__arrow" aria-hidden="true">↗</span></div>
	</a>
	<?php
}

/** Illustrated placeholders are explicitly labeled concept examples, never client work. */
function northline_concept_card( $index ) {
	$concepts = array(
		array( 'North Ridge Residence', 'Residential · Concept study', 'A considered dialogue between landscape, shelter and natural light.' ),
		array( 'The Civic Gallery', 'Cultural · Concept study', 'A shared cultural space designed for openness and discovery.' ),
		array( 'Pinewood Retreat', 'Hospitality · Concept study', 'A quiet retreat shaped by its relationship with nature.' ),
		array( 'Courtyard House', 'Residential · Concept study', 'An intimate reinterpretation of the traditional courtyard.' ),
	);
	if ( ! isset( $concepts[ $index ] ) ) {
		return;
	}
	$item = $concepts[ $index ];
	?>
	<div class="project-card">
		<div class="project-card__visual"><img src="<?php echo esc_url( northline_project_illustration( $index ) ); ?>" alt="" loading="lazy" width="1200" height="840" /><span class="project-card__number"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span></div>
		<div class="project-card__details"><div><div class="project-card__meta"><?php echo esc_html( $item[1] ); ?></div><h3 class="project-card__title"><?php echo esc_html( $item[0] ); ?></h3><p class="project-card__excerpt"><?php echo esc_html( $item[2] ); ?></p></div><span class="project-card__arrow" aria-hidden="true">↗</span></div>
	</div>
	<?php
}
