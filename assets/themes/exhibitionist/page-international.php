<?php
add_action('genesis_before_footer','msdlab_do_footer_widget', 1);
//add_action('genesis_before_content','msd_international_map', 0);
//add_action('wp_enqueue_scripts','msd_international_style');

genesis();

function msd_international_map(){
    remove_action('genesis_before_entry','msd_post_image');
    print '<div class="section-map-area">';
    print '<div class="wrap">';
    print do_shortcode('[location_section]');
    print '</div>';
    print '</div>';
}

function msd_international_style(){
    wp_enqueue_style('international',get_stylesheet_directory_uri().'/lib/css/international.css');
    wp_enqueue_script('international',get_stylesheet_directory_uri().'/lib/js/international.js',array('jquery','bootstrap-jquery','msd-jquery'));
}
