<?php
/** Editorial home page: custom PHP template, native WordPress content. */
defined( 'ABSPATH' ) || exit;
get_header();
$project_archive = post_type_exists( 'nl_project' ) ? get_post_type_archive_link( 'nl_project' ) : '';
$project_link    = $project_archive ?: home_url( '/#work' );
?>
<main id="main-content">
	<section class="hero" aria-labelledby="hero-title">
		<div class="site-container hero__layout">
			<div class="hero__copy"><span class="eyebrow"><?php echo esc_html( northline_setting( 'northline_eyebrow', 'Architecture & Spatial Design' ) ); ?></span>
				<h1 class="hero__title" id="hero-title"><?php echo esc_html( northline_setting( 'northline_title', 'Places with purpose. Spaces with soul.' ) ); ?></h1>
				<p class="hero__description"><?php echo esc_html( northline_setting( 'northline_intro', 'Thoughtfully designed environments where material, light and human experience come together.' ) ); ?></p>
				<a class="button" href="#work"><?php esc_html_e( 'Explore selected work', 'northline' ); ?><span class="arrow" aria-hidden="true">↗</span></a>
			</div>
			<div class="hero__visual"><img src="<?php echo esc_url( northline_asset_url( 'hero-architecture.svg' ) ); ?>" alt="<?php esc_attr_e( 'Original illustration of a modern concrete and timber architectural structure', 'northline' ); ?>" width="900" height="1080" fetchpriority="high" /><span class="hero__vertical"><?php esc_html_e( 'Form follows feeling — design study', 'northline' ); ?></span><div class="hero__badge"><strong>01 / 04</strong><span><?php esc_html_e( 'Original concept studies', 'northline' ); ?></span></div></div>
		</div>
	</section>
	<div class="trust-strip" aria-label="<?php esc_attr_e( 'Studio design principles', 'northline' ); ?>"><div class="site-container trust-strip__inner"><span class="trust-strip__text"><?php esc_html_e( 'Designed with intention', 'northline' ); ?></span><div class="trust-stat"><strong>01</strong><span><?php esc_html_e( 'Human-centered', 'northline' ); ?></span></div><div class="trust-stat"><strong>02</strong><span><?php esc_html_e( 'Material-led', 'northline' ); ?></span></div><div class="trust-stat"><strong>03</strong><span><?php esc_html_e( 'Built to last', 'northline' ); ?></span></div></div></div>
	<section class="section" id="work" aria-labelledby="work-title"><div class="site-container"><div class="section-heading"><div><span class="eyebrow"><?php esc_html_e( 'Portfolio / Selected Work', 'northline' ); ?></span><h2 class="section-title" id="work-title"><?php esc_html_e( 'Spaces that tell a story.', 'northline' ); ?></h2></div><p class="section-intro"><?php esc_html_e( 'Four design studies exploring the dialogue between architecture, nature and the way we live. Illustrative concept work unless replaced with real projects.', 'northline' ); ?></p></div>
			<div class="projects-grid">
			<?php
			$projects = post_type_exists( 'nl_project' ) ? new WP_Query( array( 'post_type' => 'nl_project', 'post_status' => 'publish', 'posts_per_page' => 4, 'no_found_rows' => true, 'ignore_sticky_posts' => true ) ) : null;
			if ( $projects && $projects->have_posts() ) {
				$i = 0;
				while ( $projects->have_posts() ) {
					$projects->the_post();
					northline_project_card( get_the_ID(), $i++ );
				}
				wp_reset_postdata();
			} else {
				for ( $i = 0; $i < 4; $i++ ) {
					northline_concept_card( $i );
				}
			}
			?>
			</div>
			<?php if ( $project_archive && $projects && $projects->post_count > 0 ) : ?><div class="projects-footer"><a class="button button--outline" href="<?php echo esc_url( $project_archive ); ?>"><?php esc_html_e( 'Explore all projects', 'northline' ); ?><span aria-hidden="true">↗</span></a></div><?php endif; ?>
		</div></section>
	<section class="approach" id="approach" aria-labelledby="approach-title"><div class="site-container"><div class="approach__inner"><div class="approach__copy"><span class="eyebrow"><?php esc_html_e( 'Thoughtful by design', 'northline' ); ?></span><h2 class="section-title" id="approach-title"><?php esc_html_e( 'Less, but infinitely better.', 'northline' ); ?></h2><p><?php esc_html_e( 'Good architecture begins with listening. Every line, material and detail should serve a clear purpose — creating spaces that feel as meaningful as they look.', 'northline' ); ?></p><a class="button button--light" href="#contact"><?php esc_html_e( 'Our design philosophy', 'northline' ); ?><span aria-hidden="true">↗</span></a></div><div class="approach__art"><img src="<?php echo esc_url( northline_asset_url( 'approach-detail.svg' ) ); ?>" alt="" loading="lazy" width="650" height="570" /></div></div><div class="approach__methods"><div><strong><?php esc_html_e( '01 / Discover', 'northline' ); ?></strong><span><?php esc_html_e( 'Understand context and intent', 'northline' ); ?></span></div><div><strong><?php esc_html_e( '02 / Define', 'northline' ); ?></strong><span><?php esc_html_e( 'Create a coherent design language', 'northline' ); ?></span></div><div><strong><?php esc_html_e( '03 / Detail', 'northline' ); ?></strong><span><?php esc_html_e( 'Make every element purposeful', 'northline' ); ?></span></div></div></div></section>
	<section class="section" id="journal" aria-labelledby="journal-title"><div class="site-container"><div class="section-heading"><div><span class="eyebrow"><?php esc_html_e( 'From the journal', 'northline' ); ?></span><h2 class="section-title" id="journal-title"><?php esc_html_e( 'Notes on good design.', 'northline' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/?post_type=post' ) ); ?>"><?php esc_html_e( 'Read the journal', 'northline' ); ?> ↗</a></div><div class="journal-grid">
			<?php
			$journal = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
			if ( $journal->have_posts() ) {
				while ( $journal->have_posts() ) {
					$journal->the_post();
					?><article class="journal-card"><span class="journal-card__tag"><?php esc_html_e( 'Journal', 'northline' ); ?></span><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( get_the_excerpt() ); ?></p><span class="journal-card__date"><?php echo esc_html( get_the_date() ); ?></span></article><?php
				}
				wp_reset_postdata();
			} else {
				$journal_samples = array(
					array( 'The quiet power of natural light', 'How thoughtful daylighting changes the way a space feels.' ),
					array( 'A case for material honesty', 'Why timeless architecture starts with a considered palette.' ),
					array( 'A landscape-led design process', 'Finding the right balance between built form and living context.' ),
				);
				foreach ( $journal_samples as $sample ) {
					?><article class="journal-card"><span class="journal-card__tag"><?php esc_html_e( 'Editorial concept · demo', 'northline' ); ?></span><h3><?php echo esc_html( $sample[0] ); ?></h3><p><?php echo esc_html( $sample[1] ); ?></p></article><?php
				}
			}
			?>
		</div></div></section>
	<section class="section" id="contact" aria-labelledby="contact-title" style="padding-top:0"><div class="site-container"><div class="cta-panel"><div><span class="eyebrow"><?php esc_html_e( 'Your vision, thoughtfully realized', 'northline' ); ?></span><h2 id="contact-title"><?php esc_html_e( 'Great spaces begin with a conversation.', 'northline' ); ?></h2></div><a class="button" href="<?php echo esc_url( 'mailto:' . sanitize_email( northline_setting( 'northline_email', 'hello@example.com' ) ) ); ?>"><?php esc_html_e( 'Say hello', 'northline' ); ?><span aria-hidden="true">↗</span></a></div></div></section>
</main>
<?php get_footer(); ?>
