<?php
/**
 * Searchform
 *
 * Custom template for search form
 */
?>

<!-- BEGIN of search form -->
<form method="get" id="searchform" class="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" name="s" id="s" class="search__input" placeholder="<?php _e( 'Search', 'foundation' ); ?>" value="<?php echo get_search_query(); ?>"/>
	<button type="submit" name="submit" class="search__submit" id="searchsubmit"><i class="fa fa-search"></i></button>
</form>
<!-- END of search form -->
