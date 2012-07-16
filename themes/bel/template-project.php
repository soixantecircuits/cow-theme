<?php
/*
Template Name: Project Template
*/
get_header();
define("GOOGLE_API_KEY", "AIzaSyBPKfVRYAxtPj4vd9WIcLJU3HTBAyLbnbg");
?>

<div class="container-holder">
	<div class="container-frame">
		<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>
				<div class="heading">
					<h2><?php the_title(); ?></h2>
				</div>
				<!-- section-map -->
				<div class="section-map">
					<?php $marker_array = array(); ?>
					<div id="map_canvas" style="width:100%; height:450px;"></div>
					<?php the_content(); ?>
				</div>
			<?php endwhile;?>
		<?php else: ?>
			<div class="heading">
				<h2>Not Found</h2>
			</div>
			<!-- section-map -->
			<div class="section-map">
				<p><?php _e("Désolé, mais la page demandé n'existe pas.", "bel") ?></p>
			</div>
		<?php endif; ?>
		<div class="columns"><?php 
			$pro_taxonomy = "project-categories";
			$project = "projects";
			$counter = 1;
			$terms = get_terms($pro_taxonomy,'hide_empty=0&parent=0');
			$total = count($terms);
			$percol = (int)($total / 2);
			if($total % 2 != 0 && $total > 1 ) $percol++; ?>
				<div class="column">
			<?php if($terms)foreach($terms as $term):
					if ($term->name != "Associations") :?>
					<h4><?php echo $term->name; ?></h4>
					<?php $termchildren = get_term_children( $term->term_id, $pro_taxonomy); ?>
					<?php $sub_child_posts ='';?>
						<?php if(isset($post_not)){
										$post_not = $post_not;
									}else{
										$post_not=null;
									}
						$args= array('post_type' => $project,'post__not_in' => $post_not,'orderby' => 'title', 'posts_per_page' => '-1', 'order' => 'ASC', 'tax_query' => array( array('taxonomy' => $pro_taxonomy,
										'field' => 'id','terms' => $term->term_id))); 
							query_posts($args);
						?>
						<?php if (have_posts() || $sub_child_posts) : ?>
							<ul>	
								<?php while (have_posts()) : the_post();
								$post_meta = get_post_meta(get_the_ID(), "_simple_fields_fieldGroupID_6_fieldID_1_numInSet_0", true); ?>
								<li class="<?php echo get_post_meta(get_the_ID(), "project_type", true); ?><?php echo $post_meta != null ? $post_meta : ''; ?>"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></li>
								<?php
									array_push($marker_array, array(
										'title' => get_the_title(), 'link' => get_permalink(),
										'lat' => get_post_meta(get_the_ID(), "_wp_geo_latitude", true), 
										'lng' => get_post_meta(get_the_ID(), "_wp_geo_longitude", true),
										'excerpt' => get_post(get_the_ID())->post_excerpt
									));
								?>
								<?php endwhile;?>
								<?php if($sub_child_posts) echo $sub_child_posts;?>
							</ul>
						
						<?php endif;  ?>
						<?php if($counter == $percol && $percol > 1 ) echo '</div><div class="column">';?>
				<?php $counter++; endif; endforeach;  wp_reset_query();?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var marker_array = <?php echo json_encode($marker_array); ?>
</script>
<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&sensor=false">
</script>
<script type="text/javascript"
	src="../wp-content/themes/bel/js/bel_google_maps.js">
</script>
<?php get_footer(); ?>
