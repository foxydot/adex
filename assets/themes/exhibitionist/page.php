<?
add_action('genesis_before_footer','msdlab_do_footer_widget', 1);

function msdlab_do_footer_widget(){
    print '<div id="page_footer_widget" class="page-footer-widget">';
    if(is_active_sidebar('msdlab_page_footer')){
        dynamic_sidebar('msdlab_page_footer');
    }
    print '</div>';
}

genesis();