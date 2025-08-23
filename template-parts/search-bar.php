<div class="search-bar">
    <div class="container">
        <?php if ( shortcode_exists( 'searchandfilter' ) ) : ?>
            <?= do_shortcode( '[searchandfilter id="335"]' ); ?>
        <?php endif; ?>
    </div>
    <?php
    global $searchandfilter;
    if ( isset( $searchandfilter ) ) {
        $sf_current_query = $searchandfilter->get( 335 )->current_query();
        echo $sf_current_query->get_search_term();
    }
    ?>
</div>
