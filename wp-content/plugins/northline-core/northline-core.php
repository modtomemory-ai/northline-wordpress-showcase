<?php
/**
 * Plugin Name: Northline Core
 * Description: Portable architecture portfolio content model and server-rendered Gutenberg project grid.
 * Version: 1.0.0
 * Requires at least: 6.6
 * Requires PHP: 8.0
 * Author: Gurwinder Singh
 * License: GPL-2.0-or-later
 * Text Domain: northline-core
 */

defined( 'ABSPATH' ) || exit;

/** Content models live in a plugin so content survives theme changes. */
function northline_core_register_content() {
	register_post_type( 'nl_project', array(
		'labels' => array(
			'name'          => __( 'Projects', 'northline-core' ),
			'singular_name' => __( 'Project', 'northline-core' ),
			'add_new_item'  => __( 'Add New Project', 'northline-core' ),
			'edit_item'     => __( 'Edit Project', 'northline-core' ),
		),
		'public'              => true,
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'projects', 'with_front' => false ),
		'menu_icon'           => 'dashicons-building',
		'show_in_rest'        => true,
		'rest_base'           => 'northline-projects',
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'          => array( 'nl_sector' ),
		'show_in_nav_menus'   => true,
		'exclude_from_search' => false,
	) );
	register_taxonomy( 'nl_sector', array( 'nl_project' ), array(
		'labels'            => array( 'name' => __( 'Project Sectors', 'northline-core' ), 'singular_name' => __( 'Project Sector', 'northline-core' ) ),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'project-sector', 'with_front' => false ),
	) );
	foreach ( northline_core_meta_fields() as $key => $label ) {
		register_post_meta( 'nl_project', $key, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function( $allowed, $meta_key, $post_id ) {
				return current_user_can( 'edit_post', (int) $post_id );
			},
		) );
	}
}
add_action( 'init', 'northline_core_register_content' );

function northline_core_meta_fields() {
	return array(
		'_nl_client'   => __( 'Client / project type', 'northline-core' ),
		'_nl_location' => __( 'Location', 'northline-core' ),
		'_nl_year'     => __( 'Project year', 'northline-core' ),
		'_nl_scope'    => __( 'Scope of work', 'northline-core' ),
	);
}

function northline_core_meta_box_register() {
	add_meta_box( 'northline_project_info', __( 'Project Details', 'northline-core' ), 'northline_core_meta_box_render', 'nl_project', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'northline_core_meta_box_register' );

function northline_core_meta_box_render( $post ) {
	wp_nonce_field( 'northline_save_project', 'northline_project_nonce' );
	foreach ( northline_core_meta_fields() as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		?><p><label for="<?php echo esc_attr( $key ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label><br /><input class="widefat" type="text" id="<?php echo esc_attr( $key ); ?>" name="northline_meta[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>" /></p><?php
	}
}

function northline_core_save_project( $post_id, $post ) {
	if ( 'nl_project' !== $post->post_type || wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$nonce = isset( $_POST['northline_project_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['northline_project_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'northline_save_project' ) ) {
		return;
	}
	$fields = isset( $_POST['northline_meta'] ) && is_array( $_POST['northline_meta'] ) ? wp_unslash( $_POST['northline_meta'] ) : array();
	foreach ( northline_core_meta_fields() as $key => $label ) {
		if ( array_key_exists( $key, $fields ) ) {
			$value = is_scalar( $fields[ $key ] ) ? sanitize_text_field( $fields[ $key ] ) : '';
			if ( '' === $value ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}
}
add_action( 'save_post_nl_project', 'northline_core_save_project', 10, 2 );

function northline_core_activate() {
	northline_core_register_content();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'northline_core_activate' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

/** Dynamic block: display up to 12 projects via a server-side WP_Query. */
function northline_core_register_block() {
	wp_register_script( 'northline-projects-block', plugins_url( 'assets/js/projects-block.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render' ), '1.0.0', true );
	wp_register_style( 'northline-projects-block', plugins_url( 'assets/css/projects-block.css', __FILE__ ), array(), '1.0.0' );
	register_block_type( __DIR__ . '/blocks/project-grid', array(
		'render_callback' => 'northline_core_render_projects_block',
	) );
}
add_action( 'init', 'northline_core_register_block' );

function northline_core_render_projects_block( $attributes ) {
	$count = min( 12, max( 1, absint( $attributes['count'] ?? 4 ) ) );
	$query = new WP_Query( array(
		'post_type' => 'nl_project', 'post_status' => 'publish', 'posts_per_page' => $count,
		'no_found_rows' => true, 'ignore_sticky_posts' => true,
	) );
	if ( ! $query->have_posts() ) {
		return '<p>' . esc_html__( 'No projects published yet.', 'northline-core' ) . '</p>';
	}
	ob_start();
	?><div class="northline-block-grid"><?php
	while ( $query->have_posts() ) {
		$query->the_post();
		?><article class="northline-block-card"><a href="<?php the_permalink(); ?>"><?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) );
		}
		?><h3><?php echo esc_html( get_the_title() ); ?></h3></a><p><?php echo esc_html( get_the_excerpt() ); ?></p></article><?php
	}
	?></div><?php
	wp_reset_postdata();
	return ob_get_clean();
}

/** Optional WP-CLI command. Never seeds public content during theme/plugin activation. */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'northline demo-seed', function() {
		$concepts = array(
			array( 'North Ridge Residence', 'Residential', 'A considered dialogue between landscape, shelter and natural light.', 'Concept project (fictional)', 'Hudson Valley, concept', '2026', 'Architecture / Spatial Design' ),
			array( 'The Civic Gallery', 'Cultural', 'A shared cultural space designed for openness and discovery.', 'Concept project (fictional)', 'Boston, concept', '2026', 'Cultural / Public Spaces' ),
			array( 'Pinewood Retreat', 'Hospitality', 'A quiet retreat shaped by its relationship with nature.', 'Concept project (fictional)', 'Maine, concept', '2026', 'Architecture / Interiors' ),
			array( 'Courtyard House', 'Residential', 'An intimate reinterpretation of the traditional courtyard.', 'Concept project (fictional)', 'Connecticut, concept', '2026', 'Residential / Spatial Design' ),
		);
		$added = 0;
		foreach ( $concepts as $item ) {
			$slug = sanitize_title( $item[0] );
			if ( get_page_by_path( $slug, OBJECT, 'nl_project' ) ) {
				continue;
			}
			$post_id = wp_insert_post( array(
				'post_type'    => 'nl_project', 'post_title' => $item[0], 'post_name' => $slug,
				'post_status'  => 'publish', 'post_excerpt' => $item[2],
				'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $item[2] ) . '</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Fictional concept case study generated for demonstration purposes; not a real client commission.</p><!-- /wp:paragraph -->',
			), true );
			if ( is_wp_error( $post_id ) ) {
				WP_CLI::warning( $post_id->get_error_message() );
				continue;
			}
			wp_set_object_terms( $post_id, $item[1], 'nl_sector' );
			foreach ( array( '_nl_client' => $item[3], '_nl_location' => $item[4], '_nl_year' => $item[5], '_nl_scope' => $item[6] ) as $key => $value ) {
				update_post_meta( $post_id, $key, $value );
			}
			$added++;
		}
		WP_CLI::success( sprintf( '%d concept projects created. Existing slugs were not duplicated.', $added ) );
	} );
}
