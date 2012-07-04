<?php
/*
Template Name: Home Template
*/
get_header(); ?>

<?php get_sidebar(); ?>

<?php if (function_exists('print_home_slider')) {
	print_home_slider();
} ?>

<!--
<div id="content">
	<div class="block-gallery">
		<div class="gallery">
			<ul>
				<li class="active">
					<div class="area">
						<img class="png" src="<?php bloginfo('template_url'); ?>/images/img01.png" alt="image description" width="488" height="306" />
						<strong>VIETNAM</strong>
					</div>
					<div class="info-panel">
						<strong class="location">VIETNAM</strong>
						<div class="holder">
							<h2>Un Enfant Par La Main</h2>
							<p>Une association qui a pour mission de soutenir les enfants et les familles les plus pauvres grâce au parrainage d'enfants.</p>
						</div>
						<a href="#" class="link">en savoir</a>
					</div>
				</li>
				<li>
					<div class="area">
						<img class="png" src="<?php bloginfo('template_url'); ?>/images/img01.png" alt="image description" width="488" height="306" />
						<strong>VIETNAM</strong>
					</div>
					<div class="info-panel">
						<strong class="location">VIETNAM</strong>
						<div class="holder">
							<h2>Un Enfant Par La Main</h2>
							<p>Une association qui a pour mission de soutenir les enfants et les familles les plus pauvres grâce au parrainage d'enfants.</p>
						</div>
						<a href="#" class="link">en savoir</a>
					</div>
				</li>
			</ul>
		</div>
		<ul class="switcher">
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
		</ul>
	</div>
</div>
-->


<?php get_footer(); ?>
