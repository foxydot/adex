<?php
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
add_action( 'genesis_before_loop', 'msdlab_do_cpt_archive_title_description' );


genesis();
?>