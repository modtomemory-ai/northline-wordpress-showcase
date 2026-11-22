<?php
/** @package Northline */
defined( 'ABSPATH' ) || exit;
$email = sanitize_email( northline_setting( 'northline_email', 'hello@example.com' ) );
?>
<footer class="site-footer">
	<div class="site-container">
		<div class="footer-main">
			<div><?php northline_brand(); ?><p class="footer-about"><?php esc_html_e( 'Architecture with clarity, care and a deep connection to place. A fictional studio used as an original WordPress engineering demonstration.', 'northline' ); ?></p></div>
			<div><h2 class="footer-label"><?php esc_html_e( 'Explore', 'northline' ); ?></h2><ul class="footer-links"><li><a href="<?php echo esc_url( home_url( '/#work' ) ); ?>"><?php esc_html_e( 'Selected projects', 'northline' ); ?></a></li><li><a href="<?php echo esc_url( home_url( '/#approach' ) ); ?>"><?php esc_html_e( 'Our approach', 'northline' ); ?></a></li><li><a href="<?php echo esc_url( home_url( '/#journal' ) ); ?>"><?php esc_html_e( 'Journal', 'northline' ); ?></a></li></ul></div>
			<div><h2 class="footer-label"><?php esc_html_e( 'Get in touch', 'northline' ); ?></h2><ul class="footer-links"><li><a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a></li><li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Discuss a project', 'northline' ); ?></a></li></ul></div>
		</div>
		<div class="footer-end"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Northline Studio · <?php esc_html_e( 'Fictional concept demonstration', 'northline' ); ?></span><span><?php esc_html_e( 'Bespoke design. Built with native WordPress.', 'northline' ); ?></span></div>
	</div>
</footer>
<?php wp_footer(); ?>
</body></html>
