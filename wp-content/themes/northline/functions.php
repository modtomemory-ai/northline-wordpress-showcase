<?php
/**
 * Northline Studio — a custom, dependency-free WordPress theme.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

define( 'NORTHLINE_THEME_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/customizer.php';

function northline_setup() {
	load_theme_textdomain( 'northline', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 150, 'width' => 400, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_editor_style( 'assets/css/main.css' );
	register_nav_menus( array( 'primary' => __( 'Primary navigation', 'northline' ), 'footer' => __( 'Footer navigation', 'northline' ) ) );
	add_image_size( 'northline-card', 960, 680, true );
}
add_action( 'after_setup_theme', 'northline_setup' );

function northline_enqueue_assets() {
	$css_path = get_template_directory() . '/assets/css/main.css';
	$js_path  = get_template_directory() . '/assets/js/site.js';
	wp_enqueue_style( 'northline-main', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime( $css_path ) );
	wp_enqueue_script( 'northline-site', get_template_directory_uri() . '/assets/js/site.js', array(), filemtime( $js_path ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'northline_enqueue_assets' );

/** Limit default excerpts without impacting stored post content. */
function northline_excerpt_length() {
	return 25;
}
add_filter( 'excerpt_length', 'northline_excerpt_length', 20 );

/** Keep document title readable on front page. */
function northline_document_title_separator() {
	return '—';
}
add_filter( 'document_title_separator', 'northline_document_title_separator' );
