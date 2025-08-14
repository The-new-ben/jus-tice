<div id="sidebar1" class="sidebar col-md-4 col-lg-3" role="complementary">

    <?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

        <?php dynamic_sidebar( 'sidebar1' ); ?>

    <?php else : ?>

        <?php
        /*
         * This content shows up if there are no widgets defined in the backend.
        */
        ?>


    <?php endif; ?>

</div>
