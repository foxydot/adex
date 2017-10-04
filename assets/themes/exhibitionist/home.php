<?php
add_action('genesis_entry_header','genesis_do_post_title'); //move the title out of the content area
remove_action('msdlab_title_area','msdlab_do_section_title');
add_action('msdlab_title_area','msdlab_do_blog_title');


add_action( 'genesis_entry_header', 'genesis_post_info', 12 ); //remove the info (date, posted by,etc.)
//add_action( 'genesis_entry_footer', 'genesis_post_meta'); //remove the meta (filed under, tags, etc.)


function msdlab_do_blog_title(){
    $page_for_posts = get_option( 'page_for_posts' );
    $blog = get_post($page_for_posts);
    print '<h2 class="section-title">';
    print $blog->post_title;
    print '</h2>';
}

genesis();
