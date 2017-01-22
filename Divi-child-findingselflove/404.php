<?php get_header(); ?>
<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">
				<article id="post-0" <?php post_class( 'et_pb_post not_found' ); ?>>
					<div class="entry">
					<!--If no results are found-->
						<h1><?php esc_html_e('Take a deep breath and try to relax.','Divi'); ?></h1>
						<img src="/wp-content/uploads/404-image-1024x678.jpg" alt="Soothing picture of water beading on green leaf" width="1024" height="678" class="alignnone size-large" />
						<h2><?php esc_html_e('We couldn\'t find that page.','Divi'); ?></h2><br>						
						<p><?php esc_html_e('You have come across an area on our site where nothing currently exists. I’m sure this is frustrating, especially if you were directed to that address by another page. We’ll get you back on track.','Divi');?></p>
						<p><?php esc_html_e('Check out the navigation bar at the top, or the lists below and see if they don’t help a little.','Divi');?></p><br>
						<?php get_template_part( 'sitemap'); ?>


				</article> <!-- .et_pb_post -->
			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>