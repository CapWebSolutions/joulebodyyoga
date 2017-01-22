<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

$show_navigation = get_post_meta( get_the_ID(), '_et_pb_project_nav', true );

?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<div class="et_main_title">
						<h1 class="entry-title"><?php echo the_title(); ?></h1>

					</div>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_portfolio_single_image_width', 1080 );
					$height = (int) apply_filters( 'et_pb_portfolio_single_image_height', 9999 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Projectimage' );
					$thumb = $thumbnail["thumb"];
					$page_layout = get_post_meta( get_the_ID(), '_et_pb_page_layout', true );
					if ( '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
					if ( $post->post_content!=="" ) {
						the_content();
					} else {
 
						echo '<p class="recipe-section-label">Did you know: </p><div class="recipe-section-data">' . get_field('did_you_know') . '</div><br>';
						if ( get_field( 'tip' ) ) {
							echo '<p class="recipe-section-label">Tip: </p><div class="recipe-section-data">' . get_field('tip') . '</div><br>';
						}
						// $my_line = the_field( "cooking_time" );
						// echo $my_line;
						echo '<p class="recipe-section-label">Cooking Time: <div class="recipe-section-data">'  . get_field( 'cooking_time' ) . '</div></p><br>';
						echo '<p class="recipe-section-label">Ingredients: </p><div class="recipe-section-data">' . get_field( 'ingredients' ) . '</div><br>';
						echo '<p class="recipe-section-label">Instructions: </p><div class="recipe-section-data">' . get_field( 'instructions' ) . '</div><br>';

						  $appropriatefor 	= get_the_terms( get_the_ID(), 'appropriate-for' );
						  $keyword 			= get_the_terms( get_the_ID(), 'keyword' );
						  $difficultylevel 	= get_the_terms( get_the_ID(), 'difficulty-level' );
						  $recipecategory 	= get_the_terms( get_the_ID(), 'recipe-category' );

						  if ( $appropriatefor || $keyword || $difficultylevel || $recipecategory  ) {
						    echo '<div class="cpt-recipe-meta">';
						      if ( $appropriatefor ) {
						      	// echo count($appropriatefor);
						        echo '<p><strong>Appropriate For</strong>: ' . $appropriatefor[0]->name;
						        for ($i=1; $i < count($appropriatefor); $i++) echo ', ' . $appropriatefor[$i]->name;
						        echo '</p>';
						      }
						      if ( $keyword ) {
						        echo '<p><strong>Keyword(s)</strong>: ' . $keyword[0]->name;
						        for ($i=1; $i < count($keyword); $i++) echo ', ' . $keyword[$i]->name;
						        echo '</p>';
						      }
						      if ( $difficultylevel ) {
						        echo '<p><strong>Difficulty Level</strong>: ' . $difficultylevel[0]->name . '</p>';
						      }
						      if ( $recipecategory ) {
						        echo '<p><strong>Recipe Category</strong>: ' . $recipecategory[0]->name . '</p>';
						      }
						      echo '</div>';
						  }

					}
						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );

					?>
					</div> <!-- .entry-content -->


				<?php if ( ! $is_page_builder_used || ( $is_page_builder_used && 'on' === $show_navigation ) ) : ?>

					<div class="nav-single clearfix">
						<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . et_get_safe_localization( _x( '&larr;', 'Previous post link', 'Divi' ) ) . '</span> %title' ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . et_get_safe_localization( _x( '&rarr;', 'Next post link', 'Divi' ) ) . '</span>' ); ?></span>
					</div><!-- .nav-single -->

				<?php endif; ?>

				</article> <!-- .et_pb_post -->

			<?php
				if ( ! $is_page_builder_used && comments_open() && 'on' == et_get_option( 'divi_show_postcomments', 'on' ) )
					comments_template( '', true );
			?>
			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

			<?php if ( 'et_full_width_page' === $page_layout ) et_pb_portfolio_meta_box(); ?>

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); 

function cws_print_my_cp_taxes ( $my_recipe_terms ) {
echo count($my_recipe_terms) . "<br>";
  for ($i=0; $i < count($my_recipe_terms); $i++) { 
    // echo "$i ";
    // echo $my_recipe_terms[$i] . "<br>";
    $my_terms = $my_recipe_terms[$i]->name;
    if( $my_terms ): ?>
      <div class="recipe_term_name"><?php echo $my_recipe_terms[$i] .": "; ?>
      <ul>

      <?php foreach( $my_terms as $term ): ?>

        <div class="recipe_term_meta"><?php echo $term->name; ?>
        <a href="<?php echo get_term_link( $term ); ?>">View all '<?php echo $term->name; ?>' posts</a>
      <?php endforeach; ?>

      </ul></div>

      <?php endif; ?>
    </div><?php
  }

}


?>