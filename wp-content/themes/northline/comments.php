<?php
defined( 'ABSPATH' ) || exit;
if ( post_password_required() ) return;
?>
<section id="comments" class="comments-area"><h2><?php echo esc_html( sprintf( _n( '%s comment', '%s comments', get_comments_number(), 'northline' ), number_format_i18n( get_comments_number() ) ) ); ?></h2><?php if ( have_comments() ) : ?><ol class="comment-list"><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?></ol><?php the_comments_pagination(); ?><?php endif; ?><?php comment_form(); ?></section>
