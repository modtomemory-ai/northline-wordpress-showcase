<?php
/** @package Northline */
defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to main content', 'northline' ); ?></a>
<header class="site-header" role="banner">
	<div class="site-container site-header__inner">
		<?php northline_brand(); ?>
		<button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="primary-navigation"><span><?php esc_html_e( 'Menu', 'northline' ); ?></span><span class="menu-toggle__bars" aria-hidden="true"><span></span><span></span><span></span></span></button>
		<nav class="site-nav" id="primary-navigation" data-site-nav aria-label="<?php esc_attr_e( 'Primary navigation', 'northline' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'site-nav__list', 'container' => false, 'fallback_cb' => 'northline_fallback_menu', 'depth' => 1 ) ); ?>
			<a class="nav-cta" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Start a project', 'northline' ); ?><span aria-hidden="true">↗</span></a>
		</nav>
	</div>
</header>
