<?php
/*
Template Name: Category Archive
*/
get_header(); ?>


<!-- Display pretty title with embedded category name -->
<div class=" et_pb_row et_pb_row_1">
  <style>.et_pb_row_1 {background-color: #edd5d1;}</style>
  <div class="et_pb_column et_pb_column_4_4  et_pb_column_3">
    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center allura-textbig et_pb_text_1">
    <!-- Need to get category name here and stuff it into my_category -->
      <?php
        $my_category = single_cat_title("", false);
        $my_title = 'Read Stories On ' . $my_category . ' To Inspire';
        $my_output = '<p><a href="http://fsl-nokat.dev/' . strtolower( $my_category ) . '-archive/"><span style="color: #ffffff;">' . $my_title . '</span></a></p>';
        echo $my_output;
       ?>
    </div> <!-- .et_pb_text -->
  </div> <!-- .et_pb_column -->
</div>

<!-- Display category intro description -->
<div class=" et_pb_row et_pb_row_2">
  <div class="et_pb_column et_pb_column_4_4  et_pb_column_4">
    <div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_2">
      <?php echo '<p>' . category_description(  ) .  '</p>'; ?>
    </div> <!-- .et_pb_text -->
  </div> <!-- .et_pb_column -->
</div>



  <div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					$post_format = et_pb_post_format(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								$first_video
							);
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						elseif ( 'gallery' === $post_format ) :
							et_pb_gallery_images();
						endif;
					} ?>

				<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
					<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
							truncate_post( 540 );
				              ?><p>
				                <a href="<?php the_permalink(); ?>" class="more-link">read more</a></p>
				              <?php
						} else {
							the_content();
						}
					?>
				<?php endif; ?>

					</article> <!-- .et_pb_post -->
			<?php
					endwhile;

					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			?>
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->



<?php get_footer(); ?>
