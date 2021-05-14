<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" value="<?php echo get_search_query(); ?>" placeholder="Search" name="s" id="s" aria-label="Search"/>
    <button type="submit" class="i_search" aria-label="Search"></button>
</form>