<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Trendy News
 */
use TrendyNews\CustomizerDefault as TND;
$single_post_element_order = TND\trendy_news_get_customizer_option( 'single_post_element_order' );
$single_post_meta_order = TND\trendy_news_get_customizer_option( 'single_post_meta_order' );
?>
<article <?php trendy_news_schema_article_attributes(); ?> id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner">
		<header class="entry-header">
			<?php
				foreach( $single_post_element_order as $element_order ) :
					if( $element_order['option'] ) {
						switch( $element_order['value'] ) {
							case 'categories': the_category();
												break;
							case 'title': the_title( '<h1 class="entry-title"' .trendy_news_schema_article_name_attributes(). '>', '</h1>' );
												break;
							case 'meta':	if ( 'post' === get_post_type() ) :
												?>
												<div class="entry-meta">
													<?php
														foreach( $single_post_meta_order as $meta_order ) :
															if( $meta_order['option'] ) {
																switch( $meta_order['value'] ) {
																	case 'author': trendy_news_posted_by();
																				break;
																	case 'date': trendy_news_posted_on();
																				break;
																	case 'comments': trendy_news_comments_number();
																				break;
																	case 'read-time': echo '<span class="read-time">' .absint(trendy_news_post_read_time( get_the_content() )). ' ' .esc_html__( 'mins', 'trendy-news' ). '</span>';
																				break;
																	default: '';
																}
															}
														endforeach;
													?>
												</div><!-- .entry-meta -->
											<?php endif;
											break;
							case 'thumbnail':	trendy_news_post_thumbnail();
														break;
							default: '';
						}
					}
				endforeach;
			?>
		</header><!-- .entry-header -->

		<div <?php trendy_news_schema_article_body_attributes(); ?> class="entry-content">
			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'trendy-news' ),
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
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'trendy-news' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php trendy_news_tags_list(); ?>
			<?php trendy_news_entry_footer(); ?>
		</footer><!-- .entry-footer -->
		<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle"><i class="fas fa-angle-double-left"></i>' . esc_html__( 'Previous:', 'trendy-news' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'trendy-news' ) . '<i class="fas fa-angle-double-right"></i></span> <span class="nav-title">%title</span>',
				)
			);
		?>
	</div>
	<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php
	/**
	 * hook - trendy_news_single_post_append_hook
	 * 
	 */
	do_action( 'trendy_news_single_post_append_hook' );
?>