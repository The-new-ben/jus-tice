<div class="search-bar">
    <div class="container">
        <?php echo do_shortcode('[searchandfilter id="335"]');?>
    </div>
    <?php
    //Get an array of objects containing data for the current search/filter
    //replace `1526` with the ID of your search form
    global $searchandfilter;
    $sf_current_query = $searchandfilter->get(335)->current_query();
    echo $sf_current_query->get_search_term();
    ?>
</div>
