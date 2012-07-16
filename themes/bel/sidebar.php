<?php if(is_front_page()):?>
<?php if (is_active_sidebar('default-sidebar')) : ?>
	<div class="aside">
		<?php dynamic_sidebar('default-sidebar'); ?>	
	</div>
<?php endif; ?>
<?php elseif(is_single() || is_page()): ?>
	<div class="aside"><?php
		$i = 0;
		$side_image = get_post_meta(get_the_ID(),'_simple_fields_fieldGroupID_4_fieldID_1_numInSet_'.$i,true);
		while ($side_image) { ?>
			<div class="box-image box-image-normal">
				<img class="png" src="<?php echo wp_get_attachment_url($side_image, 'thumbnail'); ?>" alt="image description" width="237" height="188" />
			</div><?php
			$i++;
			$side_image = get_post_meta(get_the_ID(),'_simple_fields_fieldGroupID_4_fieldID_1_numInSet_'.$i,true);
		}
		$i = 0;
		$side_image = get_post_meta(get_the_ID(),'_simple_fields_fieldGroupID_5_fieldID_1_numInSet_'.$i,true);
		while ($side_image) { ?>
			<div class="box-image box-image-small">
				<img class="png" src="<?php echo wp_get_attachment_url($side_image, 'thumbnail'); ?>" alt="image description" width="179" height="146" />
			</div><?php
			$i++;
			$side_image = get_post_meta(get_the_ID(),'_simple_fields_fieldGroupID_5_fieldID_1_numInSet_'.$i,true);
		} ?>
	</div><?php
endif;?>
