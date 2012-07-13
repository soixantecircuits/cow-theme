<?php $sq = get_search_query() ? get_search_query() : 'rechercher'; ?>
<form method="post" class="search-form" id="searchform" action="<?php bloginfo('home'); ?>">
	<fieldset>
		<legend class="hidden">Search form</legend>
		<input accesskey="4" type="text" name="s" class="text"  value="<?php echo $sq; ?>" title="rechercher" />
		<input type="submit" class="submit" value="ok" />
	</fieldset>
</form>
