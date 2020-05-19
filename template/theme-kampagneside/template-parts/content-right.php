<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Kampagneside
 */

?>
<div id="postviewright">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<script>
	test = document.getElementById('post-');
	test.style.display = "none";
</script>
	
	<div class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
		<?php endif; ?>
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Læs mere<span class="screen-reader-text"> "%s"</span>', 'kampagneside' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kampagneside' ),
				'after'  => '</div>',
			)
		);	
		?>
	</div><!-- .entry-header -->
	<div class="divimg">
		<?php kampagneside_post_thumbnail(); ?>
	</div>

	<!-- <footer class="entry-footer">
		<?php //kampagneside_entry_footer(); ?>
	</footer>.entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</div>