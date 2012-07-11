<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header(); ?>
<div class="container-holder hfeed">
	<div class="container-frame hentry">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

	<div class="heading">
		<h3><?php _e('Pages') ?></h3>
		<ul class="sitemap">
			<?php wp_list_pages('depth=0&sort_column=menu_order&title_li=' ); ?>
		</ul>
		<h3><?php _e('Catégories') ?></h3>
		<ul class="sitemap">
			<?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
		</ul>
		<h3>Articles par catégories</h3>
		<?php $saved = $wp_query;
		$cats = get_categories();
		foreach ($cats as $cat) {
			query_posts('showposts=999&cat='.$cat->cat_ID);
			?>
			<h4><?php echo $cat->cat_name; ?></h4>
			<ul class="sitemap">
			<?php while (have_posts()) : the_post(); ?>
			<li style= "font-weight:normal !important; "><a href= "<?php the_permalink() ?> "><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			</ul><?php
		} 
		$wp_query = $saved; ?>
	
	</div>
	</div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
